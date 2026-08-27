<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Facades\SEO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class Article extends Model
{
    use HasFactory, HasSEO, SoftDeletes;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'category_uuid',
        'title',
        'slug',
        'excerpt',
        'content',
        'scheduled_at',
        'tagging',
        'status',
        'video',
        'search_engine',
        'featured_image',
        'views'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }
    

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('scheduled_at', '<=', now())
                ->orWhereNull('scheduled_at');
        });
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getDynamicSEOData(): SEOData
    {
        Log::info('getDynamicSEOData called for Article ID: ' . $this->id);

        return new SEOData(
            description: $this->excerpt,
            title: $this->title,
            image: $this->featured_image,
            author: $this->user->name,
            robots: 'index, follow',
            canonical_url: route('articles.index', $this->slug),
            schema: SchemaCollection::make()->addArticle(),
        );
    }

    public function isAdmin()
    {
        return $this->is_admin === true;
    }
}
