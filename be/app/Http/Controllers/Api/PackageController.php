<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PackageController extends Controller
{
    /**
     * Menampilkan daftar package.
     *
     * Query:
     *
     * ?search=yoga
     * ?filter=popular
     * ?filter=unlimited
     * ?sort=popular
     * ?sort=lowest_price
     * ?page=1
     * ?per_page=10
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'search' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'filter' => [
                    'nullable',
                    'in:popular,unlimited',
                ],

                'sort' => [
                    'nullable',
                    'in:popular,lowest_price',
                ],

                'page' => [
                    'nullable',
                    'integer',
                    'min:1',
                ],

                'per_page' => [
                    'nullable',
                    'integer',
                    'min:1',
                    'max:50',
                ],
            ]);


            /*
             * BASE QUERY
             */
            $query = Package::query()
                ->where('is_active', true)
                ->with([
                    'options' => function ($query) {
                        $query
                            ->where('is_active', true)
                            ->orderBy('sort_order');
                    },

                    'features' => function ($query) {
                        $query->orderBy('sort_order');
                    },
                ]);


            /*
             * SEARCH
             */
            if ($request->filled('search')) {

                $search = trim(
                    $request->input('search')
                );

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'description',
                            'like',
                            '%' . $search . '%'
                        );
                });
            }


            /*
             * FILTER
             */
            if ($request->input('filter') === 'popular') {

                $query->where(
                    'is_popular',
                    true
                );
            }


            if ($request->input('filter') === 'unlimited') {

                $query->whereHas(
                    'options',
                    function ($q) {
                        $q->whereNull('quota');
                    }
                );
            }


            /*
             * SORT
             *
             * Harga menggunakan FINAL PRICE:
             *
             * discount_price jika lebih kecil dari price,
             * jika tidak menggunakan price.
             */
            $priceSubquery = "
                (
                    SELECT MIN(
                        CASE
                            WHEN discount_price IS NOT NULL
                                 AND discount_price < price
                            THEN discount_price
                            ELSE price
                        END
                    )
                    FROM package_options
                    WHERE package_options.package_uuid = packages.uuid
                    AND package_options.is_active = 1
                )
            ";


            switch ($request->input('sort')) {

                /*
                 * POPULAR
                 *
                 * Popular di atas.
                 * Jika sama-sama popular,
                 * harga terendah di atas.
                 */
                case 'popular':

                    $query
                        ->orderByDesc('is_popular')
                        ->orderByRaw($priceSubquery . ' ASC')
                        ->orderBy('name');

                    break;


                /*
                 * LOWEST PRICE
                 */
                case 'lowest_price':

                    $query
                        ->orderByRaw(
                            $priceSubquery . ' ASC'
                        )
                        ->orderByDesc('is_popular')
                        ->orderBy('name');

                    break;


                /*
                 * DEFAULT
                 *
                 * Popular terlebih dahulu,
                 * kemudian harga terendah.
                 */
                default:

                    $query
                        ->orderByDesc('is_popular')
                        ->orderByRaw($priceSubquery . ' ASC')
                        ->orderBy('name');

                    break;
            }


            /*
             * PAGINATION
             */
            $perPage = $request->input(
                'per_page',
                10
            );

            $packages = $query->paginate(
                $perPage
            );


            /*
             * RESPONSE
             */
            return response()->json([

                'status' => 'success',

                'message' => $packages->isEmpty()
                    ? 'Belum ada package yang tersedia'
                    : 'Data package berhasil diambil',

                'data' => PackageResource::collection(
                    $packages->items()
                ),

                'meta' => [

                    'current_page' =>
                    $packages->currentPage(),

                    'per_page' =>
                    $packages->perPage(),

                    'total' =>
                    $packages->total(),

                    'last_page' =>
                    $packages->lastPage(),

                    'from' =>
                    $packages->firstItem(),

                    'to' =>
                    $packages->lastItem(),

                ],

            ], 200);
        } catch (ValidationException $e) {

            return response()->json([

                'status' => 'error',

                'message' =>
                'Parameter yang dikirim tidak valid',

                'errors' => $e->errors(),

                'data' => [],

            ], 422);
        } catch (\Throwable $e) {

            Log::error(
                'Package index error: ' . $e->getMessage(),
                [
                    'request' =>
                    $request->all(),

                    'trace' =>
                    $e->getTraceAsString(),
                ]
            );

            return response()->json([

                'status' => 'error',

                'message' =>
                'Gagal mengambil data package',

                'data' => [],

            ], 500);
        }
    }


    /**
     * Detail package berdasarkan slug.
     */
    public function show(string $slug): JsonResponse
    {
        try {

            $package = Package::query()
                ->where(
                    'slug',
                    $slug
                )
                ->where(
                    'is_active',
                    true
                )
                ->with([
                    'options' => function ($query) {
                        $query
                            ->where(
                                'is_active',
                                true
                            )
                            ->orderBy(
                                'sort_order'
                            );
                    },

                    'features' => function ($query) {
                        $query->orderBy(
                            'sort_order'
                        );
                    },
                ])
                ->firstOrFail();


            return response()->json([

                'status' => 'success',

                'message' =>
                'Detail package berhasil diambil',

                'data' =>
                new PackageResource($package),

            ], 200);
        } catch (ModelNotFoundException $e) {

            return response()->json([

                'status' => 'error',

                'message' =>
                'Package tidak ditemukan',

                'data' => null,

            ], 404);
        } catch (\Throwable $e) {

            Log::error(
                'Package show error: ' . $e->getMessage(),
                [
                    'slug' => $slug,

                    'trace' =>
                    $e->getTraceAsString(),
                ]
            );

            return response()->json([

                'status' => 'error',

                'message' =>
                'Terjadi kesalahan saat mengambil detail package',

                'data' => null,

            ], 500);
        }
    }
}
