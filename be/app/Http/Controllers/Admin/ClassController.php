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
        $query = ClassModel::with('instructor');

        // Instruktur hanya melihat class miliknya
        if (auth()->user()->hasRole('instruktur')) {
            $query->where(
                'instructor_uuid',
                auth()->user()->uuid
            );
        }

        // Filter level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filter instructor - hanya admin
        if (
            auth()->user()->hasRole('admin') &&
            $request->filled('instructor_uuid')
        ) {
            $query->where(
                'instructor_uuid',
                $request->instructor_uuid
            );
        }

        $classes = $query
            ->latest()
            ->get();

        $instructors = User::role('instruktur')
            ->orderBy('name')
            ->get();

        return view(
            'pages.class.index',
            compact('classes', 'instructors')
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
            'name' => 'required|string|max:255|unique:classes,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'level' => 'required|in:pemula,menengah,advance,semua_level',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
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
                ->with('success', 'Class berhasil ditambahkan.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
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
            'name' => 'required|string|max:255|unique:classes,name,' . $uuid . ',uuid',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'level' => 'required|in:pemula,menengah,advance,semua_level',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota_cost' => 'required|integer|min:1',
            'is_active' => 'required|in:active,inactive',
        ]);

        // Admin boleh mengganti instructor
        if (auth()->user()->hasRole('admin')) {
            $request->validate([
                'instructor_uuid' => 'required|uuid|exists:users,uuid',
            ]);
        }

        DB::beginTransaction();

        try {

            $query = ClassModel::where('uuid', $uuid);

            // Instruktur hanya bisa update class miliknya
            if (auth()->user()->hasRole('instruktur')) {
                $query->where(
                    'instructor_uuid',
                    auth()->user()->uuid
                );
            }

            $class = $query->firstOrFail();

            $imagePath = $class->image;

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


            // Hanya admin yang bisa mengganti instructor
            if (auth()->user()->hasRole('admin')) {

                $instructor = User::role('instruktur')
                    ->where('uuid', $request->instructor_uuid)
                    ->firstOrFail();

                $data['instructor_uuid'] = $instructor->uuid;
            }


            $class->update($data);

            DB::commit();

            return redirect()
                ->route('classes.index')
                ->with('success', 'Class berhasil diperbarui.');
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
                ->with('success', 'Class berhasil dihapus.');
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
