<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'page' => ['nullable', 'integer', 'min:1'],
                'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            ]);

            $perPage = $request->input('per_page', 20);

            $instructors = User::role('instruktur')
                ->with('specializations')
                ->orderBy('name')
                ->paginate($perPage);

            return response()->json([
                'status' => 'success',

                'message' => $instructors->isEmpty()
                    ? 'Belum ada instruktur yang tersedia'
                    : 'Data instruktur berhasil diambil',

                'data' => InstructorResource::collection(
                    $instructors->items()
                ),

                'meta' => [
                    'current_page' => $instructors->currentPage(),
                    'per_page' => $instructors->perPage(),
                    'total' => $instructors->total(),
                    'last_page' => $instructors->lastPage(),
                    'from' => $instructors->firstItem(),
                    'to' => $instructors->lastItem(),
                ],
            ], 200);
        } catch (Throwable $e) {

            \Log::error('Instructor API error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data instruktur',
                'data' => [],
            ], 500);
        }
    }
}
