@extends('backend.master')

@section('title')
{!! trans('system.action.list') !!} {!! trans('news_categories.label') !!}
@stop
@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/treegrid/css/jquery.treegrid.css') !!}">
@stop

@section('content')
<section class="content-header">
    <h1>
        {!! trans('news_categories.label') !!}
        <small>{!! trans('system.action.list') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
        <li><a href="{!! route('admin.news-categories.index') !!}">{!! trans('news_categories.label') !!}</a></li>
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
            {!! Form::open([ 'url' => route('admin.news-categories.index'), 'method' => 'GET', 'role' => 'search' ]) !!}

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('visible', trans('system.show')) !!}
                        {!! Form::select('visible', [ -1 => trans('system.dropdown_all'), 0 => trans('news_categories.root'), 1 => trans('news_categories.level0') ], Request::input('visible'), ['class' => 'form-control select2',  "style" => "width: 100%;"])!!}
                    </div>
                </div>
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
            <a href="{!! route('admin.news-categories.create') !!}" class='btn btn-primary btn-flat'>
                <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('system.action.create') !!}
            </a>
        </div>
        <div class="col-md-10">
        </div>
    </div>
    @if (count($categories) > 0)
    <?php $labels = ['default', 'success', 'info', 'danger', 'warning']; $i = 1; ?>
    <div class="well">
        <div class="form-inline">
            <div class="form-group">
                {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $categories->count()) . ' ( ' . trans('system.total') . ' ' . $categories->count() . ' )' !!}
                | <i>Chú giải: </i>&nbsp;&nbsp;
                <span class="text-warning"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.update') !!} </span>&nbsp;&nbsp;
                <span class="text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </span>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-body no-padding">
            <table class='table table-striped table-bordered tree'>
                <thead>
                    <tr>
                        <th style="text-align: center; vertical-align: middle;"></th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('news_categories.image') !!} </th>
                        <th style="vertical-align: middle;"> {!! trans('news_categories.name') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.position') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('news_categories.number_of_news') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('news_categories.view_all') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('news_categories.show_menu') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.status.label') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.action.label') !!} </th>
                    </tr>
                </thead>
                <tbody class="borderless">
                    @foreach ($categories as $item)
                        <?php $level1Id = $item->id; ?>
                        <tr class="treegrid-{!! $item->id !!}">
                            <td style="text-align: center; width: 3%; vertical-align: middle;"></td>
                            <td  style="text-align: center; vertical-align: middle;">
                                @if ($item->image)<img src="{!! asset($item->image) !!}" style="max-height: 80px; max-width: 120px;"> @endif
                            </td>
                            <td style="text-align: justify; vertical-align: middle;">
                                {!! $item->name !!}
                            </td>
                            <td  style="text-align: center; vertical-align: middle;">
                                @if($item->countSameType() > 1)
                                    @if($item->position == 1)
                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                        </a>
                                    @elseif( $item->position == $item->countSameType() )
                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                        </a>&nbsp;|&nbsp;
                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}">
                                            <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <?php $numOfNews = $item->news()->count(); ?>
                                <span class="label label-{!! $labels[$numOfNews%4] !!}"> {!! $numOfNews !!} </span>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->view_all == 1)
                                    <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                @else
                                    <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->show_menu == 1)
                                    <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                @else
                                    <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
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
                                <a href="{!! route('admin.news-categories.edit', $item->id) !!}" class="btn btn-default btn-xs"><i class="text-warning fa fa-edit"></i> </a>
                                <a href="javascript:void (0)" link="{!! route('admin.news-categories.destroy', $item->id) !!}" class="btn-confirm-del btn btn-default btn-xs"><i class="text-danger glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                        @if(isset($item->children) && $item->children->count())
                            @foreach ($item->children as $item)
                                <?php $level2Id = $item->id; ?>
                                <tr class="treegrid-{!! $item->id !!} treegrid-parent-{!! $level1Id !!}">
                                    <td style="vertical-align: middle;">
                                    </td>
                                    <td  style="text-align: center; vertical-align: middle;">
                                        @if ($item->image)<img src="{!! asset($item->image) !!}" style="max-height: 80px; max-width: 120px;"> @endif
                                    </td>
                                    <td style="text-align: justify; vertical-align: middle;">
                                        <span class="text-warning">
                                            |___{!! $item->name !!}
                                        </span>
                                    </td>
                                    <td  style="text-align: center; vertical-align: middle;">
                                        @if($item->countSameType() > 1)
                                            @if($item->position == 1)
                                                <a href="{{ route('admin.news-categories.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}" class="text-warning">
                                                    <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                                </a>
                                            @elseif( $item->position == $item->countSameType() )
                                                <a href="{{ route('admin.news-categories.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}" class="text-warning">
                                                    <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.news-categories.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}" class="text-warning">
                                                    <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                                </a>&nbsp;|&nbsp;
                                                <a href="{{ route('admin.news-categories.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}" class="text-warning">
                                                    <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <?php $numOfNews = $item->news()->count(); ?>
                                        <span class="label label-{!! $labels[$numOfNews%4] !!}"> {!! $numOfNews !!} </span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if($item->view_all == 1)
                                            <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                        @else
                                            <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                        @endif
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if($item->show_menu == 1)
                                            <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                        @else
                                            <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
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
                                        <a href="{!! route('admin.news-categories.edit', $item->id) !!}" class="btn btn-default btn-xs"><i class="text-warning fa fa-edit"></i> </a>
                                        <a href="javascript:void (0)" link="{!! route('admin.news-categories.destroy', $item->id) !!}" class="btn-confirm-del btn btn-default btn-xs"><i class="text-danger glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                                @if(isset($item->children) && $item->children->count())
                                    @foreach ($item->children as $item)
                                        <tr class="treegrid-parent-{!! $level2Id !!}">
                                            <td style="text-align: center; vertical-align: middle;">
                                            </td>
                                            <td  style="text-align: center; vertical-align: middle;">
                                                @if ($item->image)<img src="{!! asset($item->image) !!}" style="max-height: 80px; max-width: 120px;"> @endif
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span class="text-danger">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|___{!! $item->name !!}
                                                </span>
                                            </td>
                                            <td  style="text-align: center; vertical-align: middle;">
                                                @if($item->countSameType() > 1)
                                                    @if($item->position == 1)
                                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}" class="text-danger">
                                                            <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                                        </a>
                                                    @elseif( $item->position == $item->countSameType() )
                                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}" class="text-danger">
                                                            <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, -1]) }}" title="{{ trans('system.up') }}" class="text-danger">
                                                            <i class="glyphicon glyphicon-circle-arrow-up"></i>
                                                        </a>&nbsp;|&nbsp;
                                                        <a href="{{ route('admin.news-categories.update-position', [$item->id, 1]) }}" title="{{ trans('system.down') }}" class="text-danger">
                                                            <i class="glyphicon glyphicon-circle-arrow-down"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <?php $numOfNews = $item->news()->count(); ?>
                                                <span class="label label-{!! $labels[$numOfNews%4] !!}"> {!! $numOfNews !!} </span>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->view_all == 1)
                                                    <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                                @else
                                                    <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                                @endif
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->show_menu == 1)
                                                    <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                                @else
                                                    <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
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
                                                <a href="{!! route('admin.news-categories.edit', $item->id) !!}" class="btn btn-default btn-xs"><i class="text-warning fa fa-edit"></i> </a>
                                                <a href="javascript:void (0)" link="{!! route('admin.news-categories.destroy', $item->id) !!}" class="btn-confirm-del btn btn-default btn-xs"><i class="text-danger glyphicon glyphicon-remove"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
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
@section('footer')
    <script src="{!! asset('assets/backend/plugins/treegrid/js/jquery.treegrid.min.js') !!}"></script>
    <script>
        !function ($) {
            $(function(){
                $('.tree').treegrid({
                    //"initialState": "expanded"//collapsed
                });

            });
        }(window.jQuery);
    </script>
@stop