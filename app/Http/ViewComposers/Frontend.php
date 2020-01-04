<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;

use App\NewsCategory;

class Frontend {

    //    protected $param;

    /**
    * Create a new  composer.
    * @return void
    */
    public function __construct() {
        // Dependencies automatically resolved by service container...
    }

    /**
    * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view) {
        $newsCategories = NewsCategory::getByAll();
        view()->share(['newsCategories' => $newsCategories]);
    }

}