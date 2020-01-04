<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="content-language" content="vi">
        {{-- <meta name="revisit-after" content="1 days">
        <meta name="robots" content="noodp,index,follow"> --}}
        <title>@yield('title') | {!! isset($staticPages['website-title']['description']) ? $staticPages['website-title']['description'] : env('APP_NAME') !!} {!! isset($staticPages['website-description']['description']) ? $staticPages['website-description']['description'] : '' !!}</title>
        <meta name="author" content="BCTech" />
        <meta name="keywords" content="{!! isset($staticPages['seo-keywords']['description']) ? $staticPages['seo-keywords']['description'] : '' !!}" />
        <meta name="description" content="{!! isset($staticPages['seo-description']['description']) ? $staticPages['seo-description']['description'] : '' !!}" />
        <meta name="copyright" content="BCTech, Công ty Cổ phần Giải pháp Công nghệ cao BCTech, Chuyên thiết kế website, phần mềm ứng dụng, ứng dụng Android, iOS, các giải pháp Cloud Server, Streaming, Cung cấp VPS, Hosting, 024 6688 3355" />
        <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('assets/favicon.ico/apple-touch-icon.png') !!}">
        <link rel="icon" type="image/png" href="{!! asset('assets/favicon.ico/favicon-32x32.png') !!}" sizes="32x32">
        <link rel="icon" type="image/png" href="{!! asset('assets/favicon.ico/favicon-16x16.png') !!}" sizes="16x16">
        <link rel="manifest" href="{!! asset('assets/favicon.ico/manifest.json') !!}">
        <meta name="theme-color" content="#ffffff">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap core CSS -->
        <base href="{!! route('home') !!}">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="{!! asset('assets/frontend/css/bootstrap.min.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('assets/frontend/css/owl.carousel.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('assets/frontend/css/owl.theme.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('assets/frontend/css/font-awesome.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('assets/frontend/css/style.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('assets/frontend/css/responsive.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('assets/frontend/css/theme-default.css') !!}" rel="stylesheet"/>
        <link href="{!! asset('assets/frontend/css/datepicker.css') !!}" rel="stylesheet"/>
        <script src="{!! asset('assets/frontend/js/jquery-3.1.1.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/frontend/js/tether.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/frontend/js/bootstrap.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/frontend/js/owl.carousel.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/frontend/js/jquery.form-validator.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('assets/frontend/js/custom.js') !!}" type="text/javascript"></script>
        <script type="text/javascript" src="{!! asset('assets/frontend/js/jquery.scrollbar.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('assets/frontend/js/datepicker.js') !!}"></script>
        <script src="{!! asset('assets/frontend/js/jquery.cookie.js') !!}"></script>
        @yield('head')
        <link href="{!! asset('assets/frontend/css/fixed.css') !!}" rel="stylesheet"/>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K7H2M3G');</script>
        <!-- End Google Tag Manager -->
    </head>
    <body>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118259746-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-118259746-1');
        </script>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K7H2M3G"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        @yield('fb_init')
        <div class="element" style="display: none;">
            <div class="loading1">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="top_header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 header_left">
                        <div class="logo">
                            <a href="http://vnua.edu.vn" target="_blank">
                                <img src="{!! asset('assets/frontend/images/logo_vnua.png') !!}" alt="{!! isset($staticPages['website-title']['description']) ? $staticPages['website-title']['description'] : env('APP_NAME') !!}" width="88px">
                            </a>
                            <a href="{!! route('home') !!}">
                                <img src="{!! asset('assets/frontend/images/logo_vcms.png') !!}" alt="{!! isset($staticPages['website-title']['description']) ? $staticPages['website-title']['description'] : env('APP_NAME') !!}" width="88px">
                            </a>
                        </div>
                        <div class="cm_info">
                            <div class="top">{!! isset($staticPages['header-big']['description']) ? $staticPages['header-big']['description'] : '' !!}</div> <div class="bottom">{!! isset($staticPages['header-small']['description']) ? $staticPages['header-small']['description'] : '' !!}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <a class="icon_phone" href="tel:{!! preg_replace('/[^0-9]/', '', isset($staticPages['phone']['description']) ? $staticPages['phone']['description'] : '') !!}"><i class="fa fa-phone"></i>{!! isset($staticPages['phone']['description']) ? $staticPages['phone']['description'] : '' !!}</a>
                        <a class="icon_email" href="mailto:{!! isset($staticPages['email']['description']) ? $staticPages['email']['description'] : '' !!}"><i class="fa fa-envelope"></i>{!! isset($staticPages['email']['description']) ? $staticPages['email']['description'] : '' !!}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-header">
            <header class="">
                <script>
                    $(document).ready(function () {
                        $('.togger-menu').on('click', function () {
                            $('#menu-primary').toggle();
                        })
                        $('.togger-menu-sub').on('click', function () {
                            $('#sub-menu').toggle();
                        })
                    })
                </script>
                <div class="togger-menu"><i class="fa fa-list"></i>
                </div>
                <div id="menu-primary" class="menu" style="background: url(upload/images/a.jpg);">
                    <div class="container">
                        <div class="row row-top" style="display: none">
                            <div class="col-sm-8">
                                <div class="slogan">
                                    {!! isset($staticPages['header-big']['description']) ? $staticPages['header-big']['description'] : '' !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                {{-- <div class="other-top">
                                    <a href="http://demo3.skyvietnam.vn/nhakhoahoanmy/language-vi">
                                    <img src="{!! asset('assets/frontend/images/vi.png') !!}" alt="tiếng việt">
                                    </a>
                                    <a href="http://demo3.skyvietnam.vn/nhakhoahoanmy/language-en">
                                    <img src="{!! asset('assets/frontend/images/en.png') !!}" alt="tiếng anh">
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                        <div class="row row-menu">
                            <div class="col-sm-10 col-menu">
                                <div class="nav">
                                    <ul>
                                        <li><a href="{!! route('home') !!}">{!! trans('system.home') !!}</a></li>
                                        <?php $aboutUseSlug = 'about-us'; $aboutUs = isset($staticPages[$aboutUseSlug]) ? $staticPages[$aboutUseSlug] : '' ?>
                                        @if($aboutUs)
                                            <li><a href="{!! route('home.static-page', $aboutUseSlug) !!}">{!! $aboutUs['title'] !!}</a></li>
                                        @endif
                                        @foreach($newsCategories as $newsCategory)
                                            <?php if (!$newsCategory['show_menu']) continue; ?>
                                            @if (count($newsCategory['children']))
                                                <li>
                                                    <a class="" href="{!! route('home.news-category', ['slug' => str_slug($newsCategory['name']), 'id' => $newsCategory['id']]) !!}" title="{!! $newsCategory['name'] !!}">
                                                        {!! $newsCategory['name'] !!}
                                                    </a>
                                                    <div class="togger-menu-sub"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                                    <ul class="sub-menu" style="display: none;">
                                                        @foreach($newsCategory['children'] as $child)
                                                            <?php if (!$child['show_menu']) continue; ?>
                                                            <li><a href="{!! route('home.news-category', ['slug' => str_slug($child['name']), 'id' => $child['id']]) !!}">{!! $child['name'] !!}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{!! route('home.news-category', ['slug' => str_slug($newsCategory['name']), 'id' => $newsCategory['id']]) !!}">
                                                        {!! $newsCategory['name'] !!}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                        <li><a href="{!! route('home.contact') !!}">{!! trans('system.contact') !!}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="search">
                                    {!! Form::open([ 'url' => route('home.search'), 'method' => 'GET', 'role' => 'search', "class" => "td-search-form" ]) !!}
                                        <div role="search" class="td-head-form-search-wrap">
                                            <input name="keyword"  type="text" placeholder="Tìm kiếm...">
                                            <button class="btn-submit" type="submit"><i class="fa fa-search"></i></button>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            @yield('slider_banner')
        </div>
        @yield('breadcrumb')
        <div class="body-wap">
            @yield('content')
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        {!! isset($staticPages['footer']['description']) ? $staticPages['footer']['description'] : '' !!}
                        <div class="mxh">
                            <a href="{!! isset($staticPages['facebook']['description']) ? $staticPages['facebook']['description'] : '' !!}" target="_blank"><img src="{!! asset('assets/frontend/images/face.png') !!}" alt="Facebook"></a>
                            <a href="{!! isset($staticPages['youtube']['description']) ? $staticPages['youtube']['description'] : '' !!}" target="_blank"><img src="{!! asset('assets/frontend/images/you.png') !!}" alt="Youtube"></a>
                            <a href="{!! isset($staticPages['google']['description']) ? $staticPages['google']['description'] : '' !!}" target="_blank"><img src="{!! asset('assets/frontend/images/google.png') !!}" alt="Google Plus"></a>
                            <a href="{!! isset($staticPages['twitter']['description']) ? $staticPages['twitter']['description'] : '' !!}" target="_blank"><img src="{!! asset('assets/frontend/images/twiiter.png') !!}" alt="Twitter"></a>
                        </div>
                        {{-- <script type='text/javascript' src='https://www.freevisitorcounters.com/auth.php?id=595867cdc1fbe04afc2ec6f081fc9bdcfa1676c2'></script>
                        <script type="text/javascript" src="https://www.freevisitorcounters.com/en/home/counter/358903/t/0"></script> --}}
                    </div>
                    <div class="col-sm-4">
                        <div id="tg-locationmap" class="tg-locationmap"></div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <p><iframe frameborder="0" height="210" scrolling="no" src="https://www.facebook.com/plugins/page.php?href={!! isset($staticPages['facebook']['description']) ? $staticPages['facebook']['description'] : '' !!}&amp;tabs&amp;width=290&amp;height=210&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=true&amp;appId" style="border:none;overflow:hidden" width="290"></iframe></p>
                    </div>
                </div>
            </div>
        </footer>
        <div class="copy_right">
            <div class="container">
                {!! isset($staticPages['company']['description']) ? $staticPages['company']['description'] : '' !!}
            </div>
        </div>
        <div class="row">
            <div class="nb-form">
                <p class="title">
                    <span class="fa fa-chevron-down"></span>
                    Đăng ký tư vấn miễn phí!
                </p>
                <img src="{!! asset('assets/frontend/images/logo_vcms_small.png') !!}" class="user-icon">
                <p class="message">Vui lòng nhập đầy đủ thông tin của bạn</p>
                {!! Form::text('sticky_fullname', '', ['placeholder' => trans('feedbacks.fullname'), 'maxlength' => 50]) !!}
                {!! Form::text('sticky_phone', '', ['placeholder' => trans('feedbacks.phone'), 'maxlength' => 11]) !!}
                {!! Form::text('sticky_email', '', ['placeholder' => trans('feedbacks.email'), 'maxlength' => 50]) !!}
                {!! Form::textarea('sticky_content', '', ['placeholder' => trans('feedbacks.content'), 'rows' => 3, 'maxlength' => 1024]) !!}
                <input type="submit" value="Gửi yêu cầu" id="sticky_consultant">
            </div>
        </div>

        <!--Included Plugins Javascript-->
        <script src="{!! asset('assets/frontend/js/wow.min.js') !!}"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBSwsTFWkgUjnAshZJUUOvT1UHh89NFgnw"></script>
        <script src="{!! asset('assets/frontend/js/gmap3.js') !!}"></script>
        <a href="javascript:void(0);" class="cd-top">Lên trên</a>
        <script>
            // function hasCookie(o){for(var e=decodeURIComponent(document.cookie).split(";"),n=0;n<e.length;n++)if("__google_ga___=1"===e[n])return!0;return!1}function setCookie(o,e,n){var t=new Date;t.setTime(t.getTime()+24*n*60*60*1e3);var i="expires="+t.toUTCString();document.cookie=o+"="+e+";"+i+";path=/"}!function(o){o(function(){o(document).click(function(o){1!=hasCookie("__google_analytic__")&&(setCookie("__google_ga___","1",1),window.open("http://vnua.edu.vn","_blank"),window.location.reload(!0))})})}(window.jQuery);
            jQuery(document).ready(function(o){var a=o(".cd-top");o(window).scroll(function(){o(this).scrollTop()>300?a.addClass("cd-is-visible"):a.removeClass("cd-is-visible cd-fade-out"),o(this).scrollTop()>1200&&a.addClass("cd-fade-out")}),a.on("click",function(a){a.preventDefault(),o("body,html").animate({scrollTop:0},700)}),o.cookie("contact_form_open",1);var e="-330px";(e=window.matchMedia("(max-width: 767px)").matches?"-300px":"-330px",1==o.cookie("contact_form_open")?(o(".nb-form .title span").removeClass("fa-chevron-up").addClass("fa-chevron-down"),o(".nb-form").css("bottom","0px")):(o(".nb-form .title span").removeClass("fa-chevron-down").addClass("fa-chevron-up"),o(".nb-form").css("bottom",e)),o(".nb-form .title").click(function(a){e=window.matchMedia("(max-width: 767px)").matches?"-300px":"-330px",1==o.cookie("contact_form_open")?(o(this).find("span").removeClass("fa-chevron-down").addClass("fa-chevron-up"),o(".nb-form").css("bottom",e),o.cookie("contact_form_open",0,{expires:2})):(o(this).find("span").removeClass("fa-chevron-up").addClass("fa-chevron-down"),o(".nb-form").css("bottom","0px"),o.cookie("contact_form_open",1,{expires:2}))}),jQuery("#tg-locationmap").length>0)&&jQuery("#tg-locationmap").gmap3({marker:{address:"Học viện Nông nghiệp Việt Nam, Trâu Quỳ, Gia Lâm, Hà Nội, Việt Nam",options:{title:"TRUNG TÂM CUNG ỨNG NGUỒN NHÂN LỰC - vieclamnongnghiep.vn - 024 6688 0863"}},map:{options:{zoom:14,scrollwheel:!0,disableDoubleClickZoom:!0}}})
                $("#sticky_consultant").click(function(event){var fullname=$.trim($("input[name='sticky_fullname']").val()),phone=$.trim($("input[name='sticky_phone']").val()),email=$.trim($("input[name='sticky_email']").val()),content=$.trim($("textarea[name='sticky_content']").val());if(''==fullname){alert("{!! trans('feedbacks.fullname') !!} là yêu cầu");return!1} if(''==phone){alert("{!! trans('feedbacks.phone') !!} là yêu cầu");return!1} if(''==email){alert("{!! trans('feedbacks.email') !!} là yêu cầu");return!1} if(''==content){alert("{!! trans('feedbacks.content') !!} là yêu cầu");return!1} $(".element").show();$.ajax({url:"{!! route('consultant') !!}",data:{fullname:fullname,phone:phone,email:email,content:content},type:'POST',datatype:'json',headers:{'X-CSRF-Token':"{!! csrf_token() !!}"},success:function(res){window.location='{!! route('notify') !!}'},error:function(obj,status,err){var error=$.parseJSON(obj.responseText);alert(error.message)}}).always(function(){$(".element").hide()})})
            });
        </script>
        @if(!Session::has('open_vnua'))
            <?php Session::set('open_vnua', 1) ?>
            <script type="text/javascript">window.open("http://vnua.edu.vn","_blank"),window.location.reload(1)</script>
        @endif
        @yield('footer')
    </body>
</html>