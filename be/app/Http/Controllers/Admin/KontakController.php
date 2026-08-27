<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $kontak = Kontak::first();
        return view('admin.pages.kontak.index', [
            'title' => 'Kelola Kontak',
            'item' => $kontak
        ]);
    }

    public function update()
    {
        $data = request()->all();
        $kontak = Kontak::first();
        if ($kontak)
            $kontak->update($data);
        else
            Kontak::create($data);
        return redirect()->back()->with('success', 'Kontak berhasil disimpan.');
    }
}
