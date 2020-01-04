@extends('frontend.master')
@section('title'){!! $news->title !!} | {!! trans('news.label') !!}@stop
@section('head')
<style type="text/css">
.tree,.tree ul{margin:0;padding:0;list-style:none}.tree ul{margin-left:1em;position:relative}.tree ul ul{margin-left:.5em}.tree ul:before{content:"";display:block;width:0;position:absolute;top:0;bottom:0;left:0;border-left:1px solid}.tree li{margin:0;padding:0 1em;line-height:2.8em;color:#369;font-weight:700;position:relative}.tree ul li:before{content:"";display:block;width:10px;height:0;border-top:1px solid;margin-top:4px;position:absolute;top:1em;left:0}.tree ul li:last-child:before{background:#fff;height:auto;top:1em;bottom:0}.indicator{margin-right:5px}.tree li a{text-decoration:none;color:#369}.tree li button,.tree li button:active,.tree li button:focus{text-decoration:none;color:#369;border:none;background:transparent;margin:0;padding:0;outline:0}.tree > li{border:1px solid #e4e4e4;border-top:none}
</style>
@stop
@section('fb_init')
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId={!! env("FACEBOOK_CLIENT_ID") !!}&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@stop
@section('slider_banner')
@if ($category->image)
<div class="banner">
    <div class="container">
        <img src="{!! asset($category->image) !!}" alt="{!! $category->name !!}">
    </div>
</div>
@endif
@stop
@section('breadcrumb')
<div class="container">
    <div class="drection">
        <div class="link">
            <span><a href="{!! route('home') !!}">{!! trans('system.home') !!}</a></span>
            @unless (is_null($rootCat))
            <span class="divider"></span>
            <span><a href="{!! route('home.news-category', ['slug' => str_slug($rootCat->name), 'id' => $rootCat->id]) !!}">{!! $rootCat->name !!}</a></span>
            @endunless
            <span class="divider"></span>
            <span class="">{!! $category->name !!}</span>
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
                    <h1 class="title_cate"><img src="{!! asset('assets/frontend/images/icon_news.png') !!}"><span>{!! $category->name !!}</span>
                        </h1>
                </div>
                <div class="excerpt-cate">
                    <h1 class="title_detail"><span>{!! $news->title !!}</span></h1>
                </div>
                <div class="time">
                    <span class="day"><i class="fa fa-clock-o"></i> {!! \App\Helper\HString::timeElapsedString(strtotime($news->updated_at)) !!}</span>
                    <span class="day"><i class="fa fa-commenting-o"></i>{!! $news->count_comment !!}</span>
                </div>
                <div class="module-art">
                    {!! $news->content !!}
                </div>
                <div class="text-right">{!! trans('system.updated_at') !!}: {!! date("d/m/Y H:i", strtotime($news->updated_at)) !!}</div>
                <div class="group-product" id="comment">
                    <div class="group-tab">
                        <ul>
                            <li class="active">Đánh giá</li>
                            <li>Bình luận facebook</li>
                        </ul>
                    </div>
                    <div class="content-tour-tab">
                        <?php $comments = $news->comments()->where('status', 1)->get(); ?>
                        <div class="tour-tab" style="display: block">
                            <div class="box_cm">
                                @foreach ($comments as $comment)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="name_cm"><span class="icon_user"></span><span>{!! $comment->fullname !!}:</span></div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="text_cm">
                                                {!! $comment->content !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="timkiem_ajax">
                                {!! Form::open(['url' => route('comment'), 'class' => 'form-comment']) !!}
                                    {!! Form::hidden('news_id', $news->id, []) !!}
                                    <div class="row">
                                        @if (session('message'))
                                            <div class="col-sm-12">
                                                <p class="text-danger">{!!  session('message') !!}</p>
                                            </div>
                                        @endif
                                        <div class="col-sm-6">
                                            {!! Form::text('fullname', old('fullname'), ["class" => "form-control", 'placeholder' => trans('feedbacks.fullname'), 'maxlength' => 50, 'required']) !!}
                                            {!! Form::text('phone', old('phone'), ["class" => "form-control", 'placeholder' => trans('feedbacks.phone'), 'maxlength' => 11, 'required']) !!}
                                            {!! Form::text('email', old('email'), ["class" => "form-control", 'placeholder' => trans('feedbacks.email'), 'maxlength' => 50, 'required']) !!}
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::textarea('content', old('content'), ["class" => "form-control", 'placeholder' => trans('feedbacks.content'), 'rows' => 5, 'maxlength' => 1024, "style" => "height:126px", 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="submit" class="bt_submit_cm" value="GỬI ĐI">
                                        </div>
                                        <div class="col-sm-6">
                                            {!! app('captcha')->display() !!}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="tour-tab" style="display: none">
                            <div class="fb-comments" data-href="{!! route('home.news-detail', ['slug' => str_slug($news->title), 'id' => $news->id]) !!}" data-width="100%" data-numposts="10"></div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('.group-tab ul li').on('click', function () {
                                $('.group-tab ul li').removeClass('active');
                                $(this).addClass('active');
                                var index = $(this).index();
                                $(".content-tour-tab .tour-tab").hide();
                                $(".content-tour-tab .tour-tab").eq(index).show();
                            });
                        })
                    </script>
                </div>
                {{-- <div class="box_mxh">
                    <div class="fb-comments" data-href="{!! route('home.news-detail', ['slug' => str_slug($news->title), 'id' => $news->id]) !!}" data-width="100%" data-numposts="10"></div>
                </div> --}}
                <div class="baivietlienquan">
                    <div class="title_other">Bài viết khác</div>
                    <ul>
                        @foreach($featuredNews as $item)
                        <li>
                            <a href="{!! route('home.news-detail', ['slug' => str_slug($item->title), 'id' => $item->id]) !!}">
                                <i class="fa fa-long-arrow-right"></i> {!! $item->title !!} <span>- {!! \App\Helper\HString::timeElapsedString(strtotime($item->updated_at)) !!}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
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
        if (window.location.hash == '#comment') {
            $('html, body').animate({
                scrollTop: $("#comment").offset().top
            }, 500);
        }
    </script>
@stop