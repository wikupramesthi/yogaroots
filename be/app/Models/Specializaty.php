<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Specializaty extends Model
{
    use HasFactory;

    protected $table = 'specializations';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'description',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class, 'specializaty_uuid', 'uuid');
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_specialization',
            'specialization_uuid',
            'user_uuid',
            'uuid',
            'uuid'
        );
    }
}
