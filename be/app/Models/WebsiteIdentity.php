<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WebsiteIdentity extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
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
        'logo',
        'favicon',
        'og_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Ambil satu-satunya baris identitas (buat default bila belum ada).
     */
    public static function singleton(): self
    {
        return static::firstOrCreate(
            [],
            ['site_name' => 'YogaRoots', 'site_title' => 'YogaRoots']
        );
    }

    public function logoUrl(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function faviconUrl(): ?string
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : null;
    }

    public function ogImageUrl(): ?string
    {
        return $this->og_image ? asset('storage/' . $this->og_image) : null;
    }
}
