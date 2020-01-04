@extends('backend.master')

@section('title')
    {!! trans('system.action.edit') !!} - {!! trans('news_categories.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('news_categories.label') !!}
            <small>{!! trans('system.action.edit') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.news-categories.index') !!}">{!! trans('news_categories.label') !!}</a></li>
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

    {!! Form::open(array('url' => route('admin.news-categories.update', $newsCategory->id), 'method' => 'PUT', 'role' => 'form', 'files' => true)) !!}
        <table class='table borderless'>
            <tr>
                <th class="table_right_middle">
                    {!! trans('news_categories.name') !!}
                </th>
                <td colspan="3">
                    {!! Form::text('name', old('name', $newsCategory->name), array('class' => 'form-control', 'maxlength' => 100, 'required')) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right" style="width: 15%;">
                    {!! trans('news_categories.level0') !!}
                </th>
                <td style="width: 35%;">
                    {!! Form::select('level0', [ 0 => trans('news_categories.root') ] + $categories, old('level0', $rootCategoryId), ['class'=>"form-control", 'disabled']) !!}
                </td>
                <th class="text-right" style="width: 15%;">
                    {!! trans('news_categories.level1') !!}
                </th>
                <td>
                    {!! Form::select('level1', $level1Categories, old('level1', $newsCategory->parent_id), ['class'=>"form-control", 'disabled']) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans("news_categories.image") !!}<br/>
                    ({!! \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH !!}x{!! \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT !!})
                </th>
                <td colspan="3">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail" style="width: {!! \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_WIDTH/\App\Define\Constant::IMAGE_NEWS_CAT_BANNER_RATIO !!}px; height: {!! \App\Define\Constant::IMAGE_NEWS_CAT_BANNER_HEIGHT/\App\Define\Constant::IMAGE_NEWS_CAT_BANNER_RATIO !!}px;">
                            @if ($newsCategory->image)
                                <img src="{!! asset($newsCategory->image) !!}">
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
                    {!! trans('news_categories.summary') !!}
                </th>
                <td colspan="3">
                    {!! Form::textarea('summary', old('summary', $newsCategory->summary), array('class' => 'form-control', 'rows' => 2, 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('system.seo_keywords') !!}
                </th>
                <td colspan="3">
                    {!! Form::text('seo_keywords', old('seo_keywords', $newsCategory->seo_keywords), array('class' => 'form-control', 'maxlength' => 50)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('system.seo_description') !!}
                </th>
                <td colspan="3">
                    {!! Form::textarea('seo_description', old('seo_description', $newsCategory->seo_description), array('class' => 'form-control', 'rows' => 2, 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">
                    <label>
                        {!! Form::checkbox('status', 1, old('status', $newsCategory->status), [ 'class' => 'minimal' ]) !!}
                        {!! trans('system.status.active') !!}
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        {!! Form::checkbox('view_all', 1, old('view_all', $newsCategory->view_all), [ 'class' => 'minimal-red' ]) !!}
                        {!! trans('news_categories.view_all') !!}
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        {!! Form::checkbox('show_menu', 1, old('show_menu', $newsCategory->show_menu), [ 'class' => 'minimal' ]) !!}
                        {!! trans('news_categories.show_menu') !!}
                    </label>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">
                    {!! HTML::link(route( 'admin.news-categories.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
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