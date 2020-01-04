@extends('backend.master')
@section('title')
    {!! trans('system.action.detail') !!} {!! trans('users.label') !!}
@stop
@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop
@section('content')
    <section class="content-header">
        <h1>
            {!! trans('users.label') !!}
            <small>{!! trans('system.action.detail') !!}</small>
            @if($user->activated)
                <label class="label label-success">{!! trans('system.status.active') !!}</label>
            @else
                <label class="label label-danger">{!! trans('system.status.deactive') !!}</label>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.users.index') !!}">{!! trans('users.label') !!}</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="table-responsive">
            <table class='table borderless'>
                <tr>
                    <th class="text-right" style="width: 15%;">
                        {!! trans('users.fullname') !!}
                    </th>
                    <td style="width: 35%;">
                        {!! $user->fullname !!}
                    </td>
                    <th class="text-right" style="width: 15%;">
                        {!! trans('users.email') !!}
                    </th>
                    <td>
                        {!! $user->email !!}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">
                        {!! trans('users.phone') !!}
                    </th>
                    <td>
                        {!! $user->phone !!}
                    </td>
                    <th class="text-right">
                        {!! trans('users.last_login') !!}
                    </th>
                    <td>
                        {!! date("d/m/Y H:i", strtotime($user->last_login)) !!}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">
                        {!! trans('users.info') !!}
                    </th>
                    <td colspan="3">
                        {!! $user->info !!}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">
                        {!! trans('system.created_at') !!}
                    </th>
                    <td>
                        {!! date("d/m/Y H:i", strtotime($user->created_at)) !!}
                    </td>
                    <th class="text-right">
                        {!! trans('system.updated_at') !!}
                    </th>
                    <td>
                        {!! date("d/m/Y H:i", strtotime($user->updated_at)) !!}
                    </td>
                </tr>
            </table>
        </div>
        <div class="box box-info">
            <div class="box-body">
                {!! Form::label('role', trans('users.roles') ) !!}
                <div class="row">
                    <?php $labels = ['success', 'info', 'danger', 'warning', 'default']; ?>
                    @foreach($user->roles()->get() as $role)
                        <div class="col-md-3">
                            <span class="label label-{!! $labels[ $role->id % 5 ] !!}">{!! $role->display_name !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@stop