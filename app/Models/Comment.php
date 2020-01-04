<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Comment extends \Eloquent {

    public static function rules($id = 0) {
        return [
            'content' => 'required',
        ];
    }

	protected $fillable = ['news_id', 'content', 'fullname', 'email', 'phone', 'status'];

    public function news()
    {
        return $this->belongsTo("\App\News");
    }

    public static function clearCache()
    {
        // reset for comments
        Cache::forget('news_categories_top4');
        Cache::forget('news_categories');
    }

    public static function boot1()
    {
        parent::boot();

        static::created(function($news)
        {
            // self::clearCache();
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
            // self::clearCache();
        });
    }
}