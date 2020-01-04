<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class NewsCategory extends \Eloquent {
    public static function rules($id = 0) {

        return [
            'name'                  => 'required|max:50',
            'summary'               => 'max:150',
            'image'                 => 'max:4096|mimes:jpg,jpeg,png,gif',
            'seo_keywords'          => 'max:50',
            'seo_description'       => 'max:255',
            'level1'                => ($id == 0 ? 'required|' : '') . 'integer',
        ];

    }

    protected $fillable = [ 'name', 'summary', 'parent_id', 'image', 'view_all', 'status', 'seo_keywords', 'seo_description', 'created_by', 'position', 'created_by', 'show_menu' ];

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

        static::created(function($page)
        {
            self::clearCache();
        });

    }

    public static function clearCache()
    {
        Cache::forget('news_categories');
        Cache::forget('news_categories_top4');
    }

    public function news()
    {
        return $this->hasMany('App\News', 'category_id');
    }
    public function getChildrenIds()
    {
        $ids = "";
        $childrenLevel1 = NewsCategory::where('parent_id', $this->id)->get();
        foreach ($childrenLevel1 as $children) {
            $ids .= ',' . $children->id;
            $childrenLevel2 = NewsCategory::where('parent_id', $children->id)->select('id')->get()->toArray();
            if (count($childrenLevel2))
                $ids .= ',' . implode(',', array_column($childrenLevel2, 'id'));
        }
        return $ids;
    }

    public function getSiblingsIds()
    {
        $ids = "";
        $siblings = NewsCategory::where('parent_id', $this->parent_id)->get();
        foreach ($siblings as $sibl) {
            $ids .= ',' . $sibl->id;
        }
        return $ids;
    }

    public function getParentsIds()
    {
        $ids = "";
        $parentsLevel1 = NewsCategory::where('id', $this->parent_id)->get();
        foreach ($parentsLevel1 as $parent) {
            $ids .= ',' . $parent->id;
            $parentsLevel2 = NewsCategory::where('id', $parent->parent_id)->select('id')->get()->toArray();
            if (count($parentsLevel2))
                $ids .= ',' . implode(',', array_column($parentsLevel2, 'id'));
        }
        return $ids;
    }

    public function countSameType()
    {
        return NewsCategory::where("parent_id", $this->parent_id)->count();
    }

    public function getRoot()
    {
        if ($this->parent_id) {
            $rootCat = NewsCategory::find($this->parent_id);
            if (is_null($rootCat)) return $this; // moi them vao ErrorException: Trying to get property of non-object in...
            if ($rootCat->parent_id) {
                $rootCat = NewsCategory::find($rootCat->parent_id);
            }

            return $rootCat;
        }

        return $this;
    }

    public static function getByAll()
    {
        $categories = [];
        if (!Cache::has('news_categories')) {
            $categories = NewsCategory::where('parent_id', 0)->where('status', 1)->select('id', 'name', 'image', 'view_all', 'show_menu')->orderBy('position')->get();
            for ($i=0; $i < $categories->count(); $i++) {
                $children = NewsCategory::where('parent_id', $categories{$i}->id)->where('status', 1)->select('id', 'name', 'image', 'view_all', 'show_menu')->orderBy('position')->get();
                for ($j=0; $j < $children->count(); $j++) {
                    $children{$j}->children = NewsCategory::where('parent_id', $children{$j}->id)->where('status', 1)->select('id', 'name', 'image', 'view_all', 'show_menu')->orderBy('position')->get();

                }
                $categories{$i}->children = $children;
            }

            $categories = json_encode($categories);
            Cache::forever('news_categories', $categories, 1);
        } else {
            $categories = Cache::get('news_categories');
        }

        return json_decode($categories, 1);
    }

    public static function getTop4ByPosition()
    {
        $categories = [];
        if (!Cache::has('news_categories_top4')) {
            $categories = NewsCategory::where('parent_id', 0)->where('status', 1)->select('id', 'name', 'image', 'view_all')->orderBy('position')->take(6)->get();
            for ($i = 0; $i < $categories->count(); $i++) {
                // find view default view & list ids = (id current + child + grand child)
                $ids = $categories{$i}->id;
                $childrenLevel1 = NewsCategory::where('parent_id', $categories{$i}->id)->where('status', 1)->get();
                foreach ($childrenLevel1 as $children) {
                    if ($children->view_all) {
                        $categories{$i}->view_all_category = ['id' => $children->id, 'name' => $children->name];
                    }
                    $ids .= ',' . $children->id;
                    // tim den chau
                    $childrenLevel2 = NewsCategory::where('parent_id', $children->id)->where('status', 1)->get();
                    foreach ($childrenLevel2 as $grandChild) {
                        if ($grandChild->view_all) {
                            $categories{$i}->view_all_category = ['id' => $children->id, 'name' => $children->name];
                        }
                        $ids .= ',' . $grandChild->id;
                    }
                }
                //->where('featured', 1)
                // $i == 2 ? 8 : 4
                $categories{$i}->news = News::where('status', 1)->whereIn("category_id", explode(',', $ids))->take(8)->select("id", "title", "image", "summary", "updated_at", 'count_comment')->orderBy('updated_at', 'DESC')->get();
            }

            $categories = json_encode($categories);
            Cache::forever('news_categories_top4', $categories, 1);
        } else {
            $categories = Cache::get('news_categories_top4');
        }

        return json_decode($categories, 1);
    }
}