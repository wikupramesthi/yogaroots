<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use App\Models\Class\ClassModel;
use Illuminate\Http\Request;
use Throwable;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'level' => [
                    'nullable',
                    'in:foundation,intermediate,advance'
                ],
                'instructor_uuid' => [
                    'nullable',
                    'uuid',
                    'exists:users,uuid'
                ],
                'page' => [
                    'nullable',
                    'integer',
                    'min:1'
                ],
                'per_page' => [
                    'nullable',
                    'integer',
                    'min:1',
                    'max:50'
                ],
            ]);

            $perPage = $request->input('per_page', 20);

            $query = ClassModel::query()
                ->with('instructor')
                ->where('is_active', 'active');

            if ($request->filled('level')) {
                $query->where(
                    'level',
                    $request->level
                );
            }

            if ($request->filled('instructor_uuid')) {
                $query->where(
                    'instructor_uuid',
                    $request->instructor_uuid
                );
            }

            $classes = $query
                ->orderBy('name')
                ->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'message' => $classes->isEmpty()
                    ? 'Belum ada class yang tersedia'
                    : 'Data class berhasil diambil',
                'data' => ClassResource::collection(
                    $classes->items()
                ),
                'meta' => [
                    'current_page' => $classes->currentPage(),
                    'per_page' => $classes->perPage(),
                    'total' => $classes->total(),
                    'last_page' => $classes->lastPage(),
                    'from' => $classes->firstItem(),
                    'to' => $classes->lastItem(),
                ],
            ], 200);

        } catch (Throwable $e) {

            \Log::error(
                'Class API error',
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data class',
                'data' => [],
            ], 500);
        }
    }

    public function show(string $slug)
    {
        try {
            $class = ClassModel::with('instructor')
                ->where('slug', $slug)
                ->where('is_active', 'active')
                ->first();

            if (!$class) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Class tidak ditemukan',
                    'data' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail class berhasil diambil',
                'data' => new ClassResource($class),
            ], 200);

        } catch (Throwable $e) {

            \Log::error(
                'Class detail API error',
                [
                    'slug' => $slug,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil detail class',
                'data' => null,
            ], 500);
        }
    }
}