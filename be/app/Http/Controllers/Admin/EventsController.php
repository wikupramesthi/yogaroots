<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Event::query();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal mulai
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        // Filter tanggal selesai
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $items = $query
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('pages.event.index', [
            'title' => 'Event',
            'items' => $items,
            'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
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
            'judul'          => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'gambar'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'nullable|date_format:H:i',
            'waktu_selesai'  => 'nullable|date_format:H:i|after_or_equal:waktu_mulai',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'status'         => 'required|in:draft,published,cancelled,completed',
        ]);

        DB::beginTransaction();

        try {
            $path = $request->file('gambar')->store('events', 'public');

            Event::create([
                'uuid'          => Str::uuid(),
                'judul'         => $request->judul,
                 'slug'          => Str::slug($request->judul),
                'excerpt'       => $request->excerpt,
                'deskripsi'     => $request->deskripsi,
                'gambar'        => $path,
                'tanggal'       => $request->tanggal,
                'waktu_mulai'   => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'lokasi'        => $request->lokasi,
                'kapasitas'     => $request->kapasitas,
                'status'        => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Event berhasil ditambahkan.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
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
        $item = Event::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'judul'          => 'required|string|max:255',
            'deskripsi'      => 'required|string',
            'gambar'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'nullable|date_format:H:i',
            'waktu_selesai'  => 'nullable|date_format:H:i|after_or_equal:waktu_mulai',
            'lokasi'         => 'nullable|string|max:255',
            'kapasitas'      => 'nullable|integer|min:1',
            'status'         => 'required|in:draft,published,cancelled,completed',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->only([
                'judul',
                'slug',
                'deskripsi',
                'tanggal',
                'waktu_mulai',
                'waktu_selesai',
                'lokasi',
                'kapasitas',
                'status',
            ]);

            // Kalau upload gambar baru
            if ($request->hasFile('gambar')) {

                // Hapus gambar lama
                if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                    Storage::disk('public')->delete($item->gambar);
                }

                // Simpan gambar baru
                $data['gambar'] = $request->file('gambar')->store('events', 'public');
            }

            $item->update($data);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Event berhasil diperbarui.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $item = Event::where('uuid', $uuid)->firstOrFail();

        DB::beginTransaction();

        try {
            // Hapus gambar
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }

            // Hapus data event
            $item->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Event berhasil dihapus.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
