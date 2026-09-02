<?php

namespace App\Models\Class;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassModel extends Model
{
    use HasUuids;

    protected $table = 'classes';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'quota_cost',
        'instructor_uuid',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quota_cost' => 'integer',
    ];

     public function instructor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'instructor_uuid',
            'uuid'
        );
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(
            ClassSchedule::class,
            'class_uuid',
            'uuid'
        );
    }
}