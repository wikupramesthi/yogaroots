<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';
    protected $guarded = [];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    public function fotos()
    {
        return $this->belongsToMany(Banner::class, 'album_foto', 'album_uuid', 'banner_uuid');
    }

    public function coverFoto()
    {
        if ($this->cover) {
            // Pakai relasi yang sudah di-load bila ada (hindari N+1).
            if ($this->relationLoaded('fotos')) {
                $foto = $this->fotos->firstWhere('uuid', $this->cover);
                if ($foto) {
                    return $foto;
                }
            }

            $foto = Banner::where('uuid', $this->cover)->first();
            if ($foto) {
                return $foto;
            }
        }

        if ($this->relationLoaded('fotos')) {
            return $this->fotos->first();
        }

        return $this->fotos()->first();
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
