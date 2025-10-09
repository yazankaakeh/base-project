<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Seo\Traits\HasSeo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model implements HasMedia
{

    use InteractsWithMedia, HasSeo, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    public array $translatable = [
        'title',
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'authorable_id',
        'authorable_type',
        'title',
        'description',
        'clapping',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(BlogCategory::class, 'id', 'category_id');
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

    public function patient(): BelongsToMany
    {
        return $this
            ->belongsToMany(BlogPostTags::class, 'blog_post_tags_posts')
            ->using(BlogPostTagsPosts::class); // optional
    }

    public function authorable(): MorphTo
    {
        return $this->morphTo();
    }
}
