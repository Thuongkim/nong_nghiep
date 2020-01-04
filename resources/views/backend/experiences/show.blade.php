@extends('backend.master')

@section('title')
    {!! trans('system.action.detail') !!} - {!! trans('experiences.label') !!}
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('experiences.label') !!}
            <small>{!! trans('system.action.detail') !!}</small>
            @if($experience->status)
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
            <li><a href="{!! route('admin.experiences.index') !!}">{!! trans('experiences.label') !!}</a></li>
        </ol>
    </section>
    <table class='table borderless'>
        <tr>
            <th class="table_right_middle">
                {!! trans('experiences.fullname') !!}
            </th>
            <td>
                {!! $experience->fullname !!}
            </td>
            <th class="text-right">
                {!! trans('experiences.email') !!}
            </th>
            <td>
                {!! $experience->email !!}
            </td>
        </tr>
        <tr>
            <th class="table_right_middle">
                {!! trans('experiences.phone') !!}
            </th>
            <td>
                {!! $experience->phone !!}
            </td>
            <th class="text-right" rowspan="2">
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
                </div>
            </td>
        </tr>
        <tr>
            <th class="table_right_middle">
                {!! trans('experiences.content') !!}
            </th>
            <td>
                {!! $experience->content !!}
            </td>
        </tr>
    </table>
@stop