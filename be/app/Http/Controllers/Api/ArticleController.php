<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $articles = Article::with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status'  => 'success',
                'message' => 'Article list retrieved successfully',
                'data'    => ArticleResource::collection($articles)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Article fetch error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch articles',
                'data'    => []
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
    public function show(string $slug): JsonResponse
    {
        try {
            $article = Article::with(['user', 'category'])
                ->where('slug', $slug)
                ->first();

            if (!$article) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Article not found',
                    'data'    => null,
                ], 404);
            }

            $article->increment('views');

            return response()->json([
                'status'  => 'success',
                'message' => 'Article details retrieved successfully',
                'data'    => new ArticleResource($article),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Article detail error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch article details',
                'data'    => null,
            ], 500);
        }
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

    public function category(): JsonResponse
    {
        try {
            $categories = Category::orderBy('name', 'asc')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Category list retrieved successfully',
                'data' => CategoryResource::collection($categories),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Category fetch error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch categories',
                'data' => [],
            ], 500);
        }
    }

    public function byCategory(string $slug): JsonResponse
    {
        try {
            // Find category
            $category = Category::where('slug', $slug)->first();

            if (!$category) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Category with slug "' . $slug . '" not found',
                    'data'    => []
                ], 404);
            }

            // Fetch articles via relation
            $articles = Article::with(['user', 'category'])
                ->whereHas('category', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            if ($articles->isEmpty()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'No articles yet in category "' . $slug . '"',
                    'data'    => []
                ], 200);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Articles in category "' . $slug . '" retrieved successfully',
                'data'    => ArticleResource::collection($articles)
            ], 200);
        } catch (\Exception $e) {
            Log::error('Article by category fetch error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to fetch articles in category ' . $slug,
                'data'    => []
            ], 500);
        }
    }
}
