@extends('backend.master')

@section('title')
    {!! trans('system.action.detail') !!} - {!! trans('feedbacks.label') !!}
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('feedbacks.label') !!}
            <small>{!! trans('system.action.detail') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.feedbacks.index') !!}">{!! trans('feedbacks.label') !!}</a></li>
        </ol>
    </section>
    <?php $labels = ['default', 'success', 'info', 'danger', 'warning']; ?>
    <div class="box">
        <table class='table table-borderless'>
            <tr>
                <th class="table_right_middle" style="width: 15%;">
                    {!! trans('feedbacks.fullname') !!}
                </th>
                <td style="width: 35%;">
                    {!! $feedback->fullname !!}
                </td>
                <th class="table_right_middle" style="width: 15%;">
                    {!! trans('feedbacks.email') !!}
                </th>
                <td>
                    {!! $feedback->email !!}
                </td>
            </tr>
            <tr>
                <th class="table_right_middle">
                    {!! trans('feedbacks.phone') !!}
                </th>
                <td>
                    {!! $feedback->phone !!}
                </td>
            </tr>
            <tr>
                <th class="table_right_middle">
                    {!! trans('feedbacks.content') !!}
                </th>
                <td colspan="3">
                    {!! $feedback->content !!}
                </td>
            </tr>
            <tr>
                <th class="table_right_middle">
                    {!! trans('system.status.label') !!}
                </th>
                <td>
                    @if($feedback->status == 0)
                        <span class="label label-danger">Chưa trả lời</span>
                    @elseif($feedback->status == 1)
                        <span class="label label-success">Đã trả lời</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table_right_middle">
                    {!! trans('system.created_at') !!}
                </th>
                <td>
                    {!! date("d-m-Y", strtotime($feedback->updated_at)) !!}
                </td>
                <th class="table_right_middle">
                    {!! trans('system.updated_at') !!}
                </th>
                <td>
                    {!! date("d-m-Y", strtotime($feedback->updated_at)) !!}
                </td>
            </tr>
        </table>
    </div>
@stop