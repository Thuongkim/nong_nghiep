@extends('frontend.master')
@section('title')Kết quả tìm kiếm @stop
@section('head')
<style type="text/css">
    .tree,.tree ul{margin:0;padding:0;list-style:none}.tree ul{margin-left:1em;position:relative}.tree ul ul{margin-left:.5em}.tree ul:before{content:"";display:block;width:0;position:absolute;top:0;bottom:0;left:0;border-left:1px solid}.tree li{margin:0;padding:0 1em;line-height:2.8em;color:#369;font-weight:700;position:relative}.tree ul li:before{content:"";display:block;width:10px;height:0;border-top:1px solid;margin-top:4px;position:absolute;top:1em;left:0}.tree ul li:last-child:before{background:#fff;height:auto;top:1em;bottom:0}.indicator{margin-right:5px}.tree li a{text-decoration:none;color:#369}.tree li button,.tree li button:active,.tree li button:focus{text-decoration:none;color:#369;border:none;background:transparent;margin:0;padding:0;outline:0}.tree > li{border:1px solid #e4e4e4;border-top:none}
</style>
@stop
@section('breadcrumb')
    <div class="container">
        <div class="drection">
            <div class="link">
                <span><a href="{!! route('home') !!}">{!! trans('system.home') !!}</a></span>
                <span class="divider"></span>
                <span class="">Tìm kiếm</span>
            </div>
        </div>
    </div>
@stop
@section('content')
    <section class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="module-cate">
                        <p class="title_left"><img src="{!! asset('assets/frontend/images/icon_left1.png') !!}"><span>{!! trans('news_categories.label') !!}</span></p>
                        <ul id="menu-nav">
                            @foreach ($newsCategories as $newsCat)
                                <li>
                                    @if (isset($newsCat['children']) && count($newsCat['children']))
                                        <a href="{!! route('home.news-category', ['slug' => str_slug($newsCat['name']), 'id' => $newsCat['id']]) !!}">{!! $newsCat['name'] !!}</a>
                                        <ul>
                                            @foreach ($newsCat['children'] as $children)
                                                @if (isset($children['children']) && count($children['children']))
                                                    <li><a href="{!! route('home.news-category', ['slug' => str_slug($children['name']), 'id' => $children['id']]) !!}">{!! $children['name'] !!}</a>
                                                        <ul>
                                                            @foreach ($children['children'] as $parentChild)
                                                                <li><a href="{!! route('home.news-category', ['slug' => str_slug($parentChild['name']), 'id' => $parentChild['id']]) !!}">{!! $parentChild['name'] !!}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li><a href="{!! route('home.news-category', ['slug' => str_slug($children['name']), 'id' => $children['id']]) !!}">{!! $children['name'] !!}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        <i class='indicator fa fa-minus'></i> <a href="{!! route('home.news-category', ['slug' => str_slug($newsCat['name']), 'id' => $newsCat['id']]) !!}" class="no-child">{!! $newsCat['name'] !!}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="module-cate">
                        <p class="title_left"><img src="{!! asset('assets/frontend/images/icon_left2.png') !!}"><span>{!! trans('news.label') !!} {!! trans('news.featured') !!}</span></p>
                        <div class="module-menu">
                            <ul>
                                @foreach($featuredNews as $item)
                                    <li>
                                        <a href="{!! route('home.news-detail', ['slug' => str_slug($item->title), 'id' => $item->id]) !!}">
                                            <img src="{!! asset(config('upload.news') . $item->image) !!}" alt="{!! $item->title !!}">
                                        </a>
                                        <a class="title" href="{!! route('home.news-detail', ['slug' => str_slug($item->title), 'id' => $item->id]) !!}">
                                            {!! $item->title !!}
                                        </a>
                                        <span><i class="fa fa-clock-o"></i> {!! \App\Helper\HString::timeElapsedString(strtotime($item->updated_at)) !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="excerpt-cate">
                        <h1 class="title_cate"><img src="{!! asset('assets/frontend/images/icon_news.png') !!}"><span>Tìm kiếm</span>
                        </h1>
                    </div>
                    <div class="form-contact">
                        <div class="contact-info">
                            <p><span style="font-size:18px">Kết quả tìm kiếm cho từ khoá '{!! $query !!}'</span></p>
                        </div>
                    </div>
                    <div class="module-art">
                        @foreach($items as $item)
                            <?php $cat = $item->category()->first(); if (is_null($cat)) continue; ?>
                            <div class="border-item">
                                <article class="row">
                                    <div class="col-sm-3">
                                        <div class="thumbnail" style="width:100%">
                                            <a href="{!! route('home.news-detail', ['slug' => str_slug($item->title), 'id' => $item->id]) !!}">
                                                <img src="{!! asset(config('upload.news') . $item->image) !!}" style="width:100%" title="{!! $item->title !!}" alt="{!! $item->title !!}">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post_content col-sm-9">
                                        <div class="post-title">
                                            <a href="{!! route('home.news-detail', ['slug' => str_slug($item->title), 'id' => $item->id]) !!}" title="{!! $item->title !!}">{!! $item->title !!}</a>
                                        </div>
                                        <div class="time">
                                            <span class="day"><i class="fa fa-clock-o"></i> {!! \App\Helper\HString::timeElapsedString(strtotime($item->updated_at)) !!}</span>
                                            <span class="day"><i class="fa fa-commenting-o"></i>{!! $item->count_comment !!}</span>
                                            @if(0 && $cat->id <> $category->id)
                                                <span class="day"><i class="fa fa-commenting-o"></i>
                                                    <a href="{!! route('home.news-category', ['slug' => str_slug($cat->name), 'id' => $cat->id]) !!}">{!! $cat->name !!}</a>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="excerpt">
                                            {!! $item->summary !!}
                                        </div>
                                        <div class="readmore"><a href="{!! route('home.news-detail', ['slug' => str_slug($item->title), 'id' => $item->id]) !!}">Xem chi tiết</a>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                        {{-- {!! $news->links("frontend.pagination_long") !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer')
    <script type="text/javascript">
        $.fn.extend({treed:function(i){var n="fa-minus",c="fa-plus";void 0!==i&&(void 0!==i.openedClass&&(n=i.openedClass),void 0!==i.closedClass&&(c=i.closedClass));var t=$(this);t.addClass("tree"),t.find("li").has("ul").each(function(){var i=$(this);i.prepend("<i class='indicator fa "+c+"'></i>"),i.addClass("branch"),i.on("click",function(i){this==i.target&&($(this).children("i:first").toggleClass(n+" "+c),$(this).children().children().toggle())}),i.children().children().toggle()}),t.find(".branch .indicator").each(function(){$(this).on("click",function(){$(this).closest("li").click()})}),t.find(".branch>a").each(function(){$(this).on("click",function(i){$(this).closest("li").click(),i.preventDefault()})}),t.find(".branch>button").each(function(){$(this).on("click",function(i){$(this).closest("li").click(),i.preventDefault()})})}});
        $('#menu-nav').treed({openedClass:'fa-chevron-right', closedClass:'fa-chevron-down'});
    </script>
@stop