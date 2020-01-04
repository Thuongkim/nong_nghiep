<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class Slider extends \Eloquent {

    public static function rules($id = 0) {

        return [
            'name'                  => 'required|max:50',
            'href'                  => 'required|url|max:150',
            'image'                  => ($id == 0 ? 'required|' : '') . 'max:4096|mimes:jpg,jpeg,png,gif',
        ];
    }

	protected $fillable = [ 'name', 'href', 'created_by', 'position', 'image', 'status' ];

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
        Cache::forget('sliders');
    }

    public static function getSliders()
    {
        $sliders = [];
        if (!Cache::has('sliders')) {
            $sliders = Slider::where('status', 1)->select('name', 'href', 'image')->orderBy('position')->get();
            $sliders = json_encode($sliders);
            Cache::forever('sliders', $sliders);
        } else {
            $sliders = Cache::get('sliders');
        }

        return json_decode($sliders, 1);
    }
}