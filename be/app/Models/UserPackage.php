<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserPackage extends Model
{
    use HasUuids;

    protected $table = 'user_packages';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'package_uuid',
        'order_uuid',
        'quota',
        'started_at',
        'expired_at',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_uuid',
            'uuid'
        );
    }

    public function package()
    {
        return $this->belongsTo(
            Package::class,
            'package_uuid',
            'uuid'
        );
    }

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'order_uuid',
            'uuid'
        );
    }
}
