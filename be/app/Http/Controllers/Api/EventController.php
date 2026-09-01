<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    /**
     * Menampilkan daftar event.
     *
     * Query:
     *
     * ?search=yoga
     * ?filter=today
     * ?filter=week
     * ?filter=month
     * ?date_from=2026-09-01
     * ?date_to=2026-09-30
     * ?page=1
     * ?per_page=10
     *
     * Filter dapat dikombinasikan.
     */
    public function index(Request $request): JsonResponse
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDASI QUERY PARAMETER
            |--------------------------------------------------------------------------
            */

            $request->validate([
                'search' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'filter' => [
                    'nullable',
                    'in:today,week,month',
                ],

                'date_from' => [
                    'nullable',
                    'date',
                ],

                'date_to' => [
                    'nullable',
                    'date',
                    'after_or_equal:date_from',
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
            |--------------------------------------------------------------------------
            | QUERY DASAR
            |--------------------------------------------------------------------------
            */

            $query = Event::query()
                ->where('status', 'published');


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = trim($request->input('search'));

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'judul',
                        'like',
                        '%' . $search . '%'
                    );

                });
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER CEPAT
            |--------------------------------------------------------------------------
            */

            if ($request->filled('filter')) {

                switch ($request->input('filter')) {

                    /*
                    |--------------------------------------------------------------------------
                    | HARI INI
                    |--------------------------------------------------------------------------
                    */

                    case 'today':

                        $query->whereDate(
                            'tanggal',
                            Carbon::today()
                        );

                        break;


                    /*
                    |--------------------------------------------------------------------------
                    | MINGGU INI
                    |--------------------------------------------------------------------------
                    */

                    case 'week':

                        $query->whereBetween(
                            'tanggal',
                            [
                                Carbon::now()
                                    ->startOfWeek()
                                    ->toDateString(),

                                Carbon::now()
                                    ->endOfWeek()
                                    ->toDateString(),
                            ]
                        );

                        break;


                    /*
                    |--------------------------------------------------------------------------
                    | BULAN INI
                    |--------------------------------------------------------------------------
                    */

                    case 'month':

                        $query->whereBetween(
                            'tanggal',
                            [
                                Carbon::now()
                                    ->startOfMonth()
                                    ->toDateString(),

                                Carbon::now()
                                    ->endOfMonth()
                                    ->toDateString(),
                            ]
                        );

                        break;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL CUSTOM - MULAI
            |--------------------------------------------------------------------------
            */

            if ($request->filled('date_from')) {

                $query->whereDate(
                    'tanggal',
                    '>=',
                    $request->input('date_from')
                );
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL CUSTOM - SELESAI
            |--------------------------------------------------------------------------
            */

            if ($request->filled('date_to')) {

                $query->whereDate(
                    'tanggal',
                    '<=',
                    $request->input('date_to')
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ORDER EVENT
            |--------------------------------------------------------------------------
            |
            | Event terdekat ditampilkan lebih dulu.
            |
            */

            $query
                ->orderBy('tanggal', 'asc')
                ->orderBy('waktu_mulai', 'asc');


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            $perPage = $request->input(
                'per_page',
                10
            );

            $events = $query->paginate(
                $perPage
            );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' => 'success',

                'message' => $events->isEmpty()
                    ? 'Belum ada event yang sesuai'
                    : 'Data event berhasil diambil',

                'data' => EventResource::collection(
                    $events->items()
                ),

                'meta' => [

                    'current_page' => $events->currentPage(),

                    'per_page' => $events->perPage(),

                    'total' => $events->total(),

                    'last_page' => $events->lastPage(),

                    'from' => $events->firstItem(),

                    'to' => $events->lastItem(),

                ],

            ], 200);


        } catch (ValidationException $e) {

            return response()->json([

                'status' => 'error',

                'message' => 'Parameter yang dikirim tidak valid',

                'errors' => $e->errors(),

                'data' => [],

            ], 422);


        } catch (\Throwable $e) {

            Log::error(
                'Event index error: ' . $e->getMessage(),
                [
                    'request' => $request->all(),
                    'trace' => $e->getTraceAsString(),
                ]
            );


            return response()->json([

                'status' => 'error',

                'message' => 'Gagal mengambil data event',

                'data' => [],

            ], 500);
        }
    }


    /**
     * Menampilkan detail event berdasarkan slug.
     */
    public function show(string $slug): JsonResponse
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | CARI EVENT
            |--------------------------------------------------------------------------
            */

            $event = Event::query()
                ->where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' => 'success',

                'message' => 'Detail event berhasil diambil',

                'data' => new EventResource($event),

            ], 200);


        } catch (ModelNotFoundException $e) {

            return response()->json([

                'status' => 'error',

                'message' => 'Event tidak ditemukan',

                'data' => null,

            ], 404);


        } catch (\Throwable $e) {

            Log::error(
                'Event show error: ' . $e->getMessage(),
                [
                    'slug' => $slug,
                    'trace' => $e->getTraceAsString(),
                ]
            );


            return response()->json([

                'status' => 'error',

                'message' => 'Terjadi kesalahan saat mengambil detail event',

                'data' => null,

            ], 500);
        }
    }
}