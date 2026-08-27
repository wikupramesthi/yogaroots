<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FileDownload;
use Illuminate\Http\Request;

class FileDownloadApiController extends Controller
{
    public function index(Request $request)
    {
        $query = FileDownload::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->latest()->get()
        ]);
    }

    public function show($id)
    {
        $item = FileDownload::find($id);

        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $item
        ]);
    }
}
