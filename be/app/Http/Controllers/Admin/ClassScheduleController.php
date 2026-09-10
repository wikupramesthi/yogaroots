<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassModel;
use App\Models\Class\ClassSchedule;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ClassScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassModel::where('is_active', true)
            ->orderBy('name')
            ->get();

        $studios = Studio::where('status', 'active')
            ->orderBy('name')
            ->get();

        $schedules = ClassSchedule::with([
            'class.instructor',
            'studio'
        ])
            ->where('status', 'active')
            ->orderByRaw("
            FIELD(
                day,
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            )
        ")
            ->orderBy('start_time')
            ->get();

        return view(
            'pages.class-schedule.index',
            compact(
                'schedules',
                'classes',
                'studios'
            )
        );
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
            'studio_uuid' => 'required|uuid|exists:studios,uuid',
            'class_uuid' => 'required|uuid|exists:classes,uuid',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        // Pastikan end time lebih besar dari start time
        $start = \Carbon\Carbon::createFromFormat(
            'H:i',
            $request->start_time
        );

        $end = \Carbon\Carbon::createFromFormat(
            'H:i',
            $request->end_time
        );

        if ($end->lessThanOrEqualTo($start)) {
            return back()
                ->withErrors([
                    'end_time' => 'End time must be after start time.'
                ])
                ->withInput();
        }

        // Cek bentrok pada studio yang sama
        $conflict = ClassSchedule::where('studio_uuid', $request->studio_uuid)
            ->where('day', $request->day)
            ->where('status', 'active')
            ->where(function ($query) use ($request) {
                $query->where(
                    'start_time',
                    '<',
                    $request->end_time
                )
                    ->where(
                        'end_time',
                        '>',
                        $request->start_time
                    );
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors([
                    'start_time' => 'This studio already has a class scheduled at this time.'
                ])
                ->withInput();
        }

        DB::beginTransaction();

        try {

            ClassSchedule::create([
                'uuid' => (string) Str::uuid(),
                'studio_uuid' => $request->studio_uuid,
                'class_uuid' => $request->class_uuid,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('class-schedules.index')
                ->with(
                    'success',
                    'Class schedule added successfully.'
                );
        } catch (\Throwable $th) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $th->getMessage());
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
    public function edit(string $uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($uuid, Request $request)
    {
        $request->validate([
            'studio_uuid' => 'required|uuid|exists:studios,uuid',
            'class_uuid' => 'required|uuid|exists:classes,uuid',
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {

            $schedule = ClassSchedule::where('uuid', $uuid)
                ->firstOrFail();

            /*
        |--------------------------------------------------------------------------
        | Check Schedule Conflict
        |--------------------------------------------------------------------------
        | Hanya boleh ada satu kelas pada studio yang sama,
        | di hari dan waktu yang saling bertabrakan.
        */

            $conflict = ClassSchedule::where('studio_uuid', $request->studio_uuid)
                ->where('day', $request->day)
                ->where('status', 'active')
                ->where('uuid', '!=', $schedule->uuid)
                ->where(function ($query) use ($request) {
                    $query->where(
                        'start_time',
                        '<',
                        $request->end_time
                    )->where(
                        'end_time',
                        '>',
                        $request->start_time
                    );
                })
                ->exists();

            if ($conflict) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'start_time' =>
                        'This studio already has a class scheduled at this time.'
                    ]);
            }

            $schedule->update([
                'studio_uuid' => $request->studio_uuid,
                'class_uuid' => $request->class_uuid,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('class-schedules.index')
                ->with(
                    'success',
                    'Class schedule updated successfully.'
                );
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $th->getMessage()
                );
        }
    }

    public function print()
    {
        $schedules = ClassSchedule::with([
            'class.instructor'
        ])
            ->where('status', 'active')
            ->get();

        return view(
            'pages.class-schedule.print',
            compact('schedules')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();

        try {
            $schedule = ClassSchedule::where('uuid', $uuid)
                ->firstOrFail();

            $schedule->update([
                'status' => 'inactive',
            ]);

            DB::commit();

            return redirect()
                ->route('class-schedules.index')
                ->with('success', 'Class schedule deactivated successfully.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Failed to deactivate class schedule.');
        }
    }
}
