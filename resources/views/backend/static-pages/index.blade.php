@extends('backend.master')

@section('title')
{!! trans('system.action.list') !!} {!! trans('static_pages.label') !!}
@stop

@section('content')
<section class="content-header">
    <h1>
        {!! trans('static_pages.label') !!}
        <small>{!! trans('system.action.list') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
        <li><a href="{!! route('admin.static-pages.index') !!}">{!! trans('static_pages.label') !!}</a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content overlay">
    @if (count($news) > 0)
    <div class="box">
        <?php $i = 1; ?>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">#</th>
                            <th style="vertical-align: middle;"> {!! trans('static_pages.title') !!} </th>
                            <th style="text-align: center; vertical-align: middle;"> {!! trans('system.status.label') !!} </th>
                            <th style="text-align: center; vertical-align: middle;"> {!! trans('system.updated_at') !!} </th>
                            <th style="text-align: center; vertical-align: middle;"> {!! trans('system.action.label') !!} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $item)
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                            <td style="text-align: justify; vertical-align: middle;">
                                {!! HTML::link( route('admin.static-pages.show', $item->id), \App\Helper\HString::modSubstr($item->title, 50), array('class' => '', 'title' => $item->title)) !!}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->status == 0)
                                <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                @elseif($item->status == 1)
                                <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">{!! date("d/m/Y H:i", strtotime($item->updated_at)) !!}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a href="{!! route('admin.static-pages.edit', $item->id) !!}" class="text-warning"><i class="glyphicon glyphicon-edit"></i> Sửa </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-success" style="margin-top: 20px;"> {!! trans('system.no_record_found') !!}</div>
    @endif
</section><!-- /.content -->
@stop