<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['guru']);
        })
            ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            })
            ->when($request->filled('jenis_kelamin'), function ($query) use ($request) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            })
            ->when($request->filled('kepegawaian'), function ($query) use ($request) {
                $query->where('kepegawaian', $request->kepegawaian);
            })
            ->latest()
            ->get();

        return view('pages.pegawai.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'avatar'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nik'            => 'nullable|string|max:20|unique:users,nik',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'no_hp'          => 'nullable|unique:users,no_hp',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'agama'          => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'jabatan'        => 'required|string|max:255',
            'kepegawaian'    => 'nullable|in:asn,honorer,magang,lainnya',
            'is_active'      => 'nullable|date',
            'file_pendukung' => 'nullable|mimes:pdf|max:4096',
            'facebook'       => 'nullable|string|max:255',
            'instagram'      => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'tiktok'         => 'nullable|string|max:255',
            'youtube'        => 'nullable|string|max:255',
            'biografi'       => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $filePendukungPath = $request->hasFile('file_pendukung')
                ? $request->file('file_pendukung')->store('files/pegawai', 'public')
                : null;

            $user = User::create([
                'uuid'             => Str::uuid(),
                'avatar'           => $avatarPath,
                'nik'              => $request->nik,
                'name'             => $request->name,
                'email'            => $request->email,
                'password'         => Hash::make('password'),
                'email_verified_at' => now(),
                'no_hp'            => $request->no_hp,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'jenis_kelamin'    => $request->jenis_kelamin,
                'agama'            => $request->agama,
                'jabatan'          => $request->jabatan,
                'kepegawaian'      => $request->kepegawaian,
                'is_active'        => $request->is_active,
                'file_pendukung'   => $filePendukungPath,
                'facebook'         => $request->facebook,
                'instagram'        => $request->instagram,
                'twitter'          => $request->twitter,
                'tiktok'           => $request->tiktok,
                'youtube'          => $request->youtube,
                'biografi'         => $request->biografi,
            ]);

            $user->assignRole('guru');

            DB::commit();
            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil disimpan.');
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
    public function edit(User $pegawai)
    {
        $authUser = auth()->user();

        if ($authUser->hasRole(['admin', 'super-admin'])) {
            return view('pages.pegawai.edit', compact('pegawai'));
        }

        if ($authUser->uuid !== $pegawai->uuid) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('pages.pegawai.edit', compact('pegawai'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $pegawai)
    {
        $request->validate([
            'avatar'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nik'            => 'nullable|string|max:20|unique:users,nik,' . $pegawai->uuid . ',uuid',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $pegawai->uuid . ',uuid',
            'no_hp'          => 'nullable|unique:users,no_hp,' . $pegawai->uuid . ',uuid',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'agama'          => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'jabatan'        => 'required|string|max:255',
            'kepegawaian'    => 'nullable|in:asn,honorer,magang,lainnya',
            'is_active'      => 'nullable|date',
            'file_pendukung' => 'nullable|mimes:pdf|max:4096',
            'facebook'       => 'nullable|string|max:255',
            'instagram'      => 'nullable|string|max:255',
            'twitter'        => 'nullable|string|max:255',
            'tiktok'         => 'nullable|string|max:255',
            'youtube'        => 'nullable|string|max:255',
            'biografi'       => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only([
                'nik',
                'name',
                'email',
                'no_hp',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'jabatan',
                'kepegawaian',
                'is_active',
                'facebook',
                'instagram',
                'twitter',
                'tiktok',
                'youtube',
                'biografi'
            ]);

            if ($request->hasFile('avatar')) {
                if ($pegawai->avatar && Storage::disk('public')->exists($pegawai->avatar)) {
                    Storage::disk('public')->delete($pegawai->avatar);
                }
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            if ($request->hasFile('file_pendukung')) {
                if ($pegawai->file_pendukung && Storage::disk('public')->exists($pegawai->file_pendukung)) {
                    Storage::disk('public')->delete($pegawai->file_pendukung);
                }
                $data['file_pendukung'] = $request->file('file_pendukung')->store('files/pegawai', 'public');
            }

            $pegawai->update($data);

            DB::commit();
            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $pegawai)
    {
        try {
            $pegawai->delete();
            return redirect()
                ->route('pegawai.index')
                ->with('success', 'Data pegawai berhasil dihapus (soft delete).');
        } catch (\Throwable $th) {
            return redirect()
                ->route('pegawai.index')
                ->with('error', 'Gagal menghapus data: ' . $th->getMessage());
        }
    }

    public function restore()
    {
        try {
            User::onlyTrashed()->restore();
            return redirect()->route('pegawai.index')->with('success', 'Semua pegawai berhasil direstore.');
        } catch (\Throwable $th) {
            return redirect()->route('pegawai.index')->with('error', 'Gagal restore data: ' . $th->getMessage());
        }
    }
}
