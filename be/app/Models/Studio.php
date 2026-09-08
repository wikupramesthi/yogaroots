<?php

namespace App\Models;

use App\Models\Class\ClassModel;
use App\Models\Class\ClassSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Studio extends Model
{
    use HasUuids;

    protected $table = 'studios';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'excerpt',
        'description',
        'address',
        'phone',
        'email',
        'google_maps_url',
        'image',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($studio) {
            if (empty($studio->uuid)) {
                $studio->uuid = (string) Str::uuid();
            }

            if (empty($studio->slug)) {
                $studio->slug = Str::slug($studio->name);
            }
        });

        static::updating(function ($studio) {
            if ($studio->isDirty('name')) {
                $studio->slug = Str::slug($studio->name);
            }
        });
    }

    /**
     * Studio schedules
     */
    public function schedules()
    {
        return $this->hasMany(
            ClassSchedule::class,
            'studio_uuid',
            'uuid'
        );
    }

    /**
     * Classes available at this studio
     */
    public function classes()
    {
        return $this->belongsToMany(
            ClassModel::class,
            'class_schedules',
            'studio_uuid',
            'class_uuid',
            'uuid',
            'uuid'
        )->distinct();
    }
}
