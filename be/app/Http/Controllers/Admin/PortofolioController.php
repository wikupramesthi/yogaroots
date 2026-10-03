<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortofolioController extends Controller
{
    public function index()
    {
        $items = Portofolio::orderBy('nama', 'ASC')->get();
        return view('pages.portofolio.index', [
            'title' => 'Portofolio',
            'items' => $items
        ]);
    }

    public function create()
    {

        return view('pages.portofolio.create', [
            'title' => 'Add Portfolio'
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'excerpt' => ['required'],
            'gambar' => ['required', 'array'],
            'gambar.*' => ['image'],
            'kontrak' => ['required']
        ]);

        DB::beginTransaction();
        try {
            // $slug = request()->nama;
            $slug = Str::slug(request()->nama, '_');
            // $kontrak= request()->file('kontrak')->getClientOriginalName();
            // dd($slug);
            $data_kontrak = request()->file('kontrak');
            $cek = $data_kontrak->store('portofolio-gambar', 'public');
            $kontrak = basename($cek);

            // dd($kontrak);

            $data = request()->only(['nama', 'deskripsi', 'excerpt']);
            $data['slug'] = $slug;
            $data['kontrak'] = $kontrak;
            // dd($data);
            $data_gambar = request()->file('gambar');
            $portofolio = Portofolio::create($data);
            foreach ($data_gambar as $gambar) {
                $portofolio->gambar()->create([
                    'gambar' => $gambar->store('portofolio-gambar', 'public')
                ]);
            }
            DB::commit();
            return redirect()->route('portofolio.index')->with('success', 'Portfolio created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {

        $item = Portofolio::findOrFail($id);
        return view('pages.portofolio.edit', [
            'title' => 'Edit Portfolio',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required'],
            'deskripsi' => ['required'],
            'excerpt' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $slug = Str::slug(request()->nama, '_');

            $item = Portofolio::findOrFail($id);
            $data = request()->all();
            $data['slug'] = $slug;

            $item->update($data);
            DB::commit();
            return redirect()->route('portofolio.index')->with('success', 'Portfolio updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = Portofolio::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('portofolio.index')->with('success', 'Portfolio deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function kontak()
    {
        $kontaks = Kontak::latest()->get();
        return view('pages.kontak.index', compact('kontaks'));
    }

     public function forceDelete($id)
    {
        DB::beginTransaction();
        try {
            $item = Kontak::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Incoming message deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
