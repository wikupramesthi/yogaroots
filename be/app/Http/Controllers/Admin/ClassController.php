<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Class\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $level = $request->get('level', '');
        $level = in_array($level, ['foundation', 'intermediate', 'advance'], true) ? $level : '';
        $is_active = $request->get('is_active', '');
        $is_active = in_array($is_active, ['active', 'inactive'], true) ? $is_active : '';
        $instructor_uuid = $request->get('instructor_uuid', '');

        $query = ClassModel::query();

        // Instructors only see their own classes
        if (auth()->user()->hasRole('instruktur')) {
            $query->where(
                'instructor_uuid',
                auth()->user()->uuid
            );
        }

        if ($search !== '') {
            $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search) . '%';
            $query->where('name', 'like', $like);
        }

        // Filter level
        if ($level !== '') {
            $query->where('level', $level);
        }

        // Filter status
        if ($is_active !== '') {
            $query->where('is_active', $is_active);
        }

        // Filter instructor - hanya admin
        if (
            auth()->user()->hasRole('admin') &&
            $instructor_uuid !== ''
        ) {
            $query->where(
                'instructor_uuid',
                $instructor_uuid
            );
        }

        $classes = (clone $query)
            ->with('instructor')
            ->latest()
            ->get();

        // Stats follow the active filter so numbers stay in sync with the data.
        $stats = [
            'total' => (clone $query)->count(),
            'active' => (clone $query)->where('is_active', 'active')->count(),
            'inactive' => (clone $query)->where('is_active', 'inactive')->count(),
            'schedules' => \App\Models\Class\ClassSchedule::whereIn('class_uuid', (clone $query)->select('classes.uuid'))->count(),
        ];

        $instructors = User::role('instruktur')
            ->orderBy('name')
            ->get();

        return view(
            'pages.class.index',
            compact('classes', 'instructors', 'stats', 'search', 'level', 'is_active', 'instructor_uuid')
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = User::role('instruktur')
            ->orderBy('name')
            ->get();
        return view('pages.class.create', compact('instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:classes,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'level' => 'required|in:foundation,intermediate,advance',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'quota_cost' => 'required|integer|min:1',
            'is_active' => 'required|in:active,inactive',
        ]);

        if (
            auth()->user()->hasRole('admin') ||
            auth()->user()->hasRole('superadmin')
        ) {
            $request->validate([
                'instructor_uuid' => 'required|uuid|exists:users,uuid',
            ]);

            $instructorUuid = $request->instructor_uuid;
        } else {

            // Instructor otomatis menggunakan dirinya sendiri
            $instructorUuid = auth()->user()->uuid;
        }

        DB::beginTransaction();

        try {

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('classes', 'public');
            }

            $class = ClassModel::create([
                'uuid' => (string) Str::uuid(),
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
                'level' => $request->level,
                'duration' => $request->duration,
                'description' => $request->description,
                'price' => $request->price,
                'quota_cost' => $request->quota_cost,
                'instructor_uuid' => $instructorUuid,
                'is_active' => $request->is_active,
            ]);

            DB::commit();

            return redirect()
                ->route('classes.index')
                ->with('success', 'Class added successfully.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    public function changeLevel(Request $request, $uuid)
    {
        $request->validate([
            'level' => 'required|in:foundation,intermediate,advance',
        ]);

        try {
            $class = ClassModel::where('uuid', $uuid)->firstOrFail();

            $class->update([
                'level' => $request->level,
            ]);

            return redirect()
                ->route('classes.index')
                ->with('success', 'Class level updated successfully.');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $class = ClassModel::where('uuid', $uuid)->firstOrFail();

        $instructors = User::role('instruktur')
            ->orderBy('name')
            ->get();

        return view('pages.class.edit', compact('class', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($uuid, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,' . $uuid . ',uuid',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'level' => 'required|in:foundation,intermediate,advance',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota_cost' => 'required|integer|min:1',
            'is_active' => 'required|in:active,inactive',
        ]);

        $user = auth()->user();

        // Admin & Superadmin boleh mengganti instructor
        if (
            $user->hasRole('admin') ||
            $user->hasRole('superadmin')
        ) {
            $request->validate([
                'instructor_uuid' => 'required|uuid|exists:users,uuid',
            ]);
        }

        DB::beginTransaction();

        try {

            $query = ClassModel::where('uuid', $uuid);

            // Instruktur hanya bisa update class miliknya
            if ($user->hasRole('instruktur')) {
                $query->where(
                    'instructor_uuid',
                    $user->uuid
                );
            }

            $class = $query->firstOrFail();

            // Pertahankan gambar lama
            $imagePath = $class->image;

            // Jika upload gambar baru
            if ($request->hasFile('image')) {

                if ($class->image) {
                    Storage::disk('public')
                        ->delete($class->image);
                }

                $imagePath = $request
                    ->file('image')
                    ->store('classes', 'public');
            }

            $data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
                'level' => $request->level,
                'duration' => $request->duration,
                'description' => $request->description,
                'price' => $request->price,
                'quota_cost' => $request->quota_cost,
                'is_active' => $request->is_active,
            ];

            // Admin & Superadmin boleh mengganti instructor
            if (
                $user->hasRole('admin') ||
                $user->hasRole('superadmin')
            ) {
                $instructor = User::role('instruktur')
                    ->where('uuid', $request->instructor_uuid)
                    ->firstOrFail();

                $data['instructor_uuid'] = $instructor->uuid;
            }

            $class->update($data);

            DB::commit();

            return redirect()
                ->route('classes.index')
                ->with('success', 'Class updated successfully.');
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

            $query = ClassModel::where('uuid', $uuid);

            // Instruktur hanya bisa hapus class miliknya
            if (auth()->user()->hasRole('instruktur')) {
                $query->where(
                    'instructor_uuid',
                    auth()->user()->uuid
                );
            }

            $class = $query->firstOrFail();


            // Hapus gambar
            if ($class->image) {
                Storage::disk('public')
                    ->delete($class->image);
            }

            $class->delete();

            DB::commit();

            return redirect()
                ->route('classes.index')
                ->with('success', 'Class deleted successfully.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
