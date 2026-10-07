<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banner';
    protected $fillable = [
        'uuid',
        'tipe',
        'nama',
        'deskripsi',
        'status',
        'link',
        'video_url',
        'posisi',
        'gambar',
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    public const POSISI = [
        'slider'      => ['label' => 'Banner / Slider', 'badge' => 'primary'],
        'pengumuman'  => ['label' => 'Announcement',    'badge' => 'warning'],
        'infografis'  => ['label' => 'Infographic',     'badge' => 'info'],
        'galeri'      => ['label' => 'Photo Gallery',   'badge' => 'success'],
        'popup'       => ['label' => 'Popup',           'badge' => 'danger'],
        'mitra'       => ['label' => 'Partners',        'badge' => 'secondary'],
        'lainnya'     => ['label' => 'Others',          'badge' => 'dark'],
    ];

    public function gambar()
    {
        return asset('storage/' . $this->gambar);
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_foto', 'banner_uuid', 'album_uuid');
    }

    public function isVideo()
    {
        return $this->tipe === 'video';
    }

    public function isFilm()
    {
        return $this->tipe === 'foto';
    }

    public function posisiLabel()
    {
        return self::POSISI[$this->posisi]['label'] ?? ucfirst($this->posisi);
    }

    public function posisiBadge()
    {
        return self::POSISI[$this->posisi]['badge'] ?? 'secondary';
    }

    /**
     * Get the YouTube / Vimeo video ID from the URL.
     */
    public function videoId()
    {
        if (! $this->video_url) {
            return null;
        }

        $url = $this->video_url;

        if (preg_match('/(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/|live\/|v\/)|youtu\.be\/)([\w-]{6,})/', $url, $m)) {
            return ['provider' => 'youtube', 'id' => $m[1]];
        }

        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $m)) {
            return ['provider' => 'vimeo', 'id' => $m[1]];
        }

        return null;
    }

    public function videoThumb()
    {
        $v = $this->videoId();
        if (! $v) {
            return null;
        }

        if ($v['provider'] === 'youtube') {
            return 'https://img.youtube.com/vi/' . $v['id'] . '/hqdefault.jpg';
        }

        return 'https://i.vimeocdn.com/video/' . $v['id'] . '_640x360.jpg';
    }

    public function videoEmbedUrl()
    {
        $v = $this->videoId();
        if (! $v) {
            return null;
        }

        if ($v['provider'] === 'youtube') {
            return 'https://www.youtube.com/embed/' . $v['id'];
        }

        return 'https://player.vimeo.com/video/' . $v['id'];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
