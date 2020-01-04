@extends('backend.master')
@section('title')
{!! trans('system.action.list') !!} {!! trans('feedbacks.label') !!}
@stop
@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker-bs3.css') !!}" />
@stop
@section('content')
<section class="content-header">
    <h1>
        {!! trans('feedbacks.label') !!}
        <small>{!! trans('system.action.list') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
        <li><a href="{!! route('admin.feedbacks.index') !!}">{!! trans('feedbacks.label') !!}</a></li>
    </ol>
</section>
<section class="content overlay">
    <div class="box box-default">
        <div class="box-header with-bfeedback">
            <h3 class="box-title">{!! trans('system.action.filter') !!}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <div class="box-body">
            {!! Form::open([ 'url' => route('admin.feedbacks.index'), 'method' => 'GET', 'role' => 'search' ]) !!}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('fullname_email', trans('feedbacks.fullname')) !!} | {!! Form::label('fullname_email', trans('feedbacks.email')) !!}
                        {!! Form::text('fullname_email', Request::input('fullname_email'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('status', trans('system.status.label')) !!}
                        {!! Form::select('status', [ -1 => trans('system.dropdown_all'), 0 => 'Chưa trả lời', 1 => 'Đã trả lời' ], Request::input('status'), ['class' => 'form-control select2',  "style" => "width: 100%;"])!!}
                    </div>
                </div>
                <div class="col-md-4">
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
                        {!! Form::label('page_num', trans('system.page_num')) !!}
                        {!! Form::select('page_num', [ 10 => '10' . trans('system.items'), 20 => '20' . trans('system.items'), 50 => '50' . trans('system.items') , 100 => '100' . trans('system.items'), 500 => '500' . trans('system.items') ], Request::input('page_num', 20), ['class' => 'form-control select2',  "style" => "width: 100%;"]) !!}
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 text-right">
            {!! $feedbacks->appends( Request::except('page') )->render() !!}
        </div>
    </div>
    @if (count($feedbacks) > 0)
    <?php $labels = ['default', 'success', 'info', 'danger', 'warning']; ?>
    <div class="box">
        <div class="box-header">
            <?php $i = (($feedbacks->currentPage() - 1) * $feedbacks->perPage()) + 1; ?>
            <form class="form-inline">
                <div class="form-group">
                    <span id="counterSelected" class="badge">0</span>
                    <b>{!! trans('system.itemSelected') !!}</b> | {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $feedbacks->count()) . ' ( ' . trans('system.total') . ' ' . $feedbacks->total() . ' )' !!}
                </div>
                <div class="pull-right form-group">
                    <select class="form-control select2" id="action">
                        <option value="noaction"> -- {!! trans('system.action.label') !!} -- </option>
                        <option value="active"> Đã trả lời </option>
                        <option value="deactive"> Chưa trả lời </option>
                        <option value="delete"> {!! trans('system.action.delete') !!} </option>
                    </select>
                    <button type="button" class="btn btn-info btn-flat" onclick="return save()">
                        <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; {!! trans('system.action.save') !!}
                    </button>
                </div>
            </form>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="text-align: center; vertical-align: middle;">{!! Form::checkbox('check_all', 1, 0, [  ]) !!}</th>
                        <th style="text-align: center; vertical-align: middle;">{!! trans('system.no.') !!}</th>
                        <th style="vertical-align: middle;"> {!! trans('feedbacks.fullname') !!} - {!! trans('feedbacks.email') !!}
                         </th>
                        <th style="vertical-align: middle;"> {!! trans('feedbacks.content') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.status.label') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.created_at') !!} <br/>{!! trans('system.updated_at') !!} </th>
                        <th style="text-align: center; vertical-align: middle;"> {!! trans('system.action.label') !!} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $item)
                        <tr>
                            <td style="text-align: center; width: 3%; vertical-align: middle;">
                                {!! Form::checkbox('feedbackId', $item->id, null, array('class' => 'feedbackId')) !!}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                            <td style="vertical-align: middle;">
                                {!! $item->fullname!!}<br/>
                                {!! $item->email!!}<br/>
                                {!! $item->phone !!}
                            </td>
                            <td style="vertical-align: middle;">
                                {!! HTML::link( route('admin.feedbacks.show', $item->id), \App\Helper\HString::modSubstr($item->content, 150), array('class' => '', 'title' => trans('system.action.detail'))) !!}
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                @if($item->status == 0)
                                    <span class="label label-danger">Chưa trả lời</span>
                                @elseif($item->status == 1)
                                    <span class="label label-success">Đã trả lời</span>
                                @endif
                            </td>
                            <td style="text-align: center; vertical-align: middle;">
                                <span class="label label-default">{!! date('d/m/Y H:i', strtotime($item->created_at)) !!}</span><br/>
                                <span class="label label-default">{!! date('d/m/Y H:i', strtotime($item->updated_at)) !!}</span>
                            </td>
                            <td style="text-align: center; vertical-align: middle; white-space:nowrap;">
                                <a href="{!! route('admin.feedbacks.edit', $item->id) !!}" class="text-warning"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.edit') !!} </a>
                                <a style="cursor: pointer;" link="{!! route('admin.feedbacks.destroy', $item->id) !!}" class="btn-confirm-del text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </a>
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
@section('footer')
    <script src="{!! asset('assets/backend/plugins/daterangepicker/moment.min.js') !!}"></script>
    <script src="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker.js') !!}"></script>
    <script src="{!! asset('assets/backend/plugins/input-mask/jquery.inputmask.js') !!}"></script>
    <script src="{!! asset('assets/backend/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}"></script>
    <script>
        !function ($) {
            $(function(){
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
                var countChecked = function() {
                    var length = $( "input[name='feedbackId']:checked" ).length;
                    $( "#counterSelected" ).text( length );
                    if( length == 0 ) $("input[name='check_all']").attr('checked', false);
                };

                countChecked();

                $( "input[type=checkbox][name='feedbackId']" ).on( "click", countChecked );
                $("input[name='check_all']").change(function() {
                    if($(this).is(':checked')) {
                        $('.feedbackId').each(function() {
                            this.checked = true;
                        });
                    } else {
                        $('.feedbackId').each(function() {
                            this.checked = false;
                        });
                    }
                    countChecked();
                });

                $("#action").change(function(event) {
                    if( $(this).val() == 'create_contact' )
                        $("input[name='new_contact']").show();
                    else
                        $("input[name='new_contact']").hide();
                });
            });
        }(window.jQuery);

        function save() {
            if($( "input[name='feedbackId']:checked" ).length == 0) {
                alert("{!! trans('system.no_item_selected') !!}");
                return false;
            }
            if($('#action').val() == 'noaction') {
                alert("{!! trans('system.no_action_selected') !!}");
                return false;
            }

            box1 = new ajaxLoader('body', {classOveride: 'blue-loader', bgColor: '#000', opacity: '0.3'});

            var values = new Array();

            $.each($("input[name='feedbackId']:checked"),
                function () {
                    values.push($(this).val());
                });

            $.ajax({
                url: "{!! route('admin.feedbacks.update-bulk') !!}",
                data: { action: $('#action').val(), ids: JSON.stringify(values) },
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