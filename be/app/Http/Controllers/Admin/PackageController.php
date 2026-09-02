<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Package::with('features');

    // Filter status
    if ($request->filled('is_active')) {
        $query->where('is_active', $request->is_active);
    }

    // Filter popular
    if ($request->filled('is_popular')) {
        $query->where('is_popular', $request->is_popular);
    }

    // Filter quota
    if ($request->filled('quota_type')) {
        if ($request->quota_type === 'unlimited') {
            $query->whereNull('quota');
        }

        if ($request->quota_type === 'limited') {
            $query->whereNotNull('quota');
        }
    }

    $packages = $query
        ->latest()
        ->get();

    return view('pages.package.index', compact('packages'));
}

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        return view('pages.package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:packages,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'nullable|integer|min:1',
            'duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:day,week,month,year',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'required|in:active,inactive',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            $package = Package::create([
                'uuid' => (string) Str::uuid(),
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'quota' => $request->quota,
                'duration' => $request->duration,
                'duration_unit' => $request->duration_unit,
                'is_popular' => $request->boolean('is_popular'),
                'is_active' => $request->is_active,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Package Features
            |--------------------------------------------------------------------------
            */

            if ($request->filled('features')) {

                foreach ($request->features as $index => $feature) {

                    if (blank($feature)) {
                        continue;
                    }

                    $package->features()->create([
                        'uuid' => (string) Str::uuid(),
                        'feature' => $feature,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.packages.index')
                ->with('success', 'Package berhasil ditambahkan.');

        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $package = Package::with('features')
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('pages.package.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $package = Package::with('features')
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('pages.package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($uuid, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:packages,name,' . $uuid . ',uuid',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'nullable|integer|min:1',
            'duration' => 'required|integer|min:1',
            'duration_unit' => 'required|in:day,week,month,year',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'required|in:active,inactive',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            $package = Package::where('uuid', $uuid)
                ->firstOrFail();

            $package->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quota' => $request->quota,
                'duration' => $request->duration,
                'duration_unit' => $request->duration_unit,
                'is_popular' => $request->boolean('is_popular'),
                'is_active' => $request->is_active,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Features
            |--------------------------------------------------------------------------
            */

            $package->features()->delete();

            if ($request->filled('features')) {

                foreach ($request->features as $index => $feature) {

                    if (blank($feature)) {
                        continue;
                    }

                    $package->features()->create([
                        'uuid' => (string) Str::uuid(),
                        'feature' => $feature,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.packages.index')
                ->with('success', 'Package berhasil diperbarui.');

        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
   public function destroy($uuid)
    {
        DB::beginTransaction();

        try {

            $package = Package::where('uuid', $uuid)
                ->firstOrFail();

            $package->delete();

            DB::commit();

            return redirect()
                ->route('admin.packages.index')
                ->with('success', 'Package berhasil dihapus.');

        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
