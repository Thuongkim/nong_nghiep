@extends('backend.master')

@section('title')
    {!! trans('system.action.edit') !!} - {!! trans('news.categories.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('news.categories.label') !!}
            <small>{!! trans('system.action.edit') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.news-categories.index') !!}">{!! trans('news.categories.label') !!}</a></li>
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
    {!! Form::open(array('url' => route('admin.news-categories.update', $category->id), 'method' => 'PUT', 'role' => 'form')) !!}

        <table class='table borderless'>
            <tr>
                <th class="table_right_middle">
                    {!! trans('news.categories.name') !!}
                </th>
                <td style="width: 35%;">
                    {!! Form::text('name', old('name', $category->name), array('class' => 'form-control', 'maxlength' => 100)) !!}
                </td>
                <th class="table_right_middle">
                    {!! trans('news.categories.parent') !!}
                </th>
                <td>
                    {!! Form::select('parent', ['' => trans('news.categories.parent_category')] + $categories, old('parent', $category->parent_id), ["class" => "form-control"]) !!}
                </td>
            </tr>
            <tr>
                <th class="table_right_middle">
                    {!! trans('news.categories.summary') !!}
                </th>
                <td colspan="3">
                    {!! Form::textarea('summary', old('summary', $category->summary), array('class' => 'form-control', 'rows' => 2, 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! Form::checkbox('is_single', 1, old('is_single', $category->is_single), [ 'class' => 'minimal' ]) !!}
                </th>
                <td>
                    {!! trans('news.categories.is_single') !!}
                </td>
                <th class="table_right_middle">
                    {!! trans('system.status.label') !!}
                </th>
                <td>
                    {!! Form::checkbox('status', 1, old('status', $category->status), [ 'class' => 'minimal-red' ]) !!} {!! trans('system.status.active') !!}
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