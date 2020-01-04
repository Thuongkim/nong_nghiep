@extends('backend.master')
@section('title')
    {!! trans('system.action.edit') !!} - {!! trans('stores.label') !!}
@stop
@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop
@section('content')
    <section class="content-header">
        <h1>
            {!! trans('stores.label') !!}
            <small>{!! trans('system.action.edit') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.stores.index') !!}">{!! trans('stores.label') !!}</a></li>
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
    {!! Form::open(array('url' => route('admin.stores.update', $store->id), 'method' => 'PUT', 'role' => 'form')) !!}

        <table class='table borderless'>
            @if ($store->status == \App\Define\Store::STATUS_PROCESSING)
                <tr>
                    <th class="text-right" style="width: 15%;">
                        {!! trans('stores.name') !!}
                    </th>
                    <td style="width: 35%;">
                        {!! Form::text('name', old('name', $store->name), array('class' => 'form-control', 'disabled')) !!}
                    </td>
                    <th class="text-right" style="width: 15%;">
                        {!! trans('stores.link') !!}
                    </th>
                    <td style="width: 35%;">
                        {!! Form::text('link', old('link', $store->link), array('class' => 'form-control', 'disabled')) !!}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">
                        {!! trans('stores.note') !!}
                    </th>
                    <td colspan="3">
                        {!! Form::text('note', old('note', $store->note), array('class' => 'form-control')) !!}
                    </td>
                </tr>
            @else
                <tr>
                    <th class="text-right" style="width: 15%;">
                        {!! trans('stores.name') !!}
                    </th>
                    <td style="width: 35%;">
                        {!! Form::text('name', old('name', $store->name), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                    </td>
                    <th class="text-right" style="width: 15%;">
                        {!! trans('stores.link') !!}
                    </th>
                    <td style="width: 35%;">
                        {!! Form::text('link', old('link', $store->link), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">
                        {!! trans('stores.note') !!}
                    </th>
                    <td colspan="3">
                        {!! Form::text('note', old('note', $store->note), array('class' => 'form-control')) !!}
                    </td>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">
                        @if ($store->status == \App\Define\Store::STATUS_WAITING) {!! trans('stores.status.' . \App\Define\Store::STATUS_CANCELED) !!} @else {!! trans('stores.status.' . \App\Define\Store::STATUS_WAITING) !!} @endif
                        {!! Form::checkbox('status', 1, old('status', 0), [ 'class' => 'minimal' ]) !!}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="4" class="text-center">
                    {!! HTML::link(route( 'admin.stores.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
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
        });
    }(window.jQuery);
</script>
@stop