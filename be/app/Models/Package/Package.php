<?php

namespace App\Models\Package;

use App\Models\User;
use App\Models\Payment\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasUuids;

    protected $table = 'packages';
    protected $primaryKey = 'uuid';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(
            PackageOption::class,
            'package_uuid',
            'uuid'
        )->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(
            PackageFeature::class,
            'package_uuid',
            'uuid'
        )->orderBy('sort_order');
    }

    public function users(): HasMany
    {
        return $this->hasMany(
            User::class,
            'package_uuid',
            'uuid'
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(
            Order::class,
            'package_uuid',
            'uuid'
        );
    }
}
