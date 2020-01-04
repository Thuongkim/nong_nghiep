@extends('backend.master')

@section('title')
    {!! trans('system.action.edit') !!} - {!! trans('static_pages.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('static_pages.label') !!}
            <small>{!! trans('system.action.edit') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.static-pages.index') !!}">{!! trans('static_pages.label') !!}</a></li>
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
    {!! Form::open(array('url' => route('admin.static-pages.update', $news->id), 'method' => 'PUT', 'role' => 'form', 'files' => true )) !!}

        <table class='table borderless'>
            <tr>
                <th class="text-right">
                    {!! trans('static_pages.title') !!}
                </th>
                <td>
                    {!! Form::text('title', old('title', $news->title), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('static_pages.description') !!}
                </th>
                <td colspan="3">
                    @if ($news->type == \App\Define\Constant::STATIC_PAGE_SIMPLE)
                        {!! Form::text('description', old('description', $news->description), array('class' => 'form-control')) !!}
                    @elseif ($news->type == \App\Define\Constant::STATIC_PAGE_COMPLEX)
                        {!! Form::textarea('description', old('description', $news->description), array('class' => 'form-control', 'rows' => 5)) !!}
                    @else
                        {!! Form::textarea('description', old('description', $news->description), array('class' => 'form-control ckeditor', 'rows' => 25, 'id' => 'description')) !!}
                    @endif
                </td>
            </tr>
            <tr>
                <th class="text-center" colspan="2">
                    {!! trans('system.status.active') !!}
                    {!! Form::checkbox('status', 1, old('status', $news->status), [ 'class' => 'minimal-red' ]) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    {!! HTML::link(route( 'admin.static-pages.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
                    {!! Form::submit(trans('system.action.save'), array('class' => 'btn btn-primary btn-flat')) !!}
                </td>
            </tr>
        </table>

    {!! Form::close() !!}
@stop

@section('footer')
<script src="{!! asset('assets/backend/plugins/iCheck/icheck.min.js') !!}"></script>
<script>
    !function ($) {
        $(function() {
            $('input[type="checkbox"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red'
            });
        });
    }(window.jQuery);
</script>
@include('backend.plugins.ckeditor')
@stop