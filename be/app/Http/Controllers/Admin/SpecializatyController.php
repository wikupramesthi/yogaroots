<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specializaty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SpecializatyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = Specializaty::withCount('programs')->get();
        $specializatyCounts = $specializations;

        return view('pages.specializations.index', compact('specializations', 'specializatyCounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:specializations,name',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            Specializaty::create([
                'uuid' => (string) Str::uuid(),
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Kategori spesialisasi berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($uuid, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:specializations,name,' . $uuid . ',uuid',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $item = Specializaty::where('uuid', $uuid)->firstOrFail();

            $item->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Kategori spesialisasi berhasil diperbarui.');
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
            $item = specializaty::where('uuid', $uuid)->firstOrFail();
            $item->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Kategori spesialisasi berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
