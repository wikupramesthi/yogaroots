<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    /**
     * Menampilkan semua event.
     */
    public function index(): JsonResponse
    {
        try {
            $events = Event::orderBy('created_at', 'DESC')->get();

            if ($events->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada event yang tersedia',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data event berhasil diambil',
                'data' => EventResource::collection($events)
            ], 200);
        } catch (\Throwable $e) {

            Log::error('Event fetch error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data event',
                'data' => []
            ], 500);
        }
    }

    /**
     * Menampilkan detail event berdasarkan slug.
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $event = Event::where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();

            return response()->json([
                'status' => 'success',
                'message' => 'Detail event berhasil diambil',
                'data' => new EventResource($event)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Event tidak ditemukan',
                'data' => null
            ], 404);
        } catch (\Throwable $e) {

            Log::error('Event show error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail event',
                'data' => null
            ], 500);
        }
    }
}
