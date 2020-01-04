<?php

function trendingTags()
{
    $trending_tags = App\Hashtag::orderBy('count', 'desc')->get();

    if (count($trending_tags) > 0) {
        if (count($trending_tags) > (int) Setting::get('min_items_page', 3)) {
            $trending_tags = $trending_tags->random((int) Setting::get('min_items_page', 3));
        }
    } else {
        $trending_tags = '';
    }

    return $trending_tags;
}


