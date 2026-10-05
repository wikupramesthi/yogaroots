<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebsiteIdentity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Identitas website publik untuk frontend (nama, kontak, sosmed, SEO, branding).
 * GET /api/website-identity — tanpa auth, di-cache 1 jam, hanya field publik.
 */
class WebsiteIdentityController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Cache::remember('website-identity:public', 3600, function () {
                $identity = WebsiteIdentity::singleton();

                return [
                    // Informasi umum
                    'site_name' => $identity->site_name,
                    'site_title' => $identity->site_title,
                    'tagline' => $identity->tagline,
                    'short_description' => $identity->short_description,
                    // Kontak & sosial media
                    'email' => $identity->email,
                    'phone' => $identity->phone,
                    'address' => $identity->address,
                    'facebook_url' => $identity->facebook_url,
                    'instagram_url' => $identity->instagram_url,
                    'youtube_url' => $identity->youtube_url,
                    'tiktok_url' => $identity->tiktok_url,
                    // SEO & meta (publik by nature: terbaca di <head>)
                    'meta_title' => $identity->meta_title,
                    'meta_description' => $identity->meta_description,
                    'meta_keywords' => $identity->meta_keywords,
                    'google_analytics_id' => $identity->google_analytics_id,
                    'google_site_verification' => $identity->google_site_verification,
                    // Branding (URL absolut siap pakai untuk <img> & OG tags)
                    'logo_url' => $identity->logoUrl(),
                    'favicon_url' => $identity->faviconUrl(),
                    'og_image_url' => $identity->ogImageUrl(),
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Website identity retrieved successfully',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Website identity fetch error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch website identity',
                'data' => null,
            ], 500);
        }
    }
}
