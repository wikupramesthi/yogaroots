<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WebsiteIdentityController extends Controller
{
    /**
     * Tampilkan form tunggal identitas website (ala DBMSDA:
     * GET /backend/website-identity).
     */
    public function index()
    {
        $identitas = WebsiteIdentity::singleton();

        return view('pages.website-identity.index', [
            'title' => 'Identitas Website',
            'identitas' => $identitas,
        ]);
    }

    /**
     * Simpan perubahan identitas website (PUT /backend/website-identity).
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name'               => 'required|string|max:255',
            'site_title'              => 'required|string|max:255',
            'tagline'                 => 'nullable|string|max:255',
            'short_description'       => 'nullable|string',
            'email'                   => 'nullable|email|max:255',
            'phone'                   => 'nullable|string|max:50',
            'address'                 => 'nullable|string',
            'facebook_url'            => 'nullable|url|max:255',
            'instagram_url'           => 'nullable|url|max:255',
            'youtube_url'             => 'nullable|url|max:255',
            'tiktok_url'              => 'nullable|url|max:255',
            'meta_title'              => 'nullable|string|max:255',
            'meta_description'        => 'nullable|string',
            'meta_keywords'           => 'nullable|string',
            'google_analytics_id'     => 'nullable|string|max:50',
            'google_site_verification' => 'nullable|string|max:255',
            'logo'                    => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'favicon'                 => 'nullable|file|mimes:ico,png,jpg,jpeg,webp|max:1024',
            'og_image'                => 'nullable|image|mimes:png,jpg,jpeg,webp|max:3072',
            'remove_logo'             => 'nullable|boolean',
            'remove_favicon'          => 'nullable|boolean',
            'remove_og_image'         => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $identitas = WebsiteIdentity::singleton();

            $data = $request->only([
                'site_name',
                'site_title',
                'tagline',
                'short_description',
                'email',
                'phone',
                'address',
                'facebook_url',
                'instagram_url',
                'youtube_url',
                'tiktok_url',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'google_analytics_id',
                'google_site_verification',
            ]);

            foreach (['logo', 'favicon', 'og_image'] as $field) {
                $remove = 'remove_' . $field;

                if ($request->hasFile($field)) {
                    if ($identitas->{$field} && Storage::disk('public')->exists($identitas->{$field})) {
                        Storage::disk('public')->delete($identitas->{$field});
                    }
                    $data[$field] = $request->file($field)->store('website-identity', 'public');
                } elseif ($request->boolean($remove)) {
                    if ($identitas->{$field} && Storage::disk('public')->exists($identitas->{$field})) {
                        Storage::disk('public')->delete($identitas->{$field});
                    }
                    $data[$field] = null;
                }
            }

            $identitas->update($data);

            DB::commit();

            return redirect()->route('website-identity.index')->with('success', 'Website identity saved successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
