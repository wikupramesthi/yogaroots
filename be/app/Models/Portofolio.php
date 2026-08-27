<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;
    protected $table = 'portofolio';
    protected $guarded = ['id'];

    public function gambar()
    {
        return $this->hasMany(PortofolioGambar::class);
    }

    public function gambar_utama()
    {
        $gambar = $this->gambar()->first();
        if ($gambar) {
            return asset('storage/' . $gambar->gambar);
        } else {
            return asset('assets/images/samples/1280x768/10.jpg');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
