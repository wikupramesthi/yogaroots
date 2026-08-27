<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioGambar extends Model
{
    use HasFactory;
    protected $table = 'portofolio_gambar';
    protected $guarded = ['id'];

    public function gambar()
    {
        return asset('storage/' . $this->gambar);
    }
}
