<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banner';
    protected $guarded = [];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

   public function gambar()
    {
        return asset('storage/' . $this->gambar);
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
