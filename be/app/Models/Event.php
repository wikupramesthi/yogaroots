<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'kapasitas',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'kapasitas' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (!$event->uuid) {
                $event->uuid = (string) Str::uuid();
            }
        });
    }

    public function gambar()
    {
        return asset('storage/' . $this->gambar);
    }
}
