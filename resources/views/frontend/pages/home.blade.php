@extends('frontend.master')
@section('title'){!! trans('system.home') !!}@stop
@section('head')
<style type="text/css">.videoWrapper{position:relative;padding-bottom:56.25%;height:0}.videoWrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%}.box_comment .row{width:100%}.pro-inner h3 {padding: 10px 0;}</style>
@stop
@section('slider_banner')
	<section class="slide">
        <div class="container">
            <div id="owl-one-slide" class="owl-carousel owl-theme">
				@foreach($sliders as $slider)
                    <div class="item">
                        <a href="{!! $slider['href'] !!}" target="_blank">
                        	<img src="{!! asset($slider['image']) !!}" alt="{!! $slider['name'] !!}"/>
                        </a>
                        <div class="carousel-caption">
                            <a href="{!! $slider['href'] !!}"> {{-- target="_blank" --}}
                            	{{-- {!! $slider['name'] !!} --}}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#owl-one-slide").owlCarousel({
                    autoPlay: true,
                    navigation: true, // Show next and prev buttons
                    pagination: true,
                    slideSpeed: 300,
                    paginationSpeed: 400,
                    singleItem: true,
                    navigationText: ['<', '>']
                });
            });
        </script>
    </section>
@stop
@section('content')
	@if (isset($top4Categories[0]))
		<div class="main-pro">
		    <div class="container">
		        <p class="box-title">
		        	{!! $top4Categories[0]['name'] !!}
		            {{-- <span>{!! $top4Categories[0]['name'] !!}</span>
		            @if (isset($top4Categories[0]['view_all_category']))
			            <a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[0]['view_all_category']['name']), 'id' => $top4Categories[0]['view_all_category']['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[0]['view_all_category']['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @else
		            	<a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[0]['name']), 'id' => $top4Categories[0]['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[0]['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @endif --}}
		        </p>
		        <div class="row row-product">
		        	@for ($i = 0; $i < count($top4Categories[0]['news']) && $i < 6; $i++)
		        		<div class="col-sm-4">
			                <div class="pro-inner">
			                    <h4>
			                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[0]['news'][$i]['title']), 'id' => $top4Categories[0]['news'][$i]['id']]) !!}" title="{!! $top4Categories[0]['news'][$i]['title'] !!}">
			                        	<img src="{!! asset(config('upload.news') . $top4Categories[0]['news'][$i]['image']) !!}" alt="{!! $top4Categories[0]['news'][$i]['title'] !!}">
			                        </a>
			                    </h4>
			                    <div class="pro-info">
			                        <h3>
			                            <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[0]['news'][$i]['title']), 'id' => $top4Categories[0]['news'][$i]['id']]) !!}" title="{!! $top4Categories[0]['news'][$i]['title'] !!}">{!! $top4Categories[0]['news'][$i]['title'] !!}</a>
			                        </h3>
			                        <div class="box_time">
			                        </div>
			                        <div class="description">
			                            {!! $top4Categories[0]['news'][$i]['summary'] !!}
			                        </div>
			                        <div class="more"><a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[0]['news'][$i]['title']), 'id' => $top4Categories[0]['news'][$i]['id']]) !!}" title="{!! $top4Categories[0]['news'][$i]['title'] !!}">&nbsp;</a></div>
			                    </div>
			                </div>
			            </div>
		        	@endfor
		        </div>
		    </div>
		</div>
	@endif
	@if (isset($top4Categories[1]))
		<div class="box_news_top">
		    <div class="container">
		        <div class="box-title">
		            <span>{!! $top4Categories[1]['name'] !!}</span>
		            @if (isset($top4Categories[1]['view_all_category']))
			            <a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[1]['view_all_category']['name']), 'id' => $top4Categories[1]['view_all_category']['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[1]['view_all_category']['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @else
		            	<a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[1]['name']), 'id' => $top4Categories[1]['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[1]['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @endif
		        </div>
		        <div class="row r_widget">
		            <div class="col-sm-6">
		            	@if (isset($top4Categories[1]['news'][0]))
		                <div class="content_item">
		                    <figure class="thumbnail">
		                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[1]['news'][0]['title']), 'id' => $top4Categories[1]['news'][0]['id']]) !!}" title="{!! $top4Categories[1]['news'][0]['title'] !!}">
		                        	<img src="{!! asset(config('upload.news') . $top4Categories[1]['news'][0]['image']) !!}" alt="{!! $top4Categories[1]['news'][0]['title'] !!}">
		                        </a>
		                    </figure>
		                    <div class="post_title_excerpt">
		                        <div class="box_time">
		                        </div>
		                        <div class="title">
		                            <a class="post-title"
		                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[1]['news'][0]['title']), 'id' => $top4Categories[1]['news'][0]['id']]) !!}" title="{!! $top4Categories[1]['news'][0]['title'] !!}">{!! $top4Categories[1]['news'][0]['title'] !!}</a>
		                        </div>
		                        <div class="description">
		                            {!! $top4Categories[1]['news'][0]['summary'] !!}
		                        </div>
		                    </div>
		                </div>
		                @endif
		            </div>
		            <div class="col-sm-6">
		            	@if (count($top4Categories[1]['news']) > 1)
		            		@for ($i = 1; $i < count($top4Categories[1]['news']) && $i < 4; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[1]['news'][$i]['title']), 'id' => $top4Categories[1]['news'][$i]['id']]) !!}" title="{!! $top4Categories[1]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[1]['news'][$i]['image']) !!}" alt="{!! $top4Categories[1]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[1]['news'][$i]['title']), 'id' => $top4Categories[1]['news'][$i]['id']]) !!}" title="{!! $top4Categories[1]['news'][$i]['title'] !!}">{!! $top4Categories[1]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[1]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		        </div>
		    </div>
		</div>
	@endif
	@if (isset($top4Categories[2]))
		<div class="box_news_top">
		    <div class="container">
		        <div class="box-title">
		            <span>{!! $top4Categories[2]['name'] !!}</span>
		            @if (isset($top4Categories[2]['view_all_category']))
			            <a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[2]['view_all_category']['name']), 'id' => $top4Categories[2]['view_all_category']['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[2]['view_all_category']['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @else
		            	<a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[2]['name']), 'id' => $top4Categories[2]['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[2]['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @endif
		        </div>
		        <div class="row r_widget">
		            <div class="col-sm-6">
		            	@if (count($top4Categories[2]['news']))
		            		@for ($i = 0; $i < count($top4Categories[2]['news']) && $i < 2; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[2]['news'][$i]['image']) !!}" alt="{!! $top4Categories[2]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}">{!! $top4Categories[2]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[2]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		            <div class="col-sm-6">
		            	@if (count($top4Categories[2]['news']) > 2)
		            		@for ($i = 2; $i < count($top4Categories[2]['news']) && $i < 4; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[2]['news'][$i]['image']) !!}" alt="{!! $top4Categories[2]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}">{!! $top4Categories[2]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[2]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		            <div class="col-sm-6">
		            	@if (count($top4Categories[2]['news']) > 4)
		            		@for ($i = 4; $i < count($top4Categories[2]['news']) && $i < 6; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[2]['news'][$i]['image']) !!}" alt="{!! $top4Categories[2]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}">{!! $top4Categories[2]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[2]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		            <div class="col-sm-6">
		            	@if (count($top4Categories[2]['news']) > 6)
		            		@for ($i = 6; $i < count($top4Categories[2]['news']) && $i < 8; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[2]['news'][$i]['image']) !!}" alt="{!! $top4Categories[2]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[2]['news'][$i]['title']), 'id' => $top4Categories[2]['news'][$i]['id']]) !!}" title="{!! $top4Categories[2]['news'][$i]['title'] !!}">{!! $top4Categories[2]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[2]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		        </div>
		    </div>
		</div>
	@endif
	<div class="box_cus">
	    <div class="container">
	        <div class="row">
	            <div class="col-sm-6">
	                <div class="title_widget"><span>Video giới thiệu</span></div>
	                <div class="box_comment scrollbar-light">
	                    <div class="row">
	                        <div class="col-sm-12 text-center videoWrapper">
	                        	<iframe width="100%" height="100%" src="{!! isset($staticPages['youtube-video']['description']) ? $staticPages['youtube-video']['description'] : '' !!}?autoplay=1&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-sm-6">
	                <div class="title_widget"><span>Đăng ký & tư vấn</span></div>
	                <div class="timkiem_ajax">
	                    <div name="searh_project" class="form-register-home">
	                        <div class="row">
	                            <div class="col-sm-12">
	                            	{!! Form::text('home_fullname', '', ["class" => "form-control", 'placeholder' => trans('feedbacks.fullname'), 'maxlength' => 50]) !!}
	                            </div>
	                        </div>
	                        <div class="row">
	                        	<div class="col-sm-12">
	                                {!! Form::text('home_phone', '', ["class" => "form-control", 'placeholder' => trans('feedbacks.phone'), 'maxlength' => 11]) !!}
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-12">
	                                {!! Form::text('home_email', '', ["class" => "form-control", 'placeholder' => trans('feedbacks.email'), 'maxlength' => 50]) !!}
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-12">
	                                {!! Form::textarea('home_content', '', ["class" => "form-control", 'placeholder' => trans('feedbacks.content'), 'rows' => 3, 'maxlength' => 1024]) !!}
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="col-sm-12">
	                            	<input type="submit" value="Gửi đi" id="home_consultant" class="bt_submit_home">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="box_cus">
	    <div class="container">
	        <div class="row">
	            <div class="col-sm-12">
	                <div class="title_widget"><span>{!! trans('experiences.label') !!}</span></div>
	                <div class="box_comment scrollbar-light" style="overflow-y: auto;">
	                	@foreach ($experiences as $experience)
		                    <div class="row">
		                        <div class="col-sm-2 text-center">
		                        	@if ($experience['image'])
		                        	<img src="{!! asset($experience['image']) !!}">
		                        	@else
		                            	<img src="{!! asset('assets/frontend/images/no-pro-img.jpg') !!}">
		                            @endif
		                        </div>
		                        <div class="col-sm-10">
		                            <div class="name_cm">
		                                <span class="icon_user"></span>
		                                <span>{!! $experience['fullname'] !!}</span>
		                            </div>
		                            <div class="text_cm">
		                                <p>{!! $experience['content'] !!}</p>
		                            </div>
		                            <div class="email_cm">
		                                {!! trans('experiences.email') !!}: {!! $experience['email'] !!} - {!! trans('experiences.phone') !!}: {!! substr($experience['phone'], 0, -3) . '***' !!}
		                            </div>
		                        </div>
		                    </div>
	                    @endforeach
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	@if (isset($top4Categories[3]))
		<div class="box_news_top">
		    <div class="container">
		        <div class="box-title">
		            <span>{!! $top4Categories[3]['name'] !!}</span>
		            @if (isset($top4Categories[3]['view_all_category']))
			            <a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[3]['view_all_category']['name']), 'id' => $top4Categories[3]['view_all_category']['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[3]['view_all_category']['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @else
		            	<a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[3]['name']), 'id' => $top4Categories[3]['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[3]['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @endif
		        </div>
		        <div class="row r_widget">
		            <div class="col-sm-6">
		            	@if (count($top4Categories[3]['news']))
		            		@for ($i = 0; $i < count($top4Categories[3]['news']) && $i < 4; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[3]['news'][$i]['title']), 'id' => $top4Categories[3]['news'][$i]['id']]) !!}" title="{!! $top4Categories[3]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[3]['news'][$i]['image']) !!}" alt="{!! $top4Categories[3]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[3]['news'][$i]['title']), 'id' => $top4Categories[3]['news'][$i]['id']]) !!}" title="{!! $top4Categories[3]['news'][$i]['title'] !!}">{!! $top4Categories[3]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[3]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		            <div class="col-sm-6">
		            	@if (count($top4Categories[3]['news']) > 4)
		            		@for ($i = 4; $i < count($top4Categories[3]['news']); $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[3]['news'][$i]['title']), 'id' => $top4Categories[3]['news'][$i]['id']]) !!}" title="{!! $top4Categories[3]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[3]['news'][$i]['image']) !!}" alt="{!! $top4Categories[3]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[3]['news'][$i]['title']), 'id' => $top4Categories[3]['news'][$i]['id']]) !!}" title="{!! $top4Categories[3]['news'][$i]['title'] !!}">{!! $top4Categories[3]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[3]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		        </div>
		    </div>
		</div>
	@endif
	@if (isset($top4Categories[4]))
		<div class="box_news_top">
		    <div class="container">
		        <div class="box-title">
		            <span>{!! $top4Categories[4]['name'] !!}</span>
		            @if (isset($top4Categories[4]['view_all_category']))
			            <a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[4]['view_all_category']['name']), 'id' => $top4Categories[4]['view_all_category']['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[4]['view_all_category']['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @else
		            	<a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[4]['name']), 'id' => $top4Categories[4]['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[4]['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @endif
		        </div>
		        <div class="row">
		        	@for ($i = 0; $i < count($top4Categories[4]['news']) && $i < 8; $i++)
			            <div class="col-sm-3">
			                <div class="ser_item">
			                    <figure class="thumbnail text-center">
			                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[4]['news'][$i]['title']), 'id' => $top4Categories[4]['news'][$i]['id']]) !!}" title="{!! $top4Categories[4]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[4]['news'][$i]['image']) !!}" alt="{!! $top4Categories[4]['news'][$i]['title'] !!}"></a>
			                    </figure>
			                    <div class="post_title_excerpt">
			                        <div class="title">
			                            <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[4]['news'][$i]['title']), 'id' => $top4Categories[4]['news'][$i]['id']]) !!}" title="{!! $top4Categories[4]['news'][$i]['title'] !!}">{!! $top4Categories[4]['news'][$i]['title'] !!}</a>
			                        </div>
			                        <div class="description">
			                        	{!! $top4Categories[4]['news'][$i]['summary'] !!}
			                        </div>
			                        <div class="more text-center">
			                            <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[4]['news'][$i]['title']), 'id' => $top4Categories[4]['news'][$i]['id']]) !!}" title="{!! $top4Categories[4]['news'][$i]['title'] !!}">{!! trans('system.view_more') !!} <i
			                                class="fa fa-caret-right"></i></a>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        @endfor
		        </div>
		    </div>
		</div>
	@endif
	@if (isset($top4Categories[5]))
		<div class="box_news_top">
		    <div class="container">
		        <div class="box-title">
		            <span>{!! $top4Categories[5]['name'] !!}</span>
		            @if (isset($top4Categories[5]['view_all_category']))
			            <a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[5]['view_all_category']['name']), 'id' => $top4Categories[5]['view_all_category']['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[5]['view_all_category']['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @else
		            	<a href="{!! route('home.news-category', ['slug' => str_slug($top4Categories[5]['name']), 'id' => $top4Categories[5]['id']]) !!}" title="{!! trans('system.view_all') !!}" title="{!! $top4Categories[5]['name'] !!}">
			            	<i class="fa fa-hand-o-right"> {!! trans('system.view_all') !!}</i>
			            </a>
		            @endif
		        </div>
		        <div class="row r_widget">
		            <div class="col-sm-6">
		            	@if (count($top4Categories[5]['news']))
		            		@for ($i = 0; $i < count($top4Categories[5]['news']) && $i < 4; $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[5]['news'][$i]['title']), 'id' => $top4Categories[5]['news'][$i]['id']]) !!}" title="{!! $top4Categories[5]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[5]['news'][$i]['image']) !!}" alt="{!! $top4Categories[5]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[5]['news'][$i]['title']), 'id' => $top4Categories[5]['news'][$i]['id']]) !!}" title="{!! $top4Categories[5]['news'][$i]['title'] !!}">{!! $top4Categories[5]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[5]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		            <div class="col-sm-6">
		            	@if (count($top4Categories[5]['news']) > 4)
		            		@for ($i = 4; $i < count($top4Categories[5]['news']); $i++)
				                <div class="content_item addstyle">
				                    <figure class="thumbnail">
				                        <a href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[5]['news'][$i]['title']), 'id' => $top4Categories[5]['news'][$i]['id']]) !!}" title="{!! $top4Categories[5]['news'][$i]['title'] !!}"><img src="{!! asset(config('upload.news') . $top4Categories[5]['news'][$i]['image']) !!}" alt="{!! $top4Categories[5]['news'][$i]['title'] !!}"></a>
				                    </figure>
				                    <div class="post_title_excerpt">
				                        <div class="title">
				                            <a class="post-title"
				                                href="{!! route('home.news-detail', ['slug' => str_slug($top4Categories[5]['news'][$i]['title']), 'id' => $top4Categories[5]['news'][$i]['id']]) !!}" title="{!! $top4Categories[5]['news'][$i]['title'] !!}">{!! $top4Categories[5]['news'][$i]['title'] !!}</a>
				                        </div>
				                        <div class="description">
				                            {!! $top4Categories[5]['news'][$i]['summary'] !!}
				                        </div>
				                    </div>
				                </div>
				            @endfor
		                @endif
		            </div>
		        </div>
		    </div>
		</div>
	@endif
@stop
@section('footer')
	<script>
	    $(document).ready(function(o){$("#home_consultant").click(function(event){var fullname=$.trim($("input[name='home_fullname']").val()),phone=$.trim($("input[name='home_phone']").val()),email=$.trim($("input[name='home_email']").val()),content=$.trim($("textarea[name='home_content']").val());if(''==fullname){alert("{!! trans('feedbacks.fullname') !!} là yêu cầu");return!1} if(''==phone){alert("{!! trans('feedbacks.phone') !!} là yêu cầu");return!1} if(''==email){alert("{!! trans('feedbacks.email') !!} là yêu cầu");return!1} if(''==content){alert("{!! trans('feedbacks.content') !!} là yêu cầu");return!1} $(".element").show();$.ajax({url:"{!! route('consultant') !!}",data:{fullname:fullname,phone:phone,email:email,content:content},type:'POST',datatype:'json',headers:{'X-CSRF-Token':"{!! csrf_token() !!}"},success:function(res){window.location='{!! route('notify') !!}'},error:function(obj,status,err){var error=$.parseJSON(obj.responseText);alert(error.message)}}).always(function(){$(".element").hide()})})})
	</script>
@stop