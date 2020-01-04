@extends('backend.master')

@section('title')
    {!! trans('system.action.approve') !!} - {!! trans('news.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('news.label') !!}
            <small>{!! trans('system.action.approve') !!}</small>
            <?php $user = \App\User::find( $news->created_by ); ?>
            <small></small>
        </h1>
        <small>
            Người gửi <span class="label label-success">{!! is_null( $user ) ? '-' : $user->fullname !!}</span>
        </small>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.news.index') !!}">{!! trans('news.label') !!}</a></li>
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
    {!! Form::open(array('url' => route('admin.news.publish', $news->id), 'method' => 'PUT', 'role' => 'form', 'files' => true )) !!}
        <table class='table borderless'>
            <tr>
                <th class="text-right">
                    {!! trans('news.title') !!}
                </th>
                <td>
                    {!! Form::text('title', old('title', $news->title), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                </td>
                <th class="text-right">
                    {!! trans('news.category') !!}
                </th>
                <td>
                    {!! Form::select('category', $categories, old('category', $news->category_id), ["class" => "form-control"]) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('news.slug') !!}
                </th>
                <td colspan="3">
                    {!! Form::text('slug', old('slug', $news->slug ? $news->slug : (str_slug($news->title) . '-' . $news->id)), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right" style="width: 15%;">
                    {!! trans("news.image") !!}
                    <br/>
                    ({!! \App\Define\News::IMAGE_NEWS_WIDTH !!}x{!! \App\Define\News::IMAGE_NEWS_HEIGHT !!})
                    <br/><a href="https://youtu.be/lK2pH8PPrvo?t=3m31s" target="_blank">Hướng dẫn</a>
                </th>
                <td style="width: 35%;">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail" style="width: {!! \App\Define\News::IMAGE_NEWS_WIDTH/\App\Define\News::IMAGE_NEWS_RATIO !!}px; height: {!! \App\Define\News::IMAGE_NEWS_HEIGHT/\App\Define\News::IMAGE_NEWS_RATIO !!}px;">
                            <img src="{!! asset('assets/media/images/news/' . $news->image) !!}">
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
                <th class="text-right" style="width: 15%;">
                    {!! trans('news.summary') !!}
                </th>
                <td>
                    {!! Form::textarea('summary', old('summary', $news->summary), array('class' => 'form-control', 'rows' => 5, 'maxlength' => 255, 'required')) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('news.content') !!}
                    <br/><a href="https://youtu.be/lK2pH8PPrvo?t=5m53s" target="_blank">Hướng dẫn<br/>ảnh bài viết</a>
                </th>
                <td colspan="3">
                    {!! Form::textarea('content', old('content', $news->content), array('class' => 'form-control ckeditor', 'rows' => 25, 'id' => 'content')) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('news.seo_keywords') !!}
                </th>
                <td colspan="3">
                    {!! Form::textarea('seo_keywords', old('seo_keywords', $news->seo_keywords), array('class' => 'form-control', 'rows' => 2, 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('news.seo_description') !!}
                </th>
                <td colspan="3">
                    {!! Form::textarea('seo_description', old('seo_description', $news->seo_description), array('class' => 'form-control', 'rows' => 5, 'maxlength' => 1024)) !!}
                </td>
            </tr>
            <tr>
                <th colspan="4" class="text-center">
                    {!! trans('news.featured') !!}
                    {!! Form::checkbox('featured', 1, old('featured', $news->featured), [ 'class' => 'minimal' ]) !!}
                    &nbsp;&nbsp;
                    {!! trans('system.status.active') !!}
                    {!! Form::checkbox('status', 1, old('status', $news->status), [ 'class' => 'minimal-red' ]) !!}
                    &nbsp;&nbsp; | &nbsp;&nbsp;
                    Gửi email
                    {!! Form::checkbox('send_mail', 1, old('send_mail', 0), [ 'class' => 'minimal' ]) !!}
                    @if (\Auth::guard('admin')->user()->hasRole(['system', 'admin']))
                        &nbsp;&nbsp; | &nbsp;&nbsp;
                        {!! trans('news.paid') !!}
                        {!! Form::checkbox('paid', 1, old('paid', $news->paid), [ 'class' => 'minimal-red' ]) !!}
                        &nbsp;&nbsp;
                        Đóng hộp thoại
                        {!! Form::checkbox('closed', 1, old('closed', $news->closed), [ 'class' => 'minimal' ]) !!}
                    @endif
                    @if ($news->ref_id)
                        <?php $hub = App\Store::find($news->ref_id); ?>
                        @unless (is_null($hub))
                            <br/>
                            Dịch từ: <a href="{!! $hub->link !!}" target="_blank">{!! $hub->name !!}</a>
                        @endunless
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">
                    {!! HTML::link(route( 'admin.news.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
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
@include('backend.plugins.ckeditor')
@stop