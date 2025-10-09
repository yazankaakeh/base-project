<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Seo\Traits\HasSeo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model implements HasMedia
{

    use InteractsWithMedia, HasSeo, HasTranslations;

    public array $translatable = [
        'title',
        'description',
    ];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'category_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('img')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, [
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ], true);
            })->singleFile();
    }

}
