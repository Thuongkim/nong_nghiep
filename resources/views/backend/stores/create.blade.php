@extends('backend.master')
@section('title')
    {!! trans('system.action.create') !!} - {!! trans('stores.label') !!}
@stop
@section('content')
    <section class="content-header">
        <h1>
            {!! trans('stores.label') !!}
            <small>{!! trans('system.action.create') !!}</small>
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
    {!! Form::open(array('url' => route('admin.stores.store'), 'role' => 'form')) !!}
        <table class='table borderless'>
            <tr>
                <th class="text-right" style="width: 15%;">
                    {!! trans('stores.name') !!}
                </th>
                <td style="width: 35%;">
                    {!! Form::text('name', old('name'), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                </td>
                <th class="text-right" style="width: 15%;">
                    {!! trans('stores.link') !!}
                </th>
                <td style="width: 35%;">
                    {!! Form::text('link', old('link'), array('class' => 'form-control', 'required', 'maxlength' => 255)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('stores.note') !!}
                </th>
                <td colspan="3">
                    {!! Form::text('note', old('note'), array('class' => 'form-control')) !!}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">
                    {!! HTML::link(route( 'admin.stores.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
                    {!! Form::submit("Gửi bài", array('class' => 'btn btn-primary btn-flat')) !!}
                </td>
            </tr>
        </table>
    {!! Form::close() !!}
@stop