<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disability;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DisabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disabilities = Disability::withCount('programs')->get();
        $disabilityCounts = $disabilities;

        return view('pages.disabilities.index', compact('disabilities', 'disabilityCounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:disabilities,name',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            Disability::create([
                'uuid' => (string) Str::uuid(),
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Kategori disabilitas berhasil ditambahkan.');
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
            'name' => 'required|unique:disabilities,name,' . $uuid . ',uuid',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $item = Disability::where('uuid', $uuid)->firstOrFail();

            $item->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Kategori disabilitas berhasil diperbarui.');
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
            $item = Disability::where('uuid', $uuid)->firstOrFail();
            $item->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Kategori disabilitas berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
