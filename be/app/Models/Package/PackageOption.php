<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageOption extends Model
{
    use HasUuids;

    protected $table = 'package_options';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'package_uuid',
        'name',
        'quota',
        'price',
        'discount_price',
        'duration',
        'duration_unit',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'quota' => 'integer',
        'price' => 'integer',
        'discount_price' => 'integer',
        'duration' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(
            Package::class,
            'package_uuid',
            'uuid'
        );
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
}
