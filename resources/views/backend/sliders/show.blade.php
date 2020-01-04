@extends('backend.master')

@section('title')
    {!! trans('system.action.detail') !!} - {!! trans('sliders.label') !!}
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('sliders.label') !!}
            <small>{!! trans('system.action.detail') !!}</small>
            @if($slider->status)
                <label class="label label-success">
                    {!! trans('system.status.active') !!}
                </label>
            @else
                <label class="label label-default">
                    {!! trans('system.status.deactive') !!}
                </label>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.sliders.index') !!}">{!! trans('sliders.label') !!}</a></li>
        </ol>
    </section>
    <table class='table borderless'>
        <tr>
            <th class="table_right_middle">
                {!! trans('sliders.name') !!}
            </th>
            <td>
                {!! $slider->name !!}
            </td>
            <th class="text-right">
                {!! trans('sliders.href') !!}
            </th>
            <td>
                {!! $slider->href !!}
            </td>
        </tr>
        <tr>
            <th class="text-right">
                {!! trans("sliders.image") !!}<br/>
                ({!! \App\Define\Constant::IMAGE_SLIDER_WIDTH !!}x{!! \App\Define\Constant::IMAGE_SLIDER_HEIGHT !!})
            </th>
            <td colspan="3">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: {!! \App\Define\Constant::IMAGE_SLIDER_WIDTH/\App\Define\Constant::IMAGE_SLIDER_RATIO !!}px; height: {!! \App\Define\Constant::IMAGE_SLIDER_HEIGHT/\App\Define\Constant::IMAGE_SLIDER_RATIO !!}px;">
                        <img src="{!! asset($slider->image) !!}">
                    </div>
                </div>
            </td>
        </tr>
    </table>
@stop