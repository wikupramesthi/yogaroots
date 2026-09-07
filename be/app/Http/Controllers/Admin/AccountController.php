<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Account;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Specializaty;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $specializations = Specializaty::where('is_active', 'active')
            ->orderBy('name')
            ->get();

        $kecamatans = Kecamatan::all();

        return view('profile.update', [
            'user' => $request->user(),
            'kecamatans' => $kecamatans,
            'specializations' => $specializations,
        ]);
    }

    /**
     * Update the user's kelurahan information.
     */
    public function getKelurahan($kecamatan_id)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->pluck('nama', 'id');
        return response()->json($kelurahans);
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */

        $rules = [
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            'name'          => 'required|string|max:255',

            'email'         => 'nullable|email|unique:users,email,' . $user->uuid . ',uuid',

            'no_hp'         => 'required|unique:users,no_hp,' . $user->uuid . ',uuid',

            'tempat_lahir'  => 'nullable|string|max:100',

            'tanggal_lahir' => 'nullable|date',

            'jenis_kelamin' => 'nullable|in:L,P',

            'agama'         => 'nullable|string|max:50',

            'alamat'        => 'nullable|string',

            'facebook'      => 'nullable|string|max:255',

            'instagram'     => 'nullable|string|max:255',

            'twitter'       => 'nullable|string|max:255',

            'tiktok'        => 'nullable|string|max:255',

            'youtube'       => 'nullable|string|max:255',

            'pengalaman'    => 'nullable|string',

            'biografi'      => 'nullable|string',
        ];


        /*
    |--------------------------------------------------------------------------
    | Specialization Validation
    |--------------------------------------------------------------------------
    |
    | User biasa tidak wajib memiliki specialization.
    | Role selain user wajib memiliki minimal 1 specialization.
    |
    */

        if ($user->hasRole('user')) {
            $rules['specializations'] = 'nullable|array';
            $rules['specializations.*'] = 'nullable|uuid|exists:specializations,uuid';
        } else {
            $rules['specializations'] = 'required|array|min:1';
            $rules['specializations.*'] = 'uuid|exists:specializations,uuid';
        }


        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'] ?? $user->email;
        $user->no_hp = $validated['no_hp'];
        $user->tempat_lahir = $validated['tempat_lahir'] ?? null;
        $user->tanggal_lahir = $validated['tanggal_lahir'] ?? null;
        $user->jenis_kelamin = $validated['jenis_kelamin'] ?? null;
        $user->agama = $validated['agama'] ?? null;
        $user->alamat = $validated['alamat'] ?? null;
        $user->facebook = $validated['facebook'] ?? null;
        $user->instagram = $validated['instagram'] ?? null;
        $user->twitter = $validated['twitter'] ?? null;
        $user->tiktok = $validated['tiktok'] ?? null;
        $user->youtube = $validated['youtube'] ?? null;
        $user->pengalaman = $validated['pengalaman'] ?? null;
        $user->biografi = $validated['biografi'] ?? null;


        if ($request->hasFile('avatar')) {

            if (
                $user->avatar &&
                !str_starts_with($user->avatar, 'http')
            ) {

                $oldAvatar = storage_path(
                    'app/public/' . $user->avatar
                );

                if (file_exists($oldAvatar)) {
                    unlink($oldAvatar);
                }
            }


            // Simpan avatar baru
            $path = $request->file('avatar')->store(
                'avatars',
                'public'
            );

            $user->avatar = $path;
        }

        $user->save();


        if (!$user->hasRole('user')) {
            $user->specializations()->sync(
                $validated['specializations'] ?? []
            );
        } else {
            $user->specializations()->detach();
        }
        return redirect()
            ->back()
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
