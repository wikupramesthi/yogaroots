<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package\Package;
use App\Models\Package\PackageOption;
use App\Models\Package\PackageFeature;
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
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'required',
                'in:active,inactive',
            ],

            'is_popular' => [
                'nullable',
                'boolean',
            ],

            'options' => [
                'required',
                'array',
                'min:1',
            ],

            'options.*.name' => [
                'required',
                'string',
                'max:255',
            ],

            'options.*.quota' => [
                'required',
                'integer',
                'min:1',
            ],

            'options.*.price' => [
                'required',
                'integer',
                'min:0',
            ],

            'options.*.discount_price' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'options.*.duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'options.*.duration_unit' => [
                'required',
                'in:day,week,month,year',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        /*
    |--------------------------------------------------------------------------
    | Validate Discount Price
    |--------------------------------------------------------------------------
    */

        foreach ($validated['options'] as $index => $option) {

            if (
                isset($option['discount_price']) &&
                $option['discount_price'] !== null &&
                $option['discount_price'] >= $option['price']
            ) {

                return back()
                    ->withErrors([
                        "options.$index.discount_price" =>
                        'Discounted price must be lower than regular price.'
                    ])
                    ->withInput();
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Save Package
    |--------------------------------------------------------------------------
    */

        DB::transaction(function () use ($validated) {

            /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug
        |--------------------------------------------------------------------------
        */

            $baseSlug = Str::slug($validated['name']);

            if ($baseSlug === '') {
                $baseSlug = 'package';
            }

            $slug = $baseSlug;
            $counter = 2;

            while (
                Package::where('slug', $slug)->exists()
            ) {

                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }


            /*
        |--------------------------------------------------------------------------
        | Create Package
        |--------------------------------------------------------------------------
        */

            $package = Package::create([

                'uuid' => (string) Str::uuid(),

                'name' => $validated['name'],

                'slug' => $slug,

                'description' =>
                $validated['description'] ?? null,

                'is_popular' =>
                $validated['is_popular'] ?? false,

                'is_active' =>
                $validated['is_active'],

            ]);


            /*
        |--------------------------------------------------------------------------
        | Create Package Options
        |--------------------------------------------------------------------------
        */

            foreach (
                array_values($validated['options'])
                as $index => $option
            ) {

                PackageOption::create([

                    'uuid' => (string) Str::uuid(),

                    'package_uuid' =>
                    $package->uuid,

                    'name' =>
                    $option['name'],

                    'quota' =>
                    $option['quota'],

                    'price' =>
                    $option['price'],

                    'discount_price' =>
                    $option['discount_price'] ?? null,

                    'duration' =>
                    $option['duration'],

                    'duration_unit' =>
                    $option['duration_unit'],

                    'sort_order' =>
                    $index,

                    'is_active' =>
                    true,

                ]);
            }


            /*
        |--------------------------------------------------------------------------
        | Create Package Features
        |--------------------------------------------------------------------------
        */

            foreach (
                $validated['features'] ?? []
                as $index => $feature
            ) {

                if (blank($feature)) {
                    continue;
                }

                PackageFeature::create([

                    'uuid' => (string) Str::uuid(),

                    'package_uuid' =>
                    $package->uuid,

                    'feature' =>
                    $feature,

                    'sort_order' =>
                    $index,

                ]);
            }
        });


        /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route('packages.index')
            ->with(
                'success',
                'Package created successfully.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $package = Package::with([
            'options' => function ($query) {
                $query->orderBy('sort_order');
            },
            'features' => function ($query) {
                $query->orderBy('sort_order');
            },
        ])->where('uuid', $uuid)->firstOrFail();

        return view('pages.package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $package = Package::where('uuid', $uuid)
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'required',
                'in:active,inactive',
            ],

            'is_popular' => [
                'nullable',
                'boolean',
            ],

            'options' => [
                'required',
                'array',
                'min:1',
            ],

            'options.*.name' => [
                'required',
                'string',
                'max:255',
            ],

            'options.*.quota' => [
                'required',
                'integer',
                'min:1',
            ],

            'options.*.price' => [
                'required',
                'integer',
                'min:0',
            ],

            'options.*.discount_price' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'options.*.duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'options.*.duration_unit' => [
                'required',
                'in:day,week,month,year',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        /*
    |--------------------------------------------------------------------------
    | Validate Discount
    |--------------------------------------------------------------------------
    */

        foreach ($validated['options'] as $index => $option) {

            if (
                isset($option['discount_price']) &&
                $option['discount_price'] !== null &&
                $option['discount_price'] >= $option['price']
            ) {

                return back()
                    ->withErrors([
                        "options.$index.discount_price" =>
                        'Discounted price must be lower than regular price.'
                    ])
                    ->withInput();
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Update Package
    |--------------------------------------------------------------------------
    */

        DB::transaction(function () use (
            $validated,
            $package
        ) {

            /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug
        |--------------------------------------------------------------------------
        */

            $baseSlug = Str::slug(
                $validated['name']
            );

            if ($baseSlug === '') {
                $baseSlug = 'package';
            }

            $slug = $baseSlug;
            $counter = 2;


            while (
                Package::where('slug', $slug)
                ->where('uuid', '!=', $package->uuid)
                ->exists()
            ) {

                $slug =
                    $baseSlug . '-' . $counter;

                $counter++;
            }


            /*
        |--------------------------------------------------------------------------
        | Update Package
        |--------------------------------------------------------------------------
        */

            $package->update([

                'name' =>
                $validated['name'],

                'slug' =>
                $slug,

                'description' =>
                $validated['description'] ?? null,

                'is_popular' =>
                $validated['is_popular'] ?? false,

                'is_active' =>
                $validated['is_active'],

            ]);


            /*
        |--------------------------------------------------------------------------
        | Replace Package Options
        |--------------------------------------------------------------------------
        */

            $package->options()->delete();


            foreach (
                array_values($validated['options'])
                as $index => $option
            ) {

                PackageOption::create([

                    'uuid' =>
                    (string) Str::uuid(),

                    'package_uuid' =>
                    $package->uuid,

                    'name' =>
                    $option['name'],

                    'quota' =>
                    $option['quota'],

                    'price' =>
                    $option['price'],

                    'discount_price' =>
                    $option['discount_price'] ?? null,

                    'duration' =>
                    $option['duration'],

                    'duration_unit' =>
                    $option['duration_unit'],

                    'sort_order' =>
                    $index,

                    'is_active' =>
                    true,

                ]);
            }


            /*
        |--------------------------------------------------------------------------
        | Replace Package Features
        |--------------------------------------------------------------------------
        */

            $package->features()->delete();


            foreach (
                $validated['features'] ?? []
                as $index => $feature
            ) {

                if (blank($feature)) {
                    continue;
                }

                PackageFeature::create([

                    'uuid' =>
                    (string) Str::uuid(),

                    'package_uuid' =>
                    $package->uuid,

                    'feature' =>
                    $feature,

                    'sort_order' =>
                    $index,

                ]);
            }
        });


        /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route('packages.index')
            ->with(
                'success',
                'Package updated successfully.'
            );
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
                ->route('packages.index')
                ->with('success', 'Package berhasil dihapus.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function members(Request $request)
    {

        $query = Package::with([
            'options' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order');
            },
            'features' => function ($query) {
                $query->orderBy('sort_order');
            },
        ])
            ->where('is_active', 'active');

        // FILTER
        if ($request->filter === 'popular') {

            $query->where('is_popular', true);
        } elseif ($request->filter === 'unlimited') {

            $query->whereHas('options', function ($query) {
                $query->whereNull('quota');
            });
        }

        $packages = $query->get();

        // SORT
        switch ($request->sort) {

            case 'price_low':

                $packages = $packages->sortBy(function ($package) {
                    return $package->options->min(
                        fn($option) =>
                        $option->discount_price ?? $option->price
                    );
                });

                break;

            case 'price_high':

                $packages = $packages->sortByDesc(function ($package) {
                    return $package->options->max(
                        fn($option) =>
                        $option->discount_price ?? $option->price
                    );
                });

                break;

            case 'duration_short':

                $packages = $packages->sortBy(function ($package) {
                    return $package->options->min(function ($option) {

                        return match ($option->duration_unit) {
                            'day'   => $option->duration,
                            'week'  => $option->duration * 7,
                            'month' => $option->duration * 30,
                            'year'  => $option->duration * 365,
                            default => $option->duration,
                        };
                    });
                });

                break;

            case 'duration_long':

                $packages = $packages->sortByDesc(function ($package) {
                    return $package->options->max(function ($option) {

                        return match ($option->duration_unit) {
                            'day'   => $option->duration,
                            'week'  => $option->duration * 7,
                            'month' => $option->duration * 30,
                            'year'  => $option->duration * 365,
                            default => $option->duration,
                        };
                    });
                });

                break;

            default:

                $packages = $packages
                    ->sortByDesc('is_popular')
                    ->values();

                break;
        }

        // =========================
        // MOBILE VIEW
        // =========================

        if (
            auth()->check() &&
            auth()->user()->hasRole('user') &&
            $request->header('User-Agent') &&
            preg_match('/Mobile|Android|iPhone|iPad/i', $request->header('User-Agent'))
        ) {
            return view(
                'pages.mobile.package',
                compact('packages')
            );
        }

        // =========================
        // DESKTOP VIEW
        // =========================

        return view(
            'pages.package.member',
            compact('packages')
        );
    }
}
