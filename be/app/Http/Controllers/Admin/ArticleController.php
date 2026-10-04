<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ImageController;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $status = $request->get('status', '');
        $status = in_array($status, ['draft', 'published', 'scheduled'], true) ? $status : '';

        $baseQuery = Article::query()
            ->when($start_date, fn ($query) => $query->whereDate('created_at', '>=', $start_date))
            ->when($end_date, fn ($query) => $query->whereDate('created_at', '<=', $end_date))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search) . '%';
                $query->where(function ($w) use ($like) {
                    $w->where('title', 'like', $like)->orWhere('slug', 'like', $like);
                });
            });

        // Stats are computed from the filtered query (no pagination),
        // so the cards always match the filtered data.
        $stats = [
            'total'     => (clone $baseQuery)->count(),
            'published' => (clone $baseQuery)->where('status', 'published')->count(),
            'draft'     => (clone $baseQuery)->where('status', 'draft')->count(),
            'scheduled' => (clone $baseQuery)->where('status', 'scheduled')->count(),
        ];

        $articles = $baseQuery
            ->with(['user', 'category'])
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('pages.articles.index', compact(
            'articles',
            'stats',
            'search',
            'start_date',
            'end_date',
            'status'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('slug', 'asc')->get();
        return view('pages.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|max:255|unique:articles,title',
            'excerpt'        => 'nullable|max:255',
            'content'        => 'required',
            'category_uuid'  => 'required|exists:categories,uuid',
            'scheduled_at'   => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tagging'        => 'nullable|string|max:255',
            'video'          => 'nullable',
            'status'         => 'required|in:draft,published,scheduled',
            'search_engine'  => 'required|in:index,noindex',
        ]);

        $article = new Article();
        $article->uuid          = Str::uuid();
        $article->user_uuid     = auth()->user()->uuid;
        $article->category_uuid = $validated['category_uuid'];
        $article->title         = $validated['title'];
        $article->slug          = Str::slug($validated['title']);
        $article->excerpt       = $validated['excerpt'] ?? null;
        $article->content       = $validated['content'];
        $article->scheduled_at  = $validated['scheduled_at'] ?? null;
        $article->tagging       = $validated['tagging'] ?? null;
        $article->video         = $validated['video'] ?? null;
        $article->status        = $validated['status'];
        $article->search_engine = $validated['search_engine'];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('images', 'public');
            $article->featured_image = $path;
        }

        $article->save();

        $article->seo()->updateOrCreate([], [
            'title'         => $article->title,
            'description'   => $article->excerpt,
            'image'         => $article->featured_image,
            'author'        => auth()->user()->name,
            'robots'        => $request->search_engine ?? 'index, follow',
            'canonical_url' => config('frontend.url') . '/blog/' . $article->slug,
        ]);

        return redirect()->route('articles.index')->with('success', 'News saved successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Article $article)
    {
        $categories = Category::orderBy('slug', 'asc')->get();
        return view('pages.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($uuid, Request $request)
    {
        DB::beginTransaction();

        try {
            $article = Article::where('uuid', $uuid)->firstOrFail();


            if ($request->hasFile('featured_image')) {
                if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                    Storage::disk('public')->delete($article->featured_image);
                }

                $path = $request->file('featured_image')->store('images', 'public');

                $article->featured_image = $path;
            }

            $article->update([
                'category_uuid' => $request->category_uuid,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'excerpt' => $request->excerpt,
                'content' => $request->content,
                'scheduled_at' => $request->scheduled_at,
                'tagging' => $request->tagging,
                'video' => $request->video,
                'status' => $request->status,
                'search_engine' => $request->search_engine ?? 'index',
                'featured_image' => $article->featured_image, // path from the upload above
            ]);


            $article->seo()->updateOrCreate(
                [
                    'model_id' => $article->id,
                    'model_type' => Article::class,
                ],
                [
                    'title' => $request->title,
                    'description' => $request->excerpt,
                    'image' => $article->featured_image, // path storage
                    'author' => auth()->user()->name,
                    'robots' => $request->search_engine ?? 'index, follow',
                    'canonical_url' => config('frontend.url') . '/blog/' . $article->slug,
                ]
            );

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update article: ' . $th->getMessage());
        }
    }
    /**
     * Remove the selected articles along with their files.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (! is_array($ids) || empty($ids)) {
            return back()->with('error', 'No articles selected.');
        }

        $ids = array_slice(array_values(array_unique(array_filter($ids))), 0, 100);

        $articles = Article::whereIn('uuid', $ids)->get();

        if ($articles->isEmpty()) {
            return back()->with('error', 'Selected data not found.');
        }

        DB::beginTransaction();
        try {
            foreach ($articles as $article) {
                if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                    Storage::disk('public')->delete($article->featured_image);
                }
                $article->delete();
            }

            DB::commit();
            return back()->with('success', $articles->count() . ' articles deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $article = Article::where('uuid', $uuid)->firstOrFail();

            if ($article->featured_image && Storage::disk('public')->exists($article->featured_image)) {
                Storage::disk('public')->delete($article->featured_image);
            }

            $article->delete();

            DB::commit();
            return redirect()->back()->with('success', 'News deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete: ' . $th->getMessage());
        }
    }
}
