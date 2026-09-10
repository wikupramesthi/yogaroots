<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClassScheduleController extends Controller
{
    /**
     * Menampilkan daftar class schedule.
     *
     * Query:
     *
     * ?date=2026-09-15
     * ?level=foundation
     * ?time=morning
     * ?studio_uuid=uuid
     * ?page=1
     * ?per_page=10
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
                'date' => [
                    'nullable',
                    'date',
                ],

                'level' => [
                    'nullable',
                    'in:foundation,intermediate,advance',
                ],

                'time' => [
                    'nullable',
                    'in:morning,afternoon,evening',
                ],

                'studio_uuid' => [
                    'nullable',
                    'uuid',
                    'exists:studios,uuid',
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
            | TANGGAL
            |--------------------------------------------------------------------------
            */

            $date = $request->filled('date')
                ? Carbon::parse($request->date)
                : Carbon::today();

            $day = strtolower($date->format('l'));


            /*
            |--------------------------------------------------------------------------
            | QUERY DASAR
            |--------------------------------------------------------------------------
            */

            $query = ClassSchedule::query()
                ->with([
                    'class.instructor',
                    'studio',
                ])
                ->where('day', $day)
                ->where('status', 'active');


            /*
            |--------------------------------------------------------------------------
            | FILTER LEVEL
            |--------------------------------------------------------------------------
            */

            if ($request->filled('level')) {

                $query->whereHas('class', function ($q) use ($request) {
                    $q->where(
                        'level',
                        $request->level
                    );
                });
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER STUDIO
            |--------------------------------------------------------------------------
            */

            if ($request->filled('studio_uuid')) {

                $query->where(
                    'studio_uuid',
                    $request->studio_uuid
                );
            }


            /*
            |--------------------------------------------------------------------------
            | FILTER TIME
            |--------------------------------------------------------------------------
            */

            if ($request->filled('time')) {

                switch ($request->time) {

                    case 'morning':

                        $query->whereTime(
                            'start_time',
                            '>=',
                            '05:00'
                        )->whereTime(
                            'start_time',
                            '<',
                            '12:00'
                        );

                        break;


                    case 'afternoon':

                        $query->whereTime(
                            'start_time',
                            '>=',
                            '12:00'
                        )->whereTime(
                            'start_time',
                            '<',
                            '17:00'
                        );

                        break;


                    case 'evening':

                        $query->whereTime(
                            'start_time',
                            '>=',
                            '17:00'
                        );

                        break;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | ORDER
            |--------------------------------------------------------------------------
            */

            $query->orderBy('start_time', 'asc');


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            $perPage = $request->input(
                'per_page',
                20
            );

            $schedules = $query->paginate(
                $perPage
            );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            $data = collect($schedules->items())
                ->map(function ($schedule) use ($date) {

                    $startTime = Carbon::parse(
                        $schedule->start_time
                    );

                    $endTime = $schedule->end_time
                        ? Carbon::parse($schedule->end_time)
                        : null;

                    return [

                        /*
                        |--------------------------------------------------------------------------
                        | SCHEDULE
                        |--------------------------------------------------------------------------
                        */

                        'uuid' => $schedule->uuid,

                        'date' => $date->format('Y-m-d'),

                        'day' => $schedule->day,

                        'start_time' => $startTime->format('H:i'),

                        'end_time' => $endTime
                            ? $endTime->format('H:i')
                            : null,

                        'duration' => $endTime
                            ? $startTime->diffInMinutes($endTime)
                            : null,

                        'capacity' => $schedule->capacity,


                        /*
                        |--------------------------------------------------------------------------
                        | CLASS
                        |--------------------------------------------------------------------------
                        */

                        'class' => [
                            'uuid' => $schedule->class?->uuid,
                            'name' => $schedule->class?->name,
                            'slug' => $schedule->class?->slug,
                            'level' => $schedule->class?->level,
                            'description' => $schedule->class?->description,
                            'image' => $schedule->class?->image,
                        ],


                        /*
                        |--------------------------------------------------------------------------
                        | INSTRUCTOR
                        |--------------------------------------------------------------------------
                        */

                        'instructor' => [
                            'uuid' => $schedule->class?->instructor?->uuid,
                            'name' => $schedule->class?->instructor?->name,
                            'avatar' => $schedule->class?->instructor?->avatar,
                        ],


                        /*
                        |--------------------------------------------------------------------------
                        | STUDIO
                        |--------------------------------------------------------------------------
                        */

                        'studio' => [
                            'uuid' => $schedule->studio?->uuid,
                            'name' => $schedule->studio?->name,
                            'address' => $schedule->studio?->address,
                        ],
                    ];
                });


            return response()->json([

                'status' => 'success',

                'message' => $data->isEmpty()
                    ? 'Belum ada class schedule yang sesuai'
                    : 'Data class schedule berhasil diambil',

                'data' => $data,

                'meta' => [

                    'current_page' => $schedules->currentPage(),

                    'per_page' => $schedules->perPage(),

                    'total' => $schedules->total(),

                    'last_page' => $schedules->lastPage(),

                    'from' => $schedules->firstItem(),

                    'to' => $schedules->lastItem(),

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
                'Class schedule index error: ' . $e->getMessage(),
                [
                    'request' => $request->all(),
                    'trace' => $e->getTraceAsString(),
                ]
            );


            return response()->json([

                'status' => 'error',

                'message' => 'Gagal mengambil data class schedule',

                'data' => [],

            ], 500);
        }
    }

    /**
     * Menampilkan detail class schedule berdasarkan UUID.
     */
    public function show(string $uuid): JsonResponse
    {
        try {

            /*
        |--------------------------------------------------------------------------
        | CARI CLASS SCHEDULE
        |--------------------------------------------------------------------------
        */

            $schedule = ClassSchedule::query()
                ->with([
                    'class.instructor',
                    'studio',
                ])
                ->where('uuid', $uuid)
                ->where('status', 'active')
                ->firstOrFail();


            /*
        |--------------------------------------------------------------------------
        | FORMAT WAKTU
        |--------------------------------------------------------------------------
        */

            $startTime = Carbon::parse(
                $schedule->start_time
            );

            $endTime = $schedule->end_time
                ? Carbon::parse($schedule->end_time)
                : null;


            /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

            return response()->json([

                'status' => 'success',

                'message' => 'Detail class schedule berhasil diambil',

                'data' => [

                    /*
                |--------------------------------------------------------------------------
                | SCHEDULE
                |--------------------------------------------------------------------------
                */

                    'uuid' => $schedule->uuid,

                    'day' => $schedule->day,

                    'start_time' => $startTime->format('H:i'),

                    'end_time' => $endTime
                        ? $endTime->format('H:i')
                        : null,

                    'duration' => $endTime
                        ? $startTime->diffInMinutes($endTime)
                        : null,

                    'capacity' => $schedule->capacity,


                    /*
                |--------------------------------------------------------------------------
                | CLASS
                |--------------------------------------------------------------------------
                */

                    'class' => [

                        'uuid' => $schedule->class?->uuid,

                        'name' => $schedule->class?->name,

                        'slug' => $schedule->class?->slug,

                        'level' => $schedule->class?->level,

                        'description' => $schedule->class?->description,

                        'image' => $schedule->class?->image,

                    ],


                    /*
                |--------------------------------------------------------------------------
                | INSTRUCTOR
                |--------------------------------------------------------------------------
                */

                    'instructor' => [

                        'uuid' => $schedule->class?->instructor?->uuid,

                        'name' => $schedule->class?->instructor?->name,

                        'avatar' => $schedule->class?->instructor?->avatar,

                    ],


                    /*
                |--------------------------------------------------------------------------
                | STUDIO
                |--------------------------------------------------------------------------
                */

                    'studio' => [

                        'uuid' => $schedule->studio?->uuid,

                        'name' => $schedule->studio?->name,

                        'address' => $schedule->studio?->address,

                    ],

                ],

            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([

                'status' => 'error',

                'message' => 'Class schedule tidak ditemukan',

                'data' => null,

            ], 404);
        } catch (\Throwable $e) {

            Log::error(
                'Class schedule show error: ' . $e->getMessage(),
                [
                    'uuid' => $uuid,
                    'trace' => $e->getTraceAsString(),
                ]
            );


            return response()->json([

                'status' => 'error',

                'message' => 'Terjadi kesalahan saat mengambil detail class schedule',

                'data' => null,

            ], 500);
        }
    }
}
