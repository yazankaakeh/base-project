<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'cms_menus';

    public array $translatable = [
        'name',
    ];

    protected $fillable = [
        'name',
        'slug',
        'location',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->with('children');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBySlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }
}
