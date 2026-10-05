<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Statistik publik untuk frontend (angka agregat saja, tanpa data personal).
 * GET /api/site-stats — tanpa auth, di-cache 1 jam.
 */
class SiteStatsController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Cache::remember('site-stats:public', 3600, function () {
                return [
                    'members' => User::role('user')->count(),
                    'instructors' => User::role('instruktur')->count(),
                    'classes' => ClassModel::query()->where('is_active', 'active')->count(),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Site statistics retrieved successfully',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Site stats fetch error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch site statistics',
                'data' => null,
            ], 500);
        }
    }
}
