@extends('backend.master')
@section('title')
{!! trans('system.action.list') !!} {!! trans('news.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker-bs3.css') !!}" />
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/select2/select2.min.css') !!}" />
@stop

@section('content')
<section class="content-header">
    <h1>
        {!! trans('news.label') !!}
        <small>{!! trans('system.action.list') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
        <li><a href="{!! route('admin.news.index') !!}">{!! trans('news.label') !!}</a></li>
    </ol>
</section>
<section class="content overlay">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Tìm kiếm</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <div class="box-body">
            {!! Form::open(array('url' =>route('admin.news.index') , 'role'=>'search', 'method' => 'GET')) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('title', trans('news.title')) !!}
                        {!! Form::text('title', Request::input('title'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('category_id', trans('news.category')) !!}
                        {!! Form::select('category_id', [-1 => trans('system.dropdown_all')] + $categories, Request::input('category_id', -1), ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('update_range', trans('system.update_range')) !!}
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!! Form::text('date_range', Request::input('date_range'), ['class' => 'form-control pull-right date_range']) !!}
                        </div><!-- /.input group -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('featured', trans('news.featured')) !!}
                        {!! Form::select('featured', [ -1 => trans('system.dropdown_all'), 0 => trans('system.no'), 1 => trans('system.yes') ], Request::input('featured'), ['class' => 'form-control'])!!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('status', trans('system.status.label')) !!}
                        {!! Form::select('status', [ -1 => trans('system.dropdown_all'), 0 => trans('system.status.deactive'), 1 => trans('system.status.active') ], Request::input('status'), ['class' => 'form-control'])!!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('page_num', trans('system.page_num')) !!}
                        {!! Form::select('page_num', [ 10 => '10' . trans('system.items'), 20 => '20' . trans('system.items'), 50 => '50' . trans('system.items') , 100 => '100' . trans('system.items'), 500 => '500' . trans('system.items') ], Request::input('page_num', 20), ['class' => 'form-control select2',  "style" => "width: 100%;"]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('filter', trans('system.action.label'), ['style' => 'display: block;']) !!}
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
            <a href="{!! route('admin.news.create') !!}" class='btn btn-primary btn-flat'>
                <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('system.action.create') !!}
            </a>
        </div>
        <div class="col-md-10">
            <span  style='float: right;'>
                {!! $news->appends( Request::except('page') )->render() !!}
            </span>
        </div>
    </div>
    <?php $i = (($news->currentPage() - 1) * $news->perPage()) + 1; ?>
    @if (count($news) > 0)
        <div class="well">
            <form class="form-inline">
                <div class="form-group">
                    <span id="counterSelected" class="badge">0</span>
                    {{ trans('system.itemSelected') }} | {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $news->count()) . ' ( ' . trans('system.total') . ' ' . $news->total() . ' )' !!}
                    | <i>Chú giải: </i>&nbsp;&nbsp;
                    <span class="text-warning"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.update') !!} </span>&nbsp;&nbsp;
                    <span class="text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </span>
                </div>
                <div class="pull-right form-group">
                    <select class="form-control" id="action">
                        <option value="noaction"> -- {{ trans('system.action.label') }} -- </option>
                        <option value="category"> {{ trans('system.action.move_to') }} </option>
                        <option value="active"> {{ trans('system.status.active') }} </option>
                        <option value="deactive"> {{ trans('system.status.deactive') }} </option>
                    </select>
                    {!! Form::select('category', $categories, old('category'), ["class" => "form-control"]) !!}
                    <button type="button" class="btn btn-info" onclick="return save()">
                        <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; {{ trans('system.action.save') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="box">
            <div class="box-header with-border">
                {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $news->count()) . ' ( ' . trans('system.total') . ' ' . $news->total() . ' )' !!}
                | <i>Chú giải: </i>&nbsp;&nbsp;
                <span class="text-warning"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.update') !!} </span>&nbsp;&nbsp;
                <span class="text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </span>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">{!! Form::checkbox('check_all', 1, 0, [  ]) !!}</th>
                            <th style="text-align: center; vertical-align: middle;"> {!! trans('system.no.') !!} </th>
                            <th style="vertical-align: middle;"> {!! trans('news.title') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('news.featured') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('news.image') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;">
                                {!! trans('news.comment') !!}<br/>
                                <span class="label label-default">Chưa duyệt</span>
                            </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.status.label') !!} </th>
                            <th style="vertical-align: middle; white-space:nowrap;"> {!! trans('news.created_by') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.action.label') !!} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $item)
                        <tr>
                            <td style="text-align: center; width: 3%; vertical-align: middle;">
                                {!! Form::checkbox('newsId', $item->id, null, array('class' => 'newsId')) !!}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                            <td style="vertical-align: middle; width: 40%;">
                                <span class="label label-default">{!! \App\NewsCategory::find($item->category_id)->name !!}</span>
                                <a href="{!! route('admin.news.show', $item->id) !!}">
                                    {!! $item->title !!}
                                </a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->featured == 0)
                                <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                @elseif($item->featured == 1)
                                <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <img src="{!! asset('assets/media/images/news/' . $item->image) !!}" style="max-width: 50px;">
                            </td>
                            <th style="text-align: center; vertical-align: middle;">
                                <?php
                                    $c = $item->comments()->where('status', 0)->count();
                                    if ($c) {
                                        // last comment
                                        $lastComment = $item->comments()->where('status', 0)->orderBy('id', 'DESC')->first();
                                    }
                                    $a = $item->comments()->count();
                                ?>
                                <a href="{!! route('admin.news.show', $item->id) !!}" title="click để duyệt bình luận nếu có">
                                    <span class="badge bg-aqua">{!! $a !!}</span>
                                    <br/>
                                    @if ($c)
                                        <span class="label label-default">({!! $c !!}) - {!! date('d/m/Y H:i', strtotime($lastComment->updated_at)) !!}</span>
                                    @else
                                        <span class="label label-default">0</span>
                                    @endif
                                </a>
                            </th>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->status == 0)
                                <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                @elseif($item->status == 1)
                                <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                @endif
                            </td>
                            <td style="vertical-align: middle;">
                                <?php $user = \App\User::find( $item->created_by ); ?>
                                <a href="{!! route('admin.news.index') !!}?creator={!! $user->id !!}">
                                    <span class="label-default label"> {!! is_null($user) ? '-' : $user->fullname !!}</span>
                                </a>
                                <br/>
                                <span class="label label-default"> <i class="fa fa-clock-o"></i> {!! date("d/m/Y H:i", strtotime($item->updated_at)) !!}</span>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <a href="{!! route('admin.news.edit', $item->id) !!}" class="btn btn-default btn-xs"><i class="text-warning fa fa-edit"></i> </a>
                                <a href="javascript:void (0)" link="{!! route('admin.news.destroy', $item->id) !!}" class="btn-confirm-del btn btn-default btn-xs"><i class="text-danger glyphicon glyphicon-remove"></i></a>
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

@section('footer')
<script src="{!! asset('assets/backend/plugins/daterangepicker/moment.min.js') !!}"></script>
<script src="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<script src="{!! asset('assets/backend/plugins/input-mask/jquery.inputmask.js') !!}"></script>
<script src="{!! asset('assets/backend/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}"></script>
<script src="{!! asset('assets/backend/plugins/select2/select2.full.min.js') !!}"></script>
<script>
    !function ($) {
        $(function(){
            $("select[name='category_id']").select2();
            $("select[name='category']").hide();
            $('.date_range').daterangepicker({
                "format": "DD/MM/YYYY",
                "locale": {
                    "separator": " - ",
                    "applyLabel": "Áp dụng",
                    "cancelLabel": "Huỷ bỏ",
                    "fromLabel": "Từ ngày",
                    "toLabel": "Tới ngày",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "CN",
                        "T2",
                        "T3",
                        "T4",
                        "T5",
                        "T6",
                        "T7"
                    ],
                    "monthNames": [
                        "Thg 1",
                        "Thg 2",
                        "Thg 3",
                        "Thg 4",
                        "Thg 5",
                        "Thg 6",
                        "Thg 7",
                        "Thg 8",
                        "Thg 9",
                        "Thg 10",
                        "Thg 11",
                        "Thg 12"
                    ],
                    "firstDay": 1
                }
            }, function(start, end, label) {
              //console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
            });

            var countChecked = function() {
                $( "#counterSelected" ).text( $( "input[name='newsId']:checked" ).length );
            };
            countChecked();
            $( "input[type=checkbox][name='newsId']" ).on( "click", countChecked );
            $("input[name='check_all']").change(function() {
                if($(this).is(':checked')) {
                    $('.newsId').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.newsId').each(function() {
                        this.checked = false;
                    });
                }
                countChecked();
            });
            $("#action").change(function(event) {
                if($(this).val() == 'category') {
                    $("select[name='category']").show();
                } else {
                    $("select[name='category']").hide();
                }
            });
        });
    }(window.jQuery);
    function save() {
        if($( "input[name='newsId']:checked" ).length == 0) {
            alert("{!! trans('system.no_item_selected') !!}");
            return false;
        }
        if($('#action').val() == 'noaction') {
            alert("{!! trans('system.no_action_selected') !!}");
            return false;
        }

        box1 = new ajaxLoader('body', {classOveride: 'blue-loader', bgColor: '#000', opacity: '0.3'});

        var values = new Array();

        $.each($("input[name='newsId']:checked"),
            function () {
                values.push($(this).val());
            });

        $.ajax({
            url: "{!! URL::route('admin.news.updateBulk') !!}",
            data: { action: $('#action').val(), ids: JSON.stringify(values), category_id: $("select[name='category']").val() },
            type: 'POST',
            datatype: 'json',
            headers: {'X-CSRF-Token': "{!! csrf_token() !!}"},
            success: function(res) {
                if(res.error)
                    alert(res.message);
                else
                    window.location.reload(true);
            },
            error: function(obj, status, err) {
                alert(err);
            }
        }).always(function() {
            if(box1) box1.remove();
        });
    };
</script>
@stop