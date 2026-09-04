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
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'instruktur');
        })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->end_date);
            })
            ->when($request->filled('jenis_kelamin'), function ($query) use ($request) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            })
            ->when($request->filled('specialization'), function ($query) use ($request) {
                $query->whereHas('specializations', function ($q) use ($request) {
                    $q->where('specializations.uuid', $request->specialization);
                });
            })
            ->with('specializations')
            ->latest()
            ->get();

        $specializations = Specializaty::where('is_active', 'active')
            ->orderBy('name')
            ->get();

        return view('pages.instruktur.index', compact(
            'users',
            'specializations'
        ));
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

            // Simpan spesialisasi instruktur // 
            foreach ($request->specializations as $specializationUuid) {
                DB::table('user_specialization')->insert([
                    'uuid'                => (string) Str::uuid(),
                    'user_uuid'           => $user->uuid,
                    'specialization_uuid' => $specializationUuid,
                ]);
            }

            DB::commit();
            return redirect()->route('instruktur.index')->with('success', 'Instructor data has been saved successfully.');
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
            abort(403, 'Anda tidak memiliki akses ke data ini.');
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

            // Hapus specialization lama
            DB::table('user_specialization')
                ->where('user_uuid', $instruktur->uuid)
                ->delete();


            // Masukkan specialization yang baru
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
            return redirect()->route('instruktur.index')->with('success', 'Data instruktur berhasil diperbarui.');
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
                ->with('success', 'Data instruktur berhasil dihapus (soft delete).');
        } catch (\Throwable $th) {
            return redirect()
                ->route('instruktur.index')
                ->with('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }

    public function restore()
    {
        try {
            User::onlyTrashed()->restore();
            return redirect()->route('instruktur.index')->with('success', 'Semua instruktur berhasil direstore.');
        } catch (\Throwable $th) {
            return redirect()->route('instruktur.index')->with('error', 'Gagal restore data: ' . $th->getMessage());
        }
    }
}
