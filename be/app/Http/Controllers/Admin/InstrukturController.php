<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Specializaty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $jenisKelamin = (string) $request->get('jenis_kelamin', '');
        $jenisKelamin = in_array($jenisKelamin, ['L', 'P'], true) ? $jenisKelamin : '';
        $specializationUuid = (string) $request->get('specialization', '');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'instruktur');
        })->with('specializations');

        if ($search !== '') {
            $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search) . '%';
            $query->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)->orWhere('email', 'like', $like);
            });
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($jenisKelamin !== '') {
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        if ($specializationUuid !== '') {
            $query->whereHas('specializations', function ($q) use ($specializationUuid) {
                $q->where('specializations.uuid', $specializationUuid);
            });
        }

        $users = (clone $query)->latest()->get();

        $stats = [
            'total' => (clone $query)->count(),
            'male' => (clone $query)->where('jenis_kelamin', 'L')->count(),
            'female' => (clone $query)->where('jenis_kelamin', 'P')->count(),
            'new_month' => (clone $query)->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $specializations = Specializaty::where('is_active', 'active')
            ->orderBy('name')
            ->get();

        return view('pages.instruktur.index', [
            'users' => $users,
            'specializations' => $specializations,
            'stats' => $stats,
            'search' => $search,
            'jenisKelamin' => $jenisKelamin,
            'specializationUuid' => $specializationUuid,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specializaty::where('is_active', 'active')->get();
        return view('pages.instruktur.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'avatar'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'no_hp'          => 'nullable|unique:users,no_hp',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'agama'          => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'pengalaman'     => 'required|string|max:255',
            'is_active'      => 'nullable|date',
            'facebook'       => 'nullable|string|max:255',
            'instagram'      => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'tiktok'         => 'nullable|string|max:255',
            'youtube'        => 'nullable|string|max:255',
            'biografi'       => 'nullable|string',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'exists:specializations,uuid',
        ]);

        DB::beginTransaction();
        try {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');

            $user = User::create([
                'uuid'             => Str::uuid(),
                'avatar'           => $avatarPath,
                'name'             => $request->name,
                'email'            => $request->email,
                'password'         => Hash::make('password'),
                'email_verified_at' => now(),
                'no_hp'            => $request->no_hp,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'jenis_kelamin'    => $request->jenis_kelamin,
                'agama'            => $request->agama,
                'pengalaman'          => $request->pengalaman,
                'is_active'        => $request->is_active,
                'facebook'         => $request->facebook,
                'instagram'        => $request->instagram,
                'twitter'          => $request->twitter,
                'tiktok'           => $request->tiktok,
                'youtube'          => $request->youtube,
                'biografi'         => $request->biografi,
            ]);

            $user->assignRole('instruktur');

            // Save the instructor specializations // 
            foreach ($request->specializations as $specializationUuid) {
                DB::table('user_specialization')->insert([
                    'uuid'                => (string) Str::uuid(),
                    'user_uuid'           => $user->uuid,
                    'specialization_uuid' => $specializationUuid,
                ]);
            }

            DB::commit();
            return redirect()->route('instruktur.index')->with('success', 'Instructor has been saved successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
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
    public function edit(User $instruktur)
    {
        $authUser = auth()->user();

        if ($authUser->hasRole(['admin', 'super-admin'])) {
            $specializations = Specializaty::where('is_active', 'active')->get();

            return view('pages.instruktur.edit', compact(
                'instruktur',
                'specializations'
            ));
        }

        if ($authUser->uuid !== $instruktur->uuid) {
            abort(403, 'You do not have access to this data.');
        }

        $specializations = Specializaty::where('is_active', 'active')->get();

        return view('pages.instruktur.edit', compact(
            'instruktur',
            'specializations'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $instruktur)
    {
        $request->validate([
            'avatar'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $instruktur->uuid . ',uuid',
            'no_hp'          => 'nullable|unique:users,no_hp,' . $instruktur->uuid . ',uuid',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'agama'          => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'pengalaman'     => 'required|string|max:255',
            'is_active'      => 'nullable|date',
            'facebook'       => 'nullable|string|max:255',
            'instagram'      => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'tiktok'         => 'nullable|string|max:255',
            'youtube'        => 'nullable|string|max:255',
            'biografi'       => 'nullable|string',

            // Specialization
            'specializations'   => 'required|array|min:1',
            'specializations.*' => 'exists:specializations,uuid',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'email',
                'no_hp',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'pengalaman',
                'is_active',
                'facebook',
                'instagram',
                'twitter',
                'tiktok',
                'youtube',
                'biografi'
            ]);

            if ($request->hasFile('avatar')) {
                if ($instruktur->avatar && Storage::disk('public')->exists($instruktur->avatar)) {
                    Storage::disk('public')->delete($instruktur->avatar);
                }
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $instruktur->update($data);

            // Delete the old specializations
            DB::table('user_specialization')
                ->where('user_uuid', $instruktur->uuid)
                ->delete();


            // Insert the new specializations
            $specializations = [];

            foreach ($request->specializations as $specializationUuid) {
                $specializations[] = [
                    'uuid'                => (string) Str::uuid(),
                    'user_uuid'           => $instruktur->uuid,
                    'specialization_uuid' => $specializationUuid,
                ];
            }

            DB::table('user_specialization')
                ->insert($specializations);

            DB::commit();
            return redirect()->route('instruktur.index')->with('success', 'Instructor successfully updated.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $instruktur)
    {
        try {
            $instruktur->delete();
            return redirect()
                ->route('instruktur.index')
                ->with('success', 'Instructor has been successfully deleted. (soft delete).');
        } catch (\Throwable $th) {
            return redirect()
                ->route('instruktur.index')
                ->with('error', 'Failed to delete data: ' . $th->getMessage());
        }
    }

    public function restore()
    {
        try {
            User::onlyTrashed()->restore();
            return redirect()->route('instruktur.index')->with('success', 'All instructors have been successfully restored.');
        } catch (\Throwable $th) {
            return redirect()->route('instruktur.index')->with('error', 'Failed to restore data: ' . $th->getMessage());
        }
    }

    public function mobile()
    {
        $user = auth()->user();

        $isMobile = preg_match(
            '/Mobile|Android|iPhone|iPad|iPod/i',
            request()->header('User-Agent')
        );

        if ($user->hasRole('user') && $isMobile) {

            $instructors = User::role('instruktur')
                ->with([
                    'specializations',
                    'classes'
                ])
                ->get();

            $specializations = Specializaty::where('is_active', 'active')
                ->orderBy('name')
                ->get();

            return view(
                'pages.mobile.instruktur',
                compact(
                    'user',
                    'instructors',
                    'specializations'
                )
            );
        }

        abort(403);
    }
}
