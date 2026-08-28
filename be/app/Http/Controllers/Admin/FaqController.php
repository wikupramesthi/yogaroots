<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Faq::orderBy('urutan', 'ASC')->get();
        return view('pages.faq.index', [
            'title' => 'FAQ & Answer',
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
            'pertanyaan' => 'required|string|max:255',
            'jawaban'    => 'required|string',
            'status' => 'required|in:active,inactive',
            'urutan' => 'required|integer|min:1|unique:faqs,urutan',

        ]);

        DB::beginTransaction();
        try {
            Faq::create([
                'uuid' => (string) Str::uuid(),
                'pertanyaan'  => $request->pertanyaan,
                'jawaban'     => $request->jawaban,
                'status'      => $request->status,
                'urutan'      => $request->urutan,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Faq dan Answer berhasil ditambahkan.');
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
    public function update($uuid, Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban'    => 'required|string',
            'urutan'     => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $item = Faq::where('uuid', $uuid)->firstOrFail();

            $item->update([
                'pertanyaan' => $request->pertanyaan,
                'jawaban'    => $request->jawaban,
                'urutan'     => $request->urutan,
                'status'     => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Faq dan Answer berhasil diperbarui.');
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
            $item = Faq::where('uuid', $uuid)->firstOrFail();
            $item->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Faq dan Answer berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function kontak()
    {
        $kontaks = Kontak::latest()->get();
        return view('pages.kontak.index', compact('kontaks'));
    }

    public function forceDelete($uuid)
    {
        try {
            $item = Kontak::where('uuid', $uuid)->firstOrFail();

            $item->delete();

            return redirect()
                ->back()
                ->with('success', 'Pesan masuk berhasil dihapus permanen.');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus pesan masuk.');
        }
    }
}
