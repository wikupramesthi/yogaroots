<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use App\Models\Specializaty;
use Illuminate\Database\Eloquent\Relations\Pivot;

// payment
use App\Models\Package\Package;
use App\Models\Class\ClassModel;
use App\Models\Class\ClassBooking;
use App\Models\Payment\Order;


use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'avatar',
        'name',
        'password',
        'email_verified_at',
        'email',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pengalaman',
        'is_active',
        'alamat',
        'facebook',
        'instagram',
        'twitter',
        'tiktok',
        'youtube',
        'biografi',
        'sumber_informasi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'uuid';
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

            'membership_start_date' => 'date',
            'membership_end_date' => 'date',
            'total_quota' => 'integer',
            'remaining_quota' => 'integer',
        ];
    }

    /**
     * Auto-generate UUID when creating user.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = Str::uuid()->toString();
            }
        });
    }

    /**
     * Relationship to Kecamatan.
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Relationship to Kelurahan.
     */
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'user_uuid', 'uuid');
    }

    public function specializations()
    {
        return $this->belongsToMany(
            Specializaty::class,
            'user_specialization',
            'user_uuid',
            'specialization_uuid',
            'uuid',
            'uuid'
        )->using(UserSpecialization::class);
    }

    public function package()
    {
        return $this->belongsTo(
            Package::class,
            'package_uuid',
            'uuid'
        );
    }

    public function classes()
    {
        return $this->hasMany(
            ClassModel::class,
            'instructor_uuid',
            'uuid'
        );
    }

    public function orders()
    {
        return $this->hasMany(
            Order::class,
            'user_uuid',
            'uuid'
        );
    }

    public function bookings()
    {
        return $this->hasMany(
            ClassBooking::class,
            'user_uuid',
            'uuid'
        );
    }
}
