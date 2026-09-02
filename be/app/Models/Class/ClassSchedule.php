<?php

namespace App\Models\Class;

use App\Models\Payment\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSchedule extends Model
{
    use HasUuids;

    protected $table = 'class_schedules';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'class_uuid',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'capacity' => 'integer',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(
            ClassModel::class,
            'class_uuid',
            'uuid'
        );
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(
            ClassBooking::class,
            'class_schedule_uuid',
            'uuid'
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(
            Order::class,
            'class_schedule_uuid',
            'uuid'
        );
    }
}