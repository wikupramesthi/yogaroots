<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Program;
use App\Models\Disability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class ProgramController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $disabilities = Disability::all();

        // Build query berdasarkan role
        if ($user->hasRole(['admin', 'super-admin'])) {
            $query = Program::with('user')->latest();
        } else {
            $query = Program::where('user_uuid', $user->uuid)->latest();
        }

        // Filter status jika ada
        if ($request->has('status') && in_array($request->status, ['pending', 'hadir', 'reschedule', 'diterima', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $programs = $query->get();

        // Tandai program yang belum lengkap
        $programsIncomplete = [];
        foreach ($programs as $program) {
            $incomplete = 
               empty($program->nama_anak) ||
        empty($program->tempat_lahir) ||
        empty($program->tanggal_lahir) ||
        empty($program->jenis_kelamin) ||
        empty($program->agama) ||
        empty($program->anak_ke) ||
        empty($program->nama_ayah) ||
        empty($program->nama_ibu) ||
        empty($program->alamat) ||
        empty($program->no_hp);

            $programsIncomplete[$program->id] = $incomplete;
        }

        $program = Program::where('user_uuid', $user->uuid)->latest()->first();

        $showFinalProgramAlert = false;
        $showInitialProgramAlert = false;

        if ($program) {
            // Jika sudah semua lengkap (final)
            if (
                 $program->nama_anak &&
        $program->tempat_lahir &&
        $program->tanggal_lahir &&
        $program->jenis_kelamin &&
        $program->agama &&
        $program->anak_ke &&
        $program->nama_ayah &&
        $program->nama_ibu &&
        $program->alamat &&
        $program->no_hp
            ) {
                $showFinalProgramAlert = true;
            } elseif (
                $program->nama_anak
            ) {
                $showInitialProgramAlert = true;
            }
        }

        // Daftar field wajib
        $requiredFields = [
            'nama_anak'     => 'Nama Anak',
            'tempat_lahir'     => 'Tempat Lahir',
            'tanggal_lahir'     => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'anak_ke'              => 'Anak Ke',
            'nama_ayah'    => 'Nama Ayah',
            'nama_ibu'     => 'Nama Ibu',
            'alamat'         => 'Alamat',
            'no_hp'              => 'Nomor HP',
        ];

        $programsIncomplete = [];
        $programsMissingFields = [];

        foreach ($programs as $program) {
            $missing = [];

            foreach ($requiredFields as $field => $label) {
                if (empty($program->$field)) {
                    $missing[] = $label;
                }
            }

            $programsIncomplete[$program->id] = count($missing) > 0;
            $programsMissingFields[$program->id] = $missing;
        }

        return view('pages.program.index', compact(
            'user',
            'programs',
            'program',
            'disabilities',
            'programsIncomplete',
            'programsMissingFields',
            'showInitialProgramAlert',
            'showFinalProgramAlert'
        ));
    }

    public function cetakPdf($id, $uuid)
    {
        $program = Program::with(['user.kecamatan', 'user.kelurahan', 'portofolio'])->findOrFail($id);

        if ($program->user_uuid !== auth()->user()->uuid && !auth()->user()->hasRole(['admin', 'super-admin'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $pdf = Pdf::loadView('pages.program.cetak', compact('program'))->setPaper('A4', 'portrait');
        return $pdf->stream('program_' . $program->id . '.pdf');
    }

    public function verifikasi($id)
    {
        $program = Program::findOrFail($id);

        if (auth()->user()->uuid !== $program->user_uuid && !auth()->user()->hasAnyRole(['admin', 'super-admin'])) {
            abort(403);
        }

        $program->status = 'hadir';
        $program->save();

        return redirect()->route('program.index')->with('success', 'Anda telah berhasil mengajukan pendaftaran calon murid ke SLB Patriot Kota Bekasi. Silakan pantau informasi secara berkala untuk update status pendaftaran Anda.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $disabilities = Disability::all();
        return view('pages.program.create', compact('disabilities'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('temp/foto_kegiatan', $filename, 'public');

            return response()->json(['filename' => $filename]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function modalStore(Request $request)
    {
        $validated = $request->validate([
            'disability_uuid'  => ['required', 'exists:disabilities,uuid'],
            'nama_anak'        => ['required', 'string', 'max:255'],
            'tempat_lahir'     => ['required', 'string', 'max:255'],
            'tanggal_lahir'    => ['required', 'date'],
            'jenis_kelamin'    => ['required', 'in:L,P'],
            'agama'            => ['required', 'in:islam,kristen,katolik,hindu,buddha,konghucu'],
            'anak_ke'          => ['required', 'integer', 'min:1'],

            // data orang tua
            'nama_ayah'        => ['required', 'string', 'max:255'],
            'nama_ibu'         => ['required', 'string', 'max:255'],
            'alamat'           => ['required', 'string'],
            'no_hp'            => ['required', 'string', 'max:255'],
        ]);

        // maksimal 1 pendaftaran per user
        $userProgramCount = Program::where(
            'user_uuid',
            auth()->user()->uuid
        )->count();

        if ($userProgramCount >= 1) {
            return redirect()->back()
                ->with('error', 'Maksimal hanya boleh mendaftar 1 calon murid.');
        }

        DB::beginTransaction();

        try {

            Program::create([
                'user_uuid'         => auth()->user()->uuid,
                'disability_uuid'   => $validated['disability_uuid'],
                'nama_anak'         => $validated['nama_anak'],
                'tempat_lahir'      => $validated['tempat_lahir'],
                'tanggal_lahir'     => $validated['tanggal_lahir'],
                'jenis_kelamin'     => $validated['jenis_kelamin'],
                'agama'             => $validated['agama'],
                'anak_ke'           => $validated['anak_ke'],

                // data orang tua
                'nama_ayah'         => $validated['nama_ayah'],
                'nama_ibu'          => $validated['nama_ibu'],
                'alamat'            => $validated['alamat'],
                'no_hp'             => $validated['no_hp'],

                'status'            => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('program.index')
                ->with('success', 'Calon murid berhasil ditambahkan.');
                
        } catch (\Throwable $th) {

            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan : ' . $th->getMessage());
        }
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,hadir,reschedule,diterima,ditolak',
            'catatan' => 'nullable',
        ]);

        $program = Program::findOrFail($id);
        $program->status = $request->status;
        $program->catatan = $request->catatan;
        $program->save();

        return redirect()->back()->with('success', 'Status pendaftaran murid berhasil diperbarui.');
    }


public function modalUpdate(Request $request, $uuid)
{
    $validated = $request->validate([
        'disability_uuid' => ['required', 'exists:disabilities,uuid'],
        'nama_anak'       => ['required', 'string', 'max:255'],
        'tempat_lahir'    => ['required', 'string', 'max:255'],
        'tanggal_lahir'   => ['required', 'date'],
        'jenis_kelamin'   => ['required', 'in:L,P'],
        'agama'           => ['required', 'string', 'max:50'],
        'anak_ke'         => ['required', 'numeric'],
        'nama_ayah'       => ['required', 'string', 'max:255'],
        'nama_ibu'        => ['required', 'string', 'max:255'],
        'alamat'          => ['required', 'string'],
        'no_hp'           => ['required', 'string', 'max:20'],
    ]);

    DB::beginTransaction();

    try {

        $program = Program::where('uuid', $uuid)->firstOrFail();

        // Validasi kepemilikan data
        if ($program->user_uuid !== auth()->user()->uuid) {

            return redirect()->back()->with(
                'error',
                'Anda tidak memiliki izin untuk mengubah data ini.'
            );
        }

        // Ambil disability id berdasarkan uuid
        $disability = Disability::where(
            'uuid',
            $validated['disability_uuid']
        )->first();

        $program->update([

            'disability_uuid' => $disability->uuid,

            'nama_anak'     => $validated['nama_anak'],
            'tempat_lahir'  => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'agama'         => $validated['agama'],
            'anak_ke'       => $validated['anak_ke'],
            'nama_ayah'     => $validated['nama_ayah'],
            'nama_ibu'      => $validated['nama_ibu'],
            'alamat'        => $validated['alamat'],
            'no_hp'         => $validated['no_hp'],
        ]);

        DB::commit();

        return redirect()
            ->route('program.index')
            ->with(
                'success',
                'Data pendaftaran calon murid berhasil diperbarui.'
            );

    } catch (\Throwable $th) {

        DB::rollBack();

        return redirect()
            ->back()
            ->with(
                'error',
                'Terjadi kesalahan: ' . $th->getMessage()
            );
    }
}

    /**
     * Display video komptisi.
     */

    public function videoStore(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'video'      => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $program = Program::findOrFail($validated['program_id']);
                $program->update([
                    'video' => $validated['video'],
                ]);
            });

            return back()->with('success', 'Video kompetisi berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Display materi lomba.
     */

    public function presentasiStore(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'presentasi'      => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $program = Program::findOrFail($validated['program_id']);
                $program->update([
                    'presentasi' => $validated['presentasi'],
                ]);
            });

            return back()->with('success', 'Materi kompetisi berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $this->authorize('view', $program);
        return view('pages.program.show', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function edit($id, $uuid)
    {
        $program = Program::where('id', $id)->firstOrFail();

        // Super admin dan admin boleh akses tanpa cocokkan UUID
        if (!auth()->user()->hasRole(['admin', 'super-admin'])) {
            if ($uuid !== auth()->user()->uuid || $program->user_uuid !== $uuid) {
                abort(403, 'Akses ditolak');
            }
        }

        return view('pages.program.edit', compact('program'));
    }



    public function update(Request $request, $id, $uuid)
    {
        $program = Program::where('id', $id)->where('user_uuid', $uuid)->firstOrFail();

        $request->validate([
            'latar_belakang' => 'required|string',
            'deskripsi_kegiatan' => 'required|string',
            'hasil' => 'required|string',
            'video' => 'required|string',
            'presentasi' => 'required|string',
            'logo_komunitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $program->latar_belakang = $request->latar_belakang;
        $program->deskripsi_kegiatan = $request->deskripsi_kegiatan;
        $program->hasil = $request->hasil;
        $program->video = $request->video;
        $program->presentasi = $request->presentasi;

        if ($request->hasFile('logo_komunitas')) {
            if ($program->logo_komunitas) Storage::delete($program->logo_komunitas);
            $program->logo_komunitas = $request->file('logo_komunitas')->store('program/logo', 'public');
        }

        $foto = $request->existing_foto_kegiatan ?? [];
        $program->foto_kegiatan_1 = $foto[0] ?? null;
        $program->foto_kegiatan_2 = $foto[1] ?? null;
        $program->foto_kegiatan_3 = $foto[2] ?? null;
        $program->foto_kegiatan_4 = $foto[3] ?? null;
        $program->foto_kegiatan_5 = $foto[4] ?? null;

        $program->save();

        return redirect()->route('program.index', [$program->id, $program->user_uuid])
            ->with('success', 'Program berhasil diperbarui.');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('file')->store('program/foto');

        return response()->json(['path' => $path]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        try {
            for ($i = 1; $i <= 5; $i++) {
                $field = 'foto_kegiatan_' . $i;
                if (!empty($program->$field)) {
                    Storage::disk('public')->delete($program->$field);
                }
            }

            if (!empty($program->logo_komunitas)) {
                Storage::disk('public')->delete($program->logo_komunitas);
            }

            $program->delete();

            return redirect()->route('program.index')->with('success', 'Data murid berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
