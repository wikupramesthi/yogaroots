<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileDownload extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'file', 'kategori'];
}
