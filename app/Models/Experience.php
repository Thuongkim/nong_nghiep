<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class Experience extends \Eloquent {

    public static function rules($id = 0) {

        return [
            'fullname'  => 'required|max:50',
            "email"     => "required|email|max:50",
            'phone'     => 'max:11|regex:/[0]\d{9,11}$/',
            'content'   => 'required|max:1024',
            'image'     => 'max:4096|mimes:jpg,jpeg,png,gif',
        ];
    }

	protected $fillable = [ 'fullname', 'email', 'phone', 'position', 'image', 'status', 'content' ];

    public static function boot()
    {
        parent::boot();

        static::updated(function($page)
        {
            self::clearCache();
        });

        static::deleted(function($page)
        {
            self::clearCache();
        });

        static::saved(function($page)
        {
            self::clearCache();
        });
    }

    public static function clearCache()
    {
        Cache::forget('experiences');
    }

    public static function getByAll()
    {
        $experiences = [];
        if (!Cache::has('experiences')) {
            $experiences = Experience::where('status', 1)->select('fullname', 'email', 'phone', 'content', 'image')->orderBy('position')->get();
            $experiences = json_encode($experiences);
            Cache::forever('experiences', $experiences);
        } else {
            $experiences = Cache::get('experiences');
        }

        return json_decode($experiences, 1);
    }
}