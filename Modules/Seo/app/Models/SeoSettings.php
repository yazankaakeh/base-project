<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSettings extends Model
{

    protected $fillable = ['key', 'value'];
    protected $casts = ['value' => 'array'];


    /*public static function put($key, $value)
    {
        Cache::forget("seo:settings");
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }*/
}
