<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('assets/favicon.ico/apple-touch-icon.png') !!}">
        <link rel="icon" type="image/png" href="{!! asset('assets/favicon.ico/favicon-32x32.png') !!}" sizes="32x32">
        <link rel="icon" type="image/png" href="{!! asset('assets/favicon.ico/favicon-16x16.png') !!}" sizes="16x16">
        <link rel="manifest" href="{!! asset('assets/favicon.ico/manifest.json') !!}">
        <meta name="theme-color" content="#ffffff">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            @yield('title') | Quản trị | {!! env('APP_NAME') !!}
        </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/bootstrap.min.css') !!}" />
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/fonts/font-awesome.min.css') !!}" />
        <!-- Ionicons -->
        <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/ionicons.2.0.1.min.css') !!}" />
        @yield('head')

        <!-- Theme style -->
        <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/AdminLTE.min.css') !!}" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/skins/_all-skins.min.css') !!}" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/fixed.css') !!}" />
    </head>
    <?php $user = \Auth::guard('admin')->getUser(); ?>
    <body class="hold-transition skin-blue sidebar-mini @if($user->menu_is_collapse)sidebar-collapse @endif">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="{!! route('home') !!}" class="logo" target="_blank">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                        <img src="{!! asset('assets/backend/img/favicon.png') !!}" class="img-circle" alt="{!! env('APP_NAME') !!}">
                        <b>{!! env('APP_NAME') !!}</b>
                    </span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Trang chủ</b> {!! env('APP_NAME') !!}</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            {{-- <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                    page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li> --}}
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{!! asset('assets/backend/img/user.png') !!}" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{!! $user->fullname !!}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{!! asset('assets/backend/img/user.png') !!}" class="img-circle" alt="User Image">
                                        <p>
                                            {!! $user->fullname !!}
                                            <small>Lần cuối đăng nhập {!! date('d/m/Y H:i', strtotime($user->last_login)) !!}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-12 text-center">
                                            <a href="{!! route('admin.change-password') !!}"class="btn btn-warning" style="color: white !important;"><span class="fa fa-gear"></span> Đổi mật khẩu</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{!! route('admin.account') !!}" class="btn btn-default btn-flat">Tài khoản</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{!! route('admin.logout') !!}" class="btn btn-default btn-flat">Thoát</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        @foreach(\Config::get('menu') as $menu)
                            @if(isset($menu['child']) && count($menu['child']) > 0)
                                @if (isset($menu['role']) && $menu['role'])
                                    @role($menu['role'])
                                        <li class="treeview">
                                            <a href="">
                                                <i class="{!!$menu['glyphicon']!!}"></i> <span>{!! trans('menus.'.$menu['name']) !!}</span> <i class="fa fa-angle-left pull-right"></i>
                                            </a>
                                            <ul class="treeview-menu">
                                                @foreach($menu['child'] as $child)
                                                    @if (isset($child['role']) && $child['role'])
                                                        @role($child['role'])
                                                            <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                <a href="{!! route( $child['route'] ) !!}">
                                                                    @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                </a>
                                                            </li>
                                                        @endrole
                                                    @else
                                                        @if (isset($child['permissions']) && is_array($child['permissions']) && !empty($child['permissions']))
                                                            @ability('', implode(',', $child['permissions']))
                                                                <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                    <a href="{!! route( $child['route'] ) !!}">
                                                                        @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                    </a>
                                                                </li>
                                                            @endability
                                                        @else
                                                            <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                <a href="{!! route( $child['route'] ) !!}">
                                                                    @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endrole
                                @else
                                    @if (isset($menu['permissions']) && is_array($menu['permissions']) && !empty($menu['permissions']))
                                        @ability('', implode(',', $menu['permissions']))
                                            <li class="treeview">
                                                <a href="">
                                                    <i class="{!!$menu['glyphicon']!!}"></i> <span>{!! trans('menus.'.$menu['name']) !!}</span> <i class="fa fa-angle-left pull-right"></i>
                                                </a>
                                                <ul class="treeview-menu">
                                                    @foreach($menu['child'] as $child)
                                                        @if (isset($child['role']) && $child['role'])
                                                            @role($child['role'])
                                                                <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                    <a href="{!! route( $child['route'] ) !!}">
                                                                        @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                    </a>
                                                                </li>
                                                            @endrole
                                                        @else
                                                            @if (isset($child['permissions']) && is_array($child['permissions']) && !empty($child['permissions']))
                                                                @ability('', implode(',', $child['permissions']))
                                                                    <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                        <a href="{!! route( $child['route'] ) !!}">
                                                                            @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                        </a>
                                                                    </li>
                                                                @endability
                                                            @else
                                                                <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                    <a href="{!! route( $child['route'] ) !!}">
                                                                        @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endability
                                    @else
                                        <li class="treeview">
                                            <a href="">
                                                <i class="{!!$menu['glyphicon']!!}"></i> <span>{!! trans('menus.'.$menu['name']) !!}</span> <i class="fa fa-angle-left pull-right"></i>
                                            </a>
                                            <ul class="treeview-menu">
                                                @foreach($menu['child'] as $child)
                                                    @if (isset($child['role']) && $child['role'])
                                                        @role($child['role'])
                                                            <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                <a href="{!! route( $child['route'] ) !!}">
                                                                    @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                </a>
                                                            </li>
                                                        @endrole
                                                    @else
                                                        @if (isset($child['permissions']) && is_array($child['permissions']) && !empty($child['permissions']))
                                                            @ability('', implode(',', $child['permissions']))
                                                                <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                    <a href="{!! route( $child['route'] ) !!}">
                                                                        @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                    </a>
                                                                </li>
                                                            @endability
                                                        @else
                                                            <li class="{!! (explode('.', $child['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                                <a href="{!! route( $child['route'] ) !!}">
                                                                    @if( isset($child['glyphicon']) )<i class="{!!$child['glyphicon']!!}"></i>@else <i class="fa fa-circle-o"></i>@endif {!! trans('menus.' . $child['name']) !!}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endif
                            @else
                                @if (isset($menu['role']) && $menu['role'])
                                    @role($menu['role'])
                                        <li class="{!! (explode('.', $menu['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                            <a href="{!! route( $menu['route'] ) !!}">
                                                <i class="{!!$menu['glyphicon']!!}"></i> <span>{!! trans('menus.'.$menu['name']) !!}</span>
                                            </a>
                                        </li>
                                    @endrole
                                @else
                                    @if (isset($menu['permissions']) && is_array($menu['permissions']) && !empty($menu['permissions']))
                                        @ability('', implode(',', $menu['permissions']))
                                            <li class="{!! (explode('.', $menu['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                                <a href="{!! route( $menu['route'] ) !!}">
                                                    <i class="{!!$menu['glyphicon']!!}"></i> <span>{!! trans('menus.'.$menu['name']) !!}</span>
                                                </a>
                                            </li>
                                        @endability
                                    @else
                                        <li class="{!! (explode('.', $menu['route'] )[1] == explode('.', Route::getCurrentRoute()->getName() )[1]) ? 'active' : '' !!}">
                                            <a href="{!! route( $menu['route'] ) !!}">
                                                <i class="{!!$menu['glyphicon']!!}"></i> <span>{!! trans('menus.'.$menu['name']) !!}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </section>
            <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if(Session::has('message'))
                    <div class="box box-default notify">
                        <div class="box-body">
                            <div class="alert alert-{!! Session::get('alert-class', 'default') !!} alert-dismissable" style="text-align: center;">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <span style="font-size: 18px;">{!! Session::get('message') !!}</span>

                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        window.setTimeout(function() { $(".notify").fadeTo(1500, 0).slideUp(500, function(){
                            $(this).remove();
                        }); }, 5000);
                    </script>
                @endif
                @yield('content')
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; 2016 <a href="http://bctech.vn" target="_blank">BCTech .,JSC</a>.</strong> All rights reserved.
            </footer>
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->
        <div id="confirm-modal-del" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"> Xác nhận </h4>
                    </div>
                    <div class="modal-body">
                        <p> {!! trans('system.confirm_msg') !!} </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;"> {!! trans('system.confirm_no') !!} </button>
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" id="confirm-delete-del"> {!! trans('system.confirm_yes') !!} </button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="confirm-modal-cfm" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"> Xác nhận </h4>
                    </div>
                    <div class="modal-body">
                        <p> Bạn muốn thực hiện thao tác này? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;"> {!! trans('system.confirm_no') !!} </button>
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-danger" id="confirm-delete-cfm"> {!! trans('system.action.ok') !!} </button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- jQuery 2.1.4 -->
        <script src="{!! asset('assets/backend/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{!! asset('assets/backend/js/jquery-ui-1.11.4.min.js') !!}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{!! asset('assets/backend/js/bootstrap.min.js') !!}"></script>
        <!-- Slimscroll -->
        <script src="{!! asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') !!}"></script>
        <!-- FastClick -->
        <script src="{!! asset('assets/backend/plugins/fastclick/fastclick.min.js') !!}"></script>
        <!-- AdminLTE App -->
        <script src="{!! asset('assets/backend/js/app.min.js') !!}"></script>
        <!-- Fixed js -->
        <script src="{!! asset('assets/backend/js/fixed.js') !!}"></script>
        <script>
            !function(a){
                a(function() {
                    a(document).on("click", ".btn-confirm-del", function(b) {
                        var c = $("#confirm-delete-del").closest("form");
                        c.attr('action', a(this).attr("link"));
                        b.preventDefault(), $("#confirm-modal-del").modal({
                            backdrop: "static",
                            keyboard: !1
                        });
                    }), a(document).on("click", ".btn-confirm-cfm", function(b) {
                        var c = $("#confirm-delete-cfm").closest("form");
                        c.attr('action', a(this).attr("link"));
                        b.preventDefault(), $("#confirm-modal-cfm").modal({
                            backdrop: "static",
                            keyboard: !1
                        });
                    }), a("ul.sidebar-menu > li").each(function(b, c) {
                        a("ul").each(function(b, c) {
                            a("li").each(function(b, c) {
                                a(this).hasClass("active") && a(this).parent().parent().addClass("active")
                            })
                        })
                    })
                })
            }(window.jQuery);
        </script>
        @yield('footer')
        <div class="scroll-top-wrapper">
            <span class="scroll-top-inner">
                <i class="ion-arrow-up-a"></i>
            </span>
        </div>
    </body>
</html>
