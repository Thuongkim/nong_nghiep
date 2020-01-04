@extends('backend.master')
@section('title')
    {!! trans('system.action.edit') !!} - {!! trans('experiences.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop
@section('content')
    <section class="content-header">
        <h1>
            {!! trans('experiences.label') !!}
            <small>{!! trans('system.action.edit') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.experiences.index') !!}">{!! trans('experiences.label') !!}</a></li>
        </ol>
    </section>
    @if($errors->count())
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> {!! trans('messages.error') !!}</h4>
            <ul>
                @foreach($errors->all() as $message)
                <li>{!! $message !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(array('url' => route('admin.experiences.update', $experience->id), 'method' => 'PUT', 'role' => 'form', 'files' => true)) !!}

        <table class='table borderless'>
            <tr>
                <th class="table_right_middle" style="width: 15%;">
                    {!! trans('experiences.fullname') !!}
                </th>
                <td style="width: 35%;">
                    {!! Form::text('fullname', old('fullname', $experience->fullname), array('class' => 'form-control', 'maxlength' => 50, 'required')) !!}
                </td>
                <th class="text-right" style="width: 15%;">
                    {!! trans('experiences.email') !!}
                </th>
                <td>
                    {!! Form::text('email', old('email', $experience->email), array('class' => 'form-control', 'maxlength' => 50)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('experiences.phone') !!}
                </th>
                <td>
                    {!! Form::text('phone', old('phone', $experience->phone), array('class' => 'form-control', 'maxlength' => 12)) !!}
                </td>
                <th class="text-right">
                    {!! trans("experiences.image") !!}<br/>
                    ({!! \App\Define\Constant::IMAGE_EXPERIENCE_WIDTH !!}x{!! \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT !!})
                </th>
                <td rowspan="2">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail" style="width: {!! \App\Define\Constant::IMAGE_EXPERIENCE_WIDTH/\App\Define\Constant::IMAGE_EXPERIENCE_RATIO !!}px; height: {!! \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT/\App\Define\Constant::IMAGE_EXPERIENCE_RATIO !!}px;">
                            @if($experience->image)
                            <img src="{!! asset($experience->image) !!}" height="30px">
                            @endif
                        </div>
                        <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileupload-new">
                                    {!! trans('system.action.select_image') !!}
                                </span>
                                {!! Form::file('image') !!}
                            </span>
                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">
                                {!! trans('system.action.remove') !!}
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('experiences.content') !!}
                </th>
                <td>
                    {!! Form::textarea('content', old('content', $experience->content), array('class' => 'form-control', 'maxlength' => 1024, 'rows' => 5)) !!}
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">
                    <label>
                        {!! Form::checkbox('status', 1, old('status', $experience->status), [ 'class' => 'minimal' ]) !!}
                        {!! trans('system.status.active') !!}
                    </label>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">
                    {!! HTML::link(route( 'admin.experiences.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
                    {!! Form::submit(trans('system.action.save'), array('class' => 'btn btn-primary btn-flat')) !!}
                </td>
            </tr>
        </table>

    {!! Form::close() !!}
@stop
@section('footer')
    <script src="{!! asset('assets/backend/plugins/jasny/js/bootstrap-fileupload.js') !!}"></script>
    <script src="{!! asset('assets/backend/plugins/iCheck/icheck.min.js') !!}"></script>
    <script>
        !function ($) {
            $(function() {
                $('input[type="checkbox"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue'
                });

                $('input[type="checkbox"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red'
                });
            });
        }(window.jQuery);
    </script>
@stop