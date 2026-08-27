<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $downloads = FileDownload::latest()->get();
        return view('pages.filedownload.index', compact('downloads'));
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
        request()->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kategori' => ['required', 'in:akademik,informasi,laporan,edaran'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['judul', 'deskripsi', 'kategori']);

            if (request()->hasFile('file')) {
                $data['file'] = request()->file('file')->store('downloads/pdf', 'public');
            }

            FileDownload::create($data);
            DB::commit();

            return redirect()->route('filedownloads.index')->with('success', 'Dokumen Sekolah berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
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
    public function update($id)
    {
        request()->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kategori' => ['required', 'in:akademik,informasi,laporan,edaran'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            $item = FileDownload::findOrFail($id);
            $data = request()->only(['judul', 'deskripsi', 'kategori']);

            if (request()->hasFile('file')) {
                Storage::disk('public')->delete($item->file);
                $data['file'] = request()->file('file')->store('downloads/pdf', 'public');
            }

            $item->update($data);
            DB::commit();

            return redirect()->back()->with('success', 'Dokumen Sekolah berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = FileDownload::findOrFail($id);
            if ($item->file) {
                Storage::disk('public')->delete($item->file);
            }
            $item->delete();
            DB::commit();

            return redirect()->route('filedownloads.index')->with('success', 'Dokumen Sekolah berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus file: ' . $th->getMessage());
        }
    }
}
