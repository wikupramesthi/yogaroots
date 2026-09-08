<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudioController extends Controller
{
    /**
     * Display a listing of the studios.
     */
    public function index(Request $request)
    {
        $studios = Studio::withCount('schedules')
            ->latest()
            ->get();

        return view(
            'pages.studios.index',
            compact('studios')
        );
    }

    /**
     * Show the form for creating a new studio.
     */
    public function create()
    {
        return view('pages.studios.create');
    }

    /**
     * Store a newly created studio.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:studios,slug',
            'excerpt'         => 'nullable|string',
            'description'     => 'nullable|string',
            'address'         => 'required|string',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:255',
            'google_maps_url' => 'nullable|url|max:500',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'          => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('studios', 'public');
            }

            Studio::create([
                'uuid'            => (string) Str::uuid(),
                'name'            => $request->name,
                'slug'            => $request->slug
                    ? Str::slug($request->slug)
                    : Str::slug($request->name),
                'excerpt'         => $request->excerpt,
                'description'     => $request->description,
                'address'         => $request->address,
                'phone'           => $request->phone,
                'email'           => $request->email,
                'google_maps_url' => $request->google_maps_url,
                'image'           => $imagePath,
                'status'          => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('studios.index')
                ->with(
                    'success',
                    'Studio data has been saved successfully.'
                );
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified studio.
     */
    public function edit(Studio $studio)
    {
        return view(
            'pages.studios.edit',
            compact('studio')
        );
    }

    /**
     * Update the specified studio.
     */
    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:studios,slug,' . $studio->uuid . ',uuid',
            'excerpt'         => 'nullable|string',
            'description'     => 'nullable|string',
            'address'         => 'required|string',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:255',
            'google_maps_url' => 'nullable|url|max:500',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'          => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {

            $data = $request->only([
                'name',
                'excerpt',
                'description',
                'address',
                'phone',
                'email',
                'google_maps_url',
                'status',
            ]);

            $data['slug'] = $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name);

            if ($request->hasFile('image')) {

                if (
                    $studio->image &&
                    Storage::disk('public')->exists($studio->image)
                ) {
                    Storage::disk('public')->delete($studio->image);
                }

                $data['image'] = $request->file('image')
                    ->store('studios', 'public');
            }

            $studio->update($data);

            DB::commit();

            return redirect()
                ->route('studios.index')
                ->with(
                    'success',
                    'Studio data has been updated successfully.'
                );
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified studio.
     */
    public function destroy(Studio $studio)
    {
        try {

            // Studio tidak boleh dihapus jika masih
            // digunakan oleh class schedule.
            if ($studio->schedules()->exists()) {
                return redirect()
                    ->route('studios.index')
                    ->with(
                        'error',
                        'This studio cannot be deleted because it is still used by a class schedule.'
                    );
            }

            if (
                $studio->image &&
                Storage::disk('public')->exists($studio->image)
            ) {
                Storage::disk('public')->delete($studio->image);
            }

            $studio->delete();

            return redirect()
                ->route('studios.index')
                ->with(
                    'success',
                    'Studio data has been deleted successfully.'
                );
        } catch (\Throwable $th) {

            return redirect()
                ->route('studios.index')
                ->with(
                    'error',
                    'Failed to delete studio: ' . $th->getMessage()
                );
        }
    }
}
