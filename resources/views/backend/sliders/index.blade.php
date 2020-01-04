@extends('backend.master')

@section('title')
{!! trans('system.action.list') !!} {!! trans('sliders.label') !!}
@stop
@section('content')
<section class="content-header">
    <h1>
        {!! trans('sliders.label') !!}
        <small>{!! trans('system.action.list') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
        <li><a href="{!! route('admin.sliders.index') !!}">{!! trans('sliders.label') !!}</a></li>
    </ol>
</section>

<section class="content overlay">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{!! trans('system.action.filter') !!}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! Form::open([ 'url' => route('admin.sliders.index'), 'method' => 'GET', 'role' => 'search' ]) !!}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('status', trans('system.status.label')) !!}
                        {!! Form::select('status', [ -1 => trans('system.dropdown_all'), 0 => trans('system.status.deactive'), 1 => trans('system.status.active') ], Request::input('status'), ['class' => 'form-control select2',  "style" => "width: 100%;"])!!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('filter', trans('system.action.label')) !!}
                        <button type="submit" class="btn btn-default btn-flat">
                            <span class="glyphicon glyphicon-search"></span>&nbsp; {!! trans('system.action.search') !!}
                        </button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="row">
        <div class="col-md-2" style='float: left;'>
            <a href="{!! route('admin.sliders.create') !!}" class='btn btn-primary btn-flat'>
                <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('system.action.create') !!}
            </a>
        </div>
        <div class="col-md-10">
            <span  style='float: right;'>

            </span>
        </div>
    </div>
    @if (count($sliders) > 0)
    <?php $labels = ['default', 'success', 'info', 'danger', 'warning']; ?>
    <div class="box">
        <div class="box-body no-padding">
            <table class='table table-striped table-bordered tree'>
                <thead>
                    <tr>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('sliders.image') !!} </th>
                        <th style="vertical-align: middle;"> {!! trans('sliders.name') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.position') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.status.label') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.action.label') !!} </th>
                    </tr>
                </thead>
                <tbody class="borderless">
                    @foreach ($sliders as $item)
                        <tr>
                            <td  style="text-align: center; vertical-align: middle;">
                                <img src="{!! asset($item->image) !!}" height="30px">
                            </td>
                            <td style="text-align: justify; vertical-align: middle;">
                                <a href="{!! route('admin.sliders.show', $item->id) !!}" title="{!! trans('system.action.detail') !!}">
                                    {!! $item->name !!}
                                </a>
                            </td>
                            <td  style="text-align: center; vertical-align: middle;">
                                @if($sliders->count() > 1)
                                    @if($item->position == 1)
                                        <a href="{{ route('admin.sliders.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                        </a>
                                    @elseif( $item->position == $sliders->count() )
                                        <a href="{{ route('admin.sliders.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.sliders.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                        </a>&nbsp;|&nbsp;
                                        <a href="{{ route('admin.sliders.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->status == 0)
                                <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                @elseif($item->status == 1)
                                <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a href="{!! route('admin.sliders.edit', $item->id) !!}" class="btn-edit edit text-warning">
                                    <i class="glyphicon glyphicon-edit"></i>
                                    {!! trans('system.action.edit') !!}
                                </a>
                                &nbsp;
                                <a style="cursor: pointer;" link="{!! route('admin.sliders.destroy', $item->id) !!}" class="btn-confirm-del text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-info"> {!! trans('system.no_record_found') !!}</div>
    @endif
</section>
@stop