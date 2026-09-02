<?php

namespace App\Models\Class;

use App\Models\User;
use App\Models\Package\Package;
use App\Models\Payment\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassBooking extends Model
{
    use HasUuids;

    protected $table = 'class_bookings';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_uuid',
        'class_schedule_uuid',
        'booking_type',
        'quota_used',
        'status',
        'booked_at',
        'attended_at',
        'package_uuid',
        'order_uuid',
    ];

    protected $casts = [
        'quota_used' => 'integer',
        'booked_at' => 'datetime',
        'attended_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(
            ClassSchedule::class,
            'class_schedule_uuid',
            'uuid'
        );
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(
            Package::class,
            'package_uuid',
            'uuid'
        );
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_uuid',
            'uuid'
        );
    }
}