@extends('backend.master')

@section('title')
    {!! trans('system.action.list') !!} {!! trans('roles.label') !!}
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('roles.label') !!}
            <small>{!! trans('system.action.list') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.roles.index') !!}">{!! trans('roles.label') !!}</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                @permission('roles.create')
                    <a href="{!! route('admin.roles.create') !!}" class='btn btn-primary btn-flat'>
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('system.action.create') !!}
                    </a>
                @endpermission
            </div>
            <div class="col-md-10">
                <span  style='float: right;'>
                    {!! $roles->appends( Request::except('page') )->render() !!}
                </span>
            </div>
        </div>
        @if (count($roles) > 0)
            <div class="box">
                <?php $i = (($roles->currentPage() - 1) * $roles->perPage()) + 1; ?>
                <div class="box-body no-padding">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle;">{!! trans('system.no.') !!}</th>
                                <th style="text-align: center; vertical-align: middle;"> {!! trans('roles.display_name') !!} </th>
                                <th style="text-align: center; vertical-align: middle;">{!! trans('roles.number_of_user') !!}</th>
                                <th style="text-align: center; vertical-align: middle;"> {!! trans('roles.description') !!} </th>
                                @permission('roles.update','roles.delete')
                                <th style="text-align: center; vertical-align: middle;"> {!! trans('system.action.label') !!} </th>
                                @endpermission
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a href="{!! route('admin.roles.show', $role->id) !!}" title="{!! trans('system.action.detail') !!}">
                                        {!! $role->display_name !!}
                                    </a>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    {!! $role->users()->count() !!}
                                </td>
                                <td>{!! $role->description !!}</td>
                                @permission('roles.update','roles.delete')
                                    @if($role->name <> 'System')
                                        <td style="text-align: center; vertical-align: middle;">
                                            @permission('roles.update')
                                            <a class="text-warning" href="{!! route('admin.roles.edit',$role->id) !!}"><i class="glyphicon glyphicon-edit"></i> {!! trans('system.action.edit') !!} </a>
                                            @endpermission
                                            @permission('roles.delete')
                                                <a style="cursor: pointer;" link="{!! route('admin.roles.destroy', $role->id) !!}" class="btn-confirm-del text-danger"><i class="glyphicon glyphicon-remove"></i> {!! trans('system.action.delete') !!} </a>
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
        @else
            <div class="alert alert-info" style="margin-top: 20px;"> {!! trans('system.no_record_found') !!}</div>
        @endif
    </section><!-- /.content -->
@stop