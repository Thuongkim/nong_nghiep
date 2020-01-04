@extends('backend.master')

@section('title')
    {!! $store->title !!} | {!! trans('system.action.detail') !!} - {!! trans('stores.label') !!}
@stop

@section('content')
    <?php $user = \App\User::find($store->created_by); ?>
    <section class="content-header">
        <h1>
            {!! trans('stores.label') !!}
            <small>{!! trans('system.action.detail') !!}</small>
            <label class="label label-{!! App\Define\Store::getLabelStatus($store->status) !!}">{!! trans('stores.status.' . $store->status) !!}</label>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.stores.index') !!}">{!! trans('stores.label') !!}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            {!! $store->name !!}
                        </h3>
                        <div class="box-tools pull-right">
                            <span data-toggle="tooltip" title="" class="badge bg-green">
                                {!! $user->fullname !!}
                            </span>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class='table table-striped table-bordered'>
                            <tr>
                                <td>
                                    {!! trans('stores.link') !!}
                                </td>
                                <td>
                                    {!! $store->link !!} <a href="{!! $store->link !!}" target="_blank"><span class="fa fa-external-link"></span></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! trans('stores.note') !!}
                                </td>
                                <td>
                                    {!! $store->note !!}
                                </td>
                            </tr>
                            @if($store->assigned_to)
                                <tr>
                                    <td>
                                        Người nhận
                                    </td>
                                    <td>
                                        <?php $assigner = App\User::find($store->assigned_to); ?>
                                        <a href="{!! route('admin.users.show', $store->assigned_to) !!}" class="small-box-footer">
                                            {!! $assigner->fullname !!}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Nhận lúc
                                    </td>
                                    <td>
                                        {!! date("d/m/Y H:i", strtotime($store->assigned_at)) !!}
                                    </td>
                                </tr>
                            @endif
                            @if($store->sent_at)
                                <tr>
                                    <td>
                                        Gửi bài lúc
                                    </td>
                                    <td>
                                        {!! date("d/m/Y H:i", strtotime($store->sent_at)) !!} <a href="{!! route('admin.news.show', $store->ref_id) !!}" target="_blank"><span class="fa fa-external-link"></span></a>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="box-footer">
                        <span class="fa fa-clock-o"></span> {!! date("d/m/Y H:i", strtotime($store->created_at)) !!}&nbsp;&nbsp;&nbsp;
                        <span class="fa fa-edit"></span> {!! date("d/m/Y H:i", strtotime($store->updated_at)) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop