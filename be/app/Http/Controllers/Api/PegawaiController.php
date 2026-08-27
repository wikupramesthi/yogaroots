<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PegawaiResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $pegawai = User::whereHas('roles', function ($query) {
                $query->where('name', 'guru');
            })
                ->orderBy('created_at', 'ASC')
                ->get();

            if ($pegawai->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ada data pegawai dengan role guru saat ini',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data pegawai tenaga pendidik berhasil diambil',
                'data' => PegawaiResource::collection($pegawai)
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Pegawai fetch error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data pegawai',
                'data' => []
            ], 500);
        }
    }

    public function show(string $uuid)
    {
        try {
            $pegawai = User::where('uuid', $uuid)->firstOrFail();

            return response()->json([
                'status' => 'success',
                'message' => 'Detail pegawai berhasil diambil',
                'data' => new PegawaiResource($pegawai)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pegawai tidak ditemukan',
                'data' => null
            ], 404);
        } catch (\Throwable $e) {
            Log::error('Pegawai show error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pegawai',
                'data' => null
            ], 500);
        }
    }
}
