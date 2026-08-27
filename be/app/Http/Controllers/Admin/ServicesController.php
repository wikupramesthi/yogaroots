<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ServicesController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('kategori_layanan')) {
            $query->where('kategori_layanan', $request->kategori_layanan);
        }

        $items = $query->latest()->get();

        return view('pages.layanan.index', compact('items'));
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
            'judul'   => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'link'   => 'nullable',
            'icon' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori_layanan' => 'required|in:ekstrakurikuler,kegiatan,bimbingan',
            'color' => 'required|in:blue,orange,green,red,yellow,purple,cyan,pink,teal,brown',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $path = $request->file('icon')->store('layanan', 'public');

            Service::create([
                'uuid'   => Str::uuid(),
                'judul'   => $request->judul,
                'deskripsi'   => $request->deskripsi,
                'link'   => $request->link,
                'icon' => $path,
                'kategori_layanan' => $request->kategori_layanan,
                'color' => $request->color,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Kegiatan siswa berhasil ditambahkan.');
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
            'judul'   => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'link'   => 'nullable',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kategori_layanan' => 'required|in:ekstrakurikuler,kegiatan,bimbingan',
            'color' => 'required|in:blue,orange,green,red,yellow,purple,cyan,pink,teal,brown',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $service = Service::findOrFail($uuid);

            $data = [
                'judul'   => $request->judul,
                'deskripsi'   => $request->deskripsi,
                'link'   => $request->link,
                'kategori_layanan' => $request->kategori_layanan,
                'color' => $request->color,
                'status' => $request->status,
            ];

            if ($request->hasFile('icon')) {
                if ($service->icon && Storage::disk('public')->exists($service->icon)) {
                    Storage::disk('public')->delete($service->icon);
                }
                $data['icon'] = $request->file('icon')->store('layanan', 'public');
            }

            $service->update($data);

            DB::commit();
            return redirect()->back()->with('success', 'Kegiatan siswa berhasil diperbarui.');
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
            $service = Service::findOrFail($uuid);

            if ($service->icon && Storage::disk('public')->exists($service->icon)) {
                Storage::disk('public')->delete($service->icon);
            }

            $service->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Kegiatan siswa berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
