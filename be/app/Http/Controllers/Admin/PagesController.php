<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->get();
        return view('pages.halaman.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.halaman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'excerpt'         => 'nullable|string',
            'content'         => 'required|string',
            'featured_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published'    => 'required|in:0,1',
            'published_at'    => 'required|date',
            'has_sidebar'     => 'required|in:0,1',
        ]);

        DB::beginTransaction();
        try {
            $path = null;
            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('pages', 'public');
            }

            Page::create([
                'uuid'           => Str::uuid(),
                'title'          => $request->title,
                'slug'           => Str::slug($request->title),
                'excerpt'        => $request->excerpt,
                'content'        => $request->content,
                'featured_image' => $path,
                'is_published'   => $request->is_published,
                'published_at'   => $request->published_at ?? now(),
                'user_uuid'      => auth()->user()->uuid ?? null,
                'has_sidebar'    => $request->has_sidebar,
            ]);

            DB::commit();
            return redirect()->route('pages.index')->with('success', 'Halaman berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateSidebar($uuid)
    {
        $page = Page::where('uuid', $uuid)->firstOrFail();
        $page->update([
            'has_sidebar' => !$page->has_sidebar
        ]);

        return redirect()->route('pages.index')->with('success', 'Status sidebar berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $page = Page::where('uuid', $uuid)->firstOrFail();
        return view('pages.halaman.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'excerpt'        => 'required|string|max:500',
            'content'        => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published'   => 'required|in:0,1',
            'has_sidebar'    => 'required|in:0,1',
            'published_at'   => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $page = Page::where('uuid', $uuid)->firstOrFail();

            if ($request->hasFile('featured_image')) {
                if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
                    Storage::disk('public')->delete($page->featured_image);
                }
                $path = $request->file('featured_image')->store('pages', 'public');
            } else {
                $path = $page->featured_image;
            }

            $page->update([
                'title'          => $request->title,
                'slug'           => Str::slug($request->title),
                'excerpt'        => $request->excerpt,
                'content'        => $request->content,
                'featured_image' => $path,
                'is_published'   => $request->is_published,
                'has_sidebar'    => $request->has_sidebar,
                'published_at'   => $request->published_at,
            ]);

            DB::commit();
            return redirect()->route('pages.index')->with('success', 'Halaman berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $page = Page::where('uuid', $uuid)->firstOrFail();

            if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $page->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Halaman berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
