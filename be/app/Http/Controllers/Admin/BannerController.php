<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BannerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Banner::orderBy('nama', 'ASC')->get();
        return view('pages.banner.index', [
            'title' => 'Banner',
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'deskripsi' => 'nullable',
            'link'   => 'nullable',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'posisi' => 'required|in:slider,pengumuman,infografis,prestasi,popup,mitra,sarpras,lainnya',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $path = $request->file('gambar')->store('banners', 'public');

            Banner::create([
                'uuid'   => Str::uuid(),
                'nama'   => $request->nama,
                'deskripsi' => $request->deskripsi,
                'link'   => $request->link,
                'gambar' => $path,
                'posisi' => $request->posisi,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Banner berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $uuid)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'deskripsi' => 'nullable',
            'link'   => 'nullable',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'posisi' => 'required|in:slider,pengumuman,infografis,prestasi,popup,mitra,sarpras,lainnya',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $banner = Banner::findOrFail($uuid);

            $data = [
                'nama'   => $request->nama,
                'deskripsi' => $request->deskripsi,
                'link'   => $request->link,
                'posisi' => $request->posisi,
                'status' => $request->status,
            ];

            if ($request->hasFile('gambar')) {
                if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
                    Storage::disk('public')->delete($banner->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('banners', 'public');
            }

            $banner->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Banner berhasil diperbarui.');
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
            $banner = Banner::findOrFail($uuid);

            if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
                Storage::disk('public')->delete($banner->gambar);
            }

            $banner->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Banner berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
