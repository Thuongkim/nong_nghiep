@extends('backend.master')

@section('title')
    {!! trans('system.action.edit') !!} - {!! trans('feedbacks.label') !!}
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/iCheck/all.css') !!}" />
@stop

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('feedbacks.label') !!}
            <small>{!! trans('system.action.edit') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.feedbacks.index') !!}">{!! trans('feedbacks.label') !!}</a></li>
        </ol>
    </section>
    @if($errors->count())
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> {!! trans('messages.error') !!}</h4>
            <ul>
                @foreach($errors->all() as $message)
                <li>{!! $message !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('url' => route('admin.feedbacks.update', $feedback->id), 'method' => 'PUT', 'role' => 'form')) !!}
        <table class='table bfeedbackless'>
            <tr>
                <th class="table_right_middle">
                    {!! trans('feedbacks.fullname') !!}
                </th>
                <td>
                    {!! Form::text('fullname', old('fullname', $feedback->fullname), array('class' => 'form-control', 'maxlength' => 100, 'required')) !!}
                </td>
                <th class="table_right_middle">
                    {!! trans('feedbacks.email') !!}
                </th>
                <td colspan="3">
                    {!! Form::text('email', old('email', $feedback->email), array('class' => 'form-control', 'maxlength' => 100, 'required')) !!}
                </td>
            </tr>
            <tr>
                <th class="table_right_middle">
                    {!! trans('feedbacks.phone') !!}
                </th>
                <td>
                    {!! Form::text('phone', old('phone', $feedback->phone), array('class' => 'form-control', 'maxlength' => 15)) !!}
                </td>
            </tr>
            <tr>
                <th class="text-right">
                    {!! trans('feedbacks.content') !!}
                </th>
                <td colspan="3">
                    {!! Form::textarea('content', old('content', $feedback->content), array('class' => 'form-control', 'rows' => 5)) !!}
                </td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">
                    <label>
                        {!! Form::checkbox('status', 1, old('status', $feedback->status), [ 'class' => 'minimal' ]) !!}
                        Đã xử lý
                    </label>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">
                    {!! HTML::link(route( 'admin.feedbacks.index' ), trans('system.action.cancel'), array('class' => 'btn btn-danger btn-flat'))!!}
                    {!! Form::submit(trans('system.action.save'), array('class' => 'btn btn-primary btn-flat')) !!}
                </td>
            </tr>
        </table>
    {!! Form::close() !!}
@stop
@section('footer')
    <script src="{!! asset('assets/backend/plugins/iCheck/icheck.min.js') !!}"></script>
    <script>
        !function ($) {
            $(function() {
                $('input[type="checkbox"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue'
                });

                $('input[type="checkbox"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red'
                });
            });
        }(window.jQuery);
    </script>
@stop