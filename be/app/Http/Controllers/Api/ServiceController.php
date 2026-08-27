<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Service::where('status', 'active');

            $allowedKategori = ['ekstrakurikuler', 'kegiatan', 'bimbingan'];
            if ($request->has('kategori') && in_array($request->kategori, $allowedKategori)) {
                $query->where('kategori_layanan', $request->kategori);
            }

            $services = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar kegiatan siswa berhasil diambil',
                'data' => ServiceResource::collection($services),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Service fetch error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data',
                'data' => [],
            ], 500);
        }
    }
}
