<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập | Quản trị | {!! env('APP_NAME') !!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/bootstrap.min.css') !!}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/fonts/font-awesome.min.css') !!}" />
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/css/AdminLTE.min.css') !!}" />
    <!-- iCheck -->
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/square/blue.css') !!}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Quản trị</b> {!! env('APP_NAME') !!}
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>
            {!! Form::open(array('url' => route('admin.login'))) !!}

                <div class="form-group has-feedback">
                    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => trans('forms.email'), 'required', 'autofocus')) !!}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::password('password', array('class' => 'form-control', 'placeholder' => trans('forms.password'), 'required')) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Ghi nhớ đăng nhập
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        {!! Form::submit(trans('forms.login'), array('class' => 'btn btn-primary btn-block btn-flat')) !!}
                    </div><!-- /.col -->
                </div>
            {!! Form::close() !!}
            @if($errors->count())
            <div class='alert alert-danger'>
                {!! trans('messages.error') !!}
                <ul>
                    @foreach($errors->all() as $message)
                    <li>{!! $message !!}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{!! asset('assets/backend/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{!! asset('assets/backend/js/bootstrap.min.js') !!}"></script>
    <!-- iCheck -->
    <script src="{!! asset('assets/backend/plugins/iCheck/icheck.min.js') !!}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>
</html>
