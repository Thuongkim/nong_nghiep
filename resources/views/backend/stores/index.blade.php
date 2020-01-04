@extends('backend.master')
@section('title')
{!! trans('system.action.list') !!} {!! trans('stores.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/daterangepicker/daterangepicker-bs3.css') !!}" />
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/select2/select2.min.css') !!}" />
@stop

@section('content')
<section class="content-header">
    <h1>
        {!! trans('stores.label') !!}
        <small>{!! trans('system.action.list') !!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
        <li><a href="{!! route('admin.stores.index') !!}">{!! trans('stores.label') !!}</a></li>
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
            {!! Form::open(array('url' =>route('admin.stores.index') , 'role'=>'search', 'method' => 'GET')) !!}
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
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('creator', trans('system.administrator')) !!}
                        {!! Form::select('creator', ['' => trans('system.dropdown_all')] + $creators, Request::input('creator'), ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('role', trans('roles.label')) !!}
                        {!! Form::select('role', ['' => trans('system.dropdown_all')] + $roles, Request::input('role'), ["class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('status', trans('system.status.label')) !!}
                        {!! Form::select('status', [-1 => trans('system.dropdown_all')] + App\Define\Store::getAllStatusForOptions(), Request::input('status'), ['class' => 'form-control'])!!}
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
        <div class="col-md-2" style='float: left;'>
            <a href="{!! route('admin.stores.create') !!}" class='btn btn-primary btn-flat'>
                <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('system.action.create') !!}
            </a>
        </div>
        <div class="col-md-10">
            <span  style='float: right;'>
                {!! $stores->appends( Request::except('page') )->render() !!}
            </span>
        </div>
    </div>
    <?php $i = (($stores->currentPage() - 1) * $stores->perPage()) + 1; ?>
    @if (count($stores) > 0)
        <div class="well">
            <form class="form-inline">
                <div class="form-group">
                    <span id="counterSelected" class="badge">0</span>
                    {{ trans('system.itemSelected') }} | {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $stores->count()) . ' ( ' . trans('system.total') . ' ' . $stores->total() . ' )' !!}
                    | <i>Chú giải: </i>&nbsp;&nbsp;
                    <span class="text-warning"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.update') !!} </span>&nbsp;&nbsp;
                    <span class="text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </span>
                </div>
                <div class="pull-right form-group">
                    <select class="form-control" id="action">
                        <option value="noaction"> -- {{ trans('system.action.label') }} -- </option>
                        <option value="{!! App\Define\Store::STATUS_WAITING !!}"> {{ trans('stores.status.' . App\Define\Store::STATUS_WAITING) }} </option>
                        <option value="{!! App\Define\Store::STATUS_CANCELED !!}"> {{ trans('stores.status.' . App\Define\Store::STATUS_CANCELED) }} </option>
                        <option value="delete"> {{ trans('system.action.delete') }} </option>
                    </select>
                    <button type="button" class="btn btn-info" onclick="return save()">
                        <span class="glyphicon glyphicon-floppy-disk"></span>&nbsp; {{ trans('system.action.save') }}
                    </button>
                </div>
            </form>
        </div>
    <div class="box">
        <div class="box-header with-border">
            {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $stores->count()) . ' ( ' . trans('system.total') . ' ' . $stores->total() . ' )' !!}
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
                        <th style="vertical-align: middle;"> {!! trans('stores.name') !!} </th>
                        <th style="vertical-align: middle;">
                            Thông Tin CTV <br/>
                            Tgian nhận bài <br/>
                            Tgian gửi bài
                        </th>
                        <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.status.label') !!} </th>
                        <th style="vertical-align: middle; white-space:nowrap;"> {!! trans('system.created_by') !!} </th>
                        <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.action.label') !!} </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $labels = ['success', 'info', 'danger', 'warning', 'default']; ?>
                    @foreach ($stores as $item)
                    <tr>
                        <td style="text-align: center; width: 3%; vertical-align: middle;">
                            {!! Form::checkbox('storeId', $item->id, null, array('class' => 'storeId')) !!}
                        </td>
                        <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                        <td style="vertical-align: middle;">
                            <a href="{!! route('admin.stores.show', $item->id) !!}">
                                {!! $item->name !!}
                            </a>
                        </td>
                        <td style="vertical-align: middle;">
                            <?php $ctv = App\User::find($item->assigned_to); ?>
                            @if (is_null($ctv))
                                -
                            @else
                                <a href="{!! route('admin.users.show', $ctv->id) !!}" target="_blank"><span class="label-default label">{!! $ctv->fullname !!}</span></a><br/>
                                <span class="label label-info"> <i class="fa fa-clock-o"></i> {!! date("d/m/Y H:i", strtotime($item->assigned_at)) !!}</span>
                                @if ($item->sent_at)
                                    <br/><span class="label label-success"> <i class="fa fa-clock-o"></i> {!! date("d/m/Y H:i", strtotime($item->sent_at)) !!}</span>
                                @endif
                            @endif
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <span class="label label-{!! App\Define\Store::getLabelStatus($item->status) !!}">{!! trans('stores.status.' . $item->status) !!}</span>
                        </td>
                        <td style="vertical-align: middle;">
                            <?php $user = \App\User::find($item->created_by); ?>
                            <a href="{!! route('admin.stores.index') !!}?creator={!! $user->id !!}">
                                <span class="label-default label"> {!! is_null($user) ? '-' : $user->fullname !!}</span>
                            </a>
                            <br/>
                            <span class="label label-default"> <i class="fa fa-clock-o"></i> {!! date("d/m/Y H:i", strtotime($item->updated_at)) !!}</span>
                        </td>
                        <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                            <a href="{!! route('admin.stores.edit', $item->id) !!}" class="btn btn-default btn-xs"><i class="text-warning fa fa-edit"></i> </a>
                            &nbsp;&nbsp;
                            <a href="javascript:void (0)" link="{!! route('admin.stores.destroy', $item->id) !!}" class="btn-confirm-del btn btn-default btn-xs"><i class="text-danger glyphicon glyphicon-remove"></i>
                            </a>
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
                $( "#counterSelected" ).text( $( "input[name='storeId']:checked" ).length );
            };
            countChecked();
            $( "input[type=checkbox][name='storeId']" ).on( "click", countChecked );

            $("input[name='check_all']").change(function() {
                if($(this).is(':checked')) {
                    $('.storeId').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.storeId').each(function() {
                        this.checked = false;
                    });
                }
                countChecked();
            });

            $("select[name='creator']").select2();
        });
    }(window.jQuery);

    function save() {
        if($( "input[name='storeId']:checked" ).length == 0) {
            alert("{!! trans('system.no_item_selected') !!}");
            return false;
        }
        if($('#action').val() == 'noaction') {
            alert("{!! trans('system.no_action_selected') !!}");
            return false;
        }

        box1 = new ajaxLoader('body', {classOveride: 'blue-loader', bgColor: '#000', opacity: '0.3'});

        var values = new Array();

        $.each($("input[name='storeId']:checked"),
            function () {
                values.push($(this).val());
            });

        $.ajax({
            url: "{!! URL::route('admin.stores.updateBulk') !!}",
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