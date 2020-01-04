@extends('backend.master')
@section('title')
    Hub link
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker-bs3.css') !!}" />
    <style type="text/css">
        .popover-content {
            word-break: break-all;
        }
    </style>
@stop

@section('content')
<section class="content-header">
    <h1>
        Hub link
        <small>Hãy chọn 1 liên kết để bắt đầu bài viết của bạn!</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}"><i class="fa fa-home"></i> Trang chủ</a></li>
    </ol>
</section>
<section class="content overlay">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{!! trans('system.action.search') !!}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <div class="box-body">
            {!! Form::open(array('url' =>route('admin.hub-links') , 'role'=>'search', 'method' => 'GET')) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('name', trans('stores.name')) !!}
                        {!! Form::text('name', Request::input('name'), ['class' => 'form-control']) !!}
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
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('status', trans('system.status.label')) !!}
                        {!! Form::select('status', [-1 => trans('system.dropdown_all')] + App\Define\Store::getStatusByRoleForOptions(), Request::input('status', $inQueue ? App\Define\Store::STATUS_PROCESSING : App\Define\Store::STATUS_WAITING), ['class' => 'form-control'])!!}
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4 class="text-danger">Chọn một bài rồi thực hiện thao tác nhận liên kết!</h4>
        </div>
        <div class="col-md-6">
            <span  style='float: right;'>
                {!! $stores->appends( Request::except('page') )->render() !!}
            </span>
        </div>
    </div>
    <?php $i = (($stores->currentPage() - 1) * $stores->perPage()) + 1; ?>
    @if (count($stores) > 0)
        <div class="box">
            <div class="box-header with-border">
                {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $stores->count()) . ' ( ' . trans('system.total') . ' ' . $stores->total() . ' )' !!}
                | <i>Chú giải: </i>&nbsp;&nbsp;
                <span class="text-warning"><i class="fa fa-external-link"></i> Mở liên kết </span>&nbsp;&nbsp;
                <span class="text-info"><i class="fa fa-play-circle-o"></i> Nhận liên kết </span>&nbsp;&nbsp;
                <span class="text-success"><i class="fa fa-step-forward"></i> Hoàn thành </span>&nbsp;&nbsp;
                <span class="text-danger"><i class="fa fa-stop-circle-o"></i> Huỷ bỏ </span>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle;"> {!! trans('system.no.') !!} </th>
                            <th style="vertical-align: middle;"> {!! trans('stores.name') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.status.label') !!} </th>
                            <th style="vertical-align: middle; white-space:nowrap;"> {!! trans('stores.note') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.updated_at') !!} </th>
                            <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.action.label') !!} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $labels = ['success', 'info', 'danger', 'warning', 'default']; ?>
                        @foreach ($stores as $item)
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                            <td style="vertical-align: middle;">
                                <a href="{!! $item->link !!}" target="_blank">
                                    {!! $item->name !!}
                                </a>
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <span class="label label-{!! App\Define\Store::getLabelStatus($item->status) !!}">{!! trans('stores.status.' . $item->status) !!}</span>
                            </td>
                            <td style="vertical-align: middle; white-space: nowrap;">
                                @if ($item->note)
                                <a href="javascript:void(0)" data-toggle="popover" title="{!! trans('stores.note') !!}" data-content="{!! nl2br($item->note) !!}" class="embeded-popover-dismiss"><i class="fa fa-eye"></i> Lưu ý
                                </a>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <span class="label label-default">{!! date("d/m/Y H:i", strtotime($item->updated_at)) !!}</span>
                            </td>
                            <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                                <a href="{!! $item->link !!}" class="btn btn-default btn-xs" target="_blank"><i class="text-warning fa fa-external-link"></i> </a>
                                &nbsp;&nbsp;
                                @if ($item->status == App\Define\Store::STATUS_WAITING)
                                    <a href="javascript:void(0)" link="{!! route('admin.hub-links-receive', $item->id) !!}" class="btn-confirm-receive btn btn-default btn-xs"><i class="text-info fa fa-play-circle-o"></i>
                                    </a>
                                @elseif ($item->status == App\Define\Store::STATUS_PROCESSING)
                                    <a href="javascript:void(0)" link="{!! route('admin.hub-links-cancel', $item->id) !!}" class="btn-confirm-cancel btn btn-default btn-xs"><i class="text-danger fa fa-stop-circle-o"></i>
                                    </a>
                                @elseif ($item->status == App\Define\Store::STATUS_COMPLETED)
                                    <a href="{!! route('admin.news.show', $item->ref_id) !!}" class="btn btn-default btn-xs" target="_blank">&nbsp;<i class="text-success fa fa-step-forward"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    @else
    <div class="alert alert-warning" style="margin-top: 20px;"> Bạn chưa có dữ liệu để thực hiện, vui lòng gửi tin nhắn cho chúng tôi!</div>
    @endif
</section>
@stop
@section('footer')
<div id="confirm-modal-receive" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Xác nhận </h4>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn sẽ nhận biên dịch bài này?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;"> {!! trans('system.confirm_no') !!} </button>
                <form action="" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="submit" class="btn btn-danger" id="confirm-receive"> {!! trans('system.action.ok') !!} </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="confirm-modal-cancel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Xác nhận </h4>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn việc huỷ bỏ biên dịch bài này?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;"> {!! trans('system.confirm_no') !!} </button>
                <form action="" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="hidden" name="_method" value="PUT">
                    <button type="submit" class="btn btn-danger" id="confirm-cancel"> {!! trans('system.action.ok') !!} </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{!! asset('assets/backend/plugins/daterangepicker/moment.min.js') !!}"></script>
<script src="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<script>
    !function ($) {
        $(function() {
            $('body').on('click', function (e) {
                //did not click a popover toggle or popover
                if ($(e.target).data('toggle') !== 'popover'
                    && $(e.target).parents('.popover.in').length === 0) {
                    $('[data-toggle="popover"]').popover('hide');
                }
            });

            $('.embeded-popover-dismiss').popover({
                placement: 'left'
            });
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
            });
            $(".btn-confirm-receive").click(function(b) {
                var c = $("#confirm-receive").closest("form");
                c.attr('action', $(this).attr("link"));
                b.preventDefault();
                $("#confirm-modal-receive").modal({
                    backdrop: "static",
                    keyboard: !1
                });
            });
            $(".btn-confirm-cancel").click(function(b) {
                var c = $("#confirm-cancel").closest("form");
                c.attr('action', $(this).attr("link"));
                b.preventDefault();
                $("#confirm-modal-cancel").modal({
                    backdrop: "static",
                    keyboard: !1
                });
            });
        });
    }(window.jQuery);
</script>
@stop
