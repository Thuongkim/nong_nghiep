@extends('backend.master')

@section('title')
    {!! trans('system.action.list') !!} {!! trans('users.label') !!}
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('users.label') !!}
            <small>{!! trans('system.action.list') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.users.index') !!}">{!! trans('users.label') !!}</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                @permission('users.create')
                    <a href="{!! route('admin.users.create') !!}" class='btn btn-primary btn-flat'>
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('system.action.create') !!}
                    </a>
                @endpermission
            </div>
            <div class="col-md-10">
                <span  style='float: right;'>
                    {!! $users->appends( Request::except('page') )->render() !!}
                </span>
            </div>
        </div>
        @if (count($users) > 0)
            <div class="box">
                <?php $i = (($users->currentPage() - 1) * $users->perPage()) + 1; ?>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">{!! trans('system.no.') !!}</th>
                                    <th style="vertical-align: middle;"> {!! trans('users.fullname') !!} </th>
                                    <th style="vertical-align: middle;"> {!! trans('users.email') !!} </th>
                                    <th style="text-align: center; vertical-align: middle;">{!! trans('users.role') !!}</th>
                                    <th style="text-align: center; vertical-align: middle;">{!! trans('users.last_login') !!}</th>
                                    <th style="text-align: center; vertical-align: middle;">{!! trans('system.status.label') !!}</th>
                                    @permission('users.update','users.delete')
                                    <th style="text-align: center; vertical-align: middle;"> {!! trans('system.action.label') !!} </th>
                                    @endpermission
                                </tr>
                            </thead>
                            <tbody>
                                <?php $labels = ['success', 'info', 'danger', 'warning', 'default']; ?>
                                @foreach ($users as $user)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                                    <td style="vertical-align: middle;">
                                        <a href="{!! route('admin.users.show', $user->id) !!}" title="{!! trans('system.action.detail') !!}">
                                            {!! $user->fullname !!}
                                        </a>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {!! $user->email !!}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        @foreach($user->roles()->get() as $role)
                                            <span class="label label-{!! $labels[ $role->id % 5 ] !!}">{!! $role->display_name !!}</span>
                                        @endforeach
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        {!! date("d/m/Y H:i", strtotime($user->last_login)) !!}
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if($user->activated == 0)
                                        <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                        @elseif($user->activated == 1)
                                        <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                        @endif
                                    </td>
                                    @permission('users.update','users.delete')
                                        @if($user->id <> \Auth::guard('admin')->user()->id)
                                            <td style="text-align: center; vertical-align: middle;">
                                                @permission('users.update')
                                                <a class="text-info" href="{!! route('admin.users.update_password',$user->id) !!}"><i class="fa fa-key"></i> {!! trans('users.changepwd') !!} </a>

                                                <a class="text-warning" href="{!! route('admin.users.edit',$user->id) !!}"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.edit') !!} </a>
                                                @endpermission
                                                @permission('users.delete')
                                                <a style="cursor: pointer;" link="{!! route('admin.users.destroy', $user->id) !!}" class="btn-confirm-del text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </a>
                                                @endpermission
                                            </td>
                                        @endif
                                    @endpermission
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info" style="margin-top: 20px;"> {!! trans('system.no_record_found') !!}</div>
        @endif
    </section><!-- /.content -->
@stop