<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(): JsonResponse
    {
        try {
            $testimoni = Testimonial::where('is_active', 'active')
                ->orderBy('urutan', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar Testimoni berhasil diambil',
                'data' => TestimonialResource::collection($testimoni)
            ], 200);

        } catch (\Exception $e) {
            // Log error supaya mudah debugging
            Log::error('FAQ fetch error: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil FAQ',
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
