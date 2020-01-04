<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class News extends \Eloquent {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function rules($id = 0) {

        return [
            'title'                 => 'required|max:255',
            'summary'               => 'required|max:500',
            'content'               => 'required',
            'image'                 => ($id == 0 ? 'required|' : '') . 'max:2048|mimes:jpg,jpeg,png,gif',
            'seo_keywords'          => 'max:255',
            'seo_description'       => 'max:1024',
            'created_by'            => 'integer',
            'category'              => 'required|integer',
        ];

    }

	protected $fillable = [ 'title', 'summary', 'content', 'view_counter', 'status', 'image', 'seo_keywords', 'seo_description', 'created_by', 'featured', 'category_id', 'deleted_by', 'count_comment' ];

    public function comments()
    {
        return $this->hasMany("\App\Comment");
    }

    public function category()
    {
        return $this->belongsTo("\App\NewsCategory");
    }

    public static function clearCache()
    {
        Cache::forget('news_categories_top4');
        Cache::forget('news_categories');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($news)
        {
            self::clearCache();
        });

        static::updated(function($news)
        {
            self::clearCache();
        });

        static::deleted(function($news)
        {
            self::clearCache();
        });

        static::saved(function($news)
        {
            self::clearCache();
        });
    }
}