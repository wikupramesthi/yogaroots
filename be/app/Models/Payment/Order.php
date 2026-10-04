<?php

namespace App\Models\Payment;

use App\Models\User;
use App\Models\Package\Package;
use App\Models\Class\ClassSchedule;
use App\Models\Class\ClassBooking;
use App\Models\Package\PackageOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasUuids;

    protected $table = 'orders';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_uuid',
        'order_number',
        'type',
        'package_uuid',
        'package_option_uuid',
        'class_schedule_uuid',
        'amount',
        'status',
        'expired_at',
        'paid_at',
        'admin_note',
        'proof_image_path',
        'proof_uploaded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
        'proof_uploaded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
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

    public function packageOption(): BelongsTo
    {
        return $this->belongsTo(
            PackageOption::class,
            'package_option_uuid',
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

    public function payment(): HasOne
    {
        return $this->hasOne(
            Payment::class,
            'order_uuid',
            'uuid'
        );
    }

    public function booking(): HasOne
    {
        return $this->hasOne(
            ClassBooking::class,
            'order_uuid',
            'uuid'
        );
    }

    /**
     * Route URL of the uploaded transfer proof, if any.
     * Served through the app (owner/admin only), never a
     * guessable public URL. Relative so it works on any host.
     */
    public function proofUrl(): ?string
    {
        return $this->proof_image_path
            ? route('orders.proof.show', $this->uuid, false)
            : null;
    }
}
