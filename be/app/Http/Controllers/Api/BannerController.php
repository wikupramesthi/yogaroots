<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Hanya ambil banner yang aktif
            $query = Banner::where('status', 'active');

            $allowedKategori = ['slider', 'pengumuman', 'infografis', 'galeri', 'popup', 'mitra', 'lainnya'];

            if ($request->has('kategori') && in_array($request->kategori, $allowedKategori)) {
                $query->where('posisi', $request->kategori);
            }

            $banners = $query->orderBy('created_at', 'asc')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar banner berhasil diambil',
                'data' => BannerResource::collection($banners)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Banner fetch error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data banner',
                'data' => []
            ], 500);
        }
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
