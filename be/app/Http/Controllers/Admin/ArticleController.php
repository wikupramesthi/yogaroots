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
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $articles = Article::query();

        if ($start_date) {
            $articles->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date) {
            $articles->whereDate('created_at', '<=', $end_date);
        }

        $articles = $articles
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.articles.index', compact(
            'articles',
            'start_date',
            'end_date'
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
            'canonical_url' => route('articles.show', $article->slug),
        ]);

        return redirect()->route('articles.index')->with('success', 'Berita berhasil disimpan.');
    }
    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $sessionKey = 'article_viewed_' . $article->uuid;

        if (!session()->has($sessionKey)) {
            $article->increment('views');
            session()->put($sessionKey, true);
        }

        return view('articles.show', compact('article'));
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
                'featured_image' => $article->featured_image, // path dari upload di atas
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
                    'canonical_url' => route('articles.show', $article->slug),
                ]
            );

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupdate artikel: ' . $th->getMessage());
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
            return redirect()->back()->with('success', 'Berita berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $th->getMessage());
        }
    }
}
