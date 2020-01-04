@extends('backend.master')
@section('title')
    {!! $news->title !!} | {!! trans('system.action.detail') !!} - {!! trans('news.label') !!}
@stop
@section('head')
    <style type="text/css">
        @if(!$comments->count())
            .chat-body {
                height: 50px;
            }
        @elseif($comments->count()>=5)
            .direct-chat-messages {
                min-height: 350px;
            }
        @endif
    </style>
@stop
@section('content')
    <?php $user = \App\User::find($news->created_by); ?>
    <section class="content-header">
        <h1>
            {!! trans('news.label') !!}
            <small>{!! trans('system.action.detail') !!}</small>
            @if($news->status)
                <label class="label label-success">
                    {!! trans('system.status.active') !!}
                </label>
            @else
                <label class="label label-default">
                    {!! trans('system.status.waiting_approve') !!}
                </label>
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
            <li><a href="{!! route('admin.news.index') !!}">{!! trans('news.label') !!}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success direct-chat direct-chat-success">
                    <?php $i = 1; ?>
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            {!! trans('news.comment') !!}
                        </h3>
                        | {!! trans('system.show_from') !!} {!! $i . ' ' . trans('system.to') . ' ' . ($i - 1 + $comments->count()) . ' ( ' . trans('system.total') . ' ' . $comments->count() . ' )' !!}
                        | <i>Chú giải: </i>&nbsp;&nbsp;
                        <span class="text-success"><i class="fa fa-thumbs-o-up"></i> {!! trans('news.approve') !!} </span>&nbsp;&nbsp;
                        <span class="text-default"><i class="fa fa-thumbs-o-down"></i> {!! trans('news.disapprove') !!} </span>&nbsp;&nbsp;
                        <span class="text-danger"><i class="fa fa-trash"></i> {!! trans('system.action.delete') !!} </span>
                        <div class="box-tools pull-right">
                            <span data-toggle="tooltip" title="" class="badge bg-green">{!! $comments->count() !!}</span>
                        </div>
                    </div>
                    <div class="box-body chat-body">
                        <div class="direct-chat-messages">
                            @if (count($comments) > 0)
                                <div class="box">
                                    <div class="box-header with-border">

                                    </div>
                                    <div class="box-body no-padding">
                                        <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; vertical-align: middle;"> {!! trans('system.no.') !!} </th>
                                                    <th style="vertical-align: middle;">
                                                        {!! trans('feedbacks.fullname') !!}<br/>
                                                        {!! trans('feedbacks.phone') !!} - {!! trans('feedbacks.email') !!}
                                                    </th>
                                                    <th style="vertical-align: middle; white-space:nowrap;"> {!! trans('feedbacks.content') !!} </th>
                                                    <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.status.label') !!} </th>
                                                    <th style="text-align: center; vertical-align: middle; white-space:nowrap;">
                                                        {!! trans('system.created_at') !!} <br/>
                                                        {!! trans('system.updated_at') !!}
                                                    </th>
                                                    <th style="text-align: center; vertical-align: middle; white-space:nowrap;"> {!! trans('system.action.label') !!} </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($comments as $item)
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;">{!! $i++ !!}</td>
                                                    <td style="vertical-align: middle;">
                                                        {!! $item->fullname !!} <br/>
                                                        {!! $item->phone !!} - {!! $item->email !!}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {!! $item->content !!}
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        @if($item->status == 0)
                                                        <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                                                        @elseif($item->status == 1)
                                                        <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        <span class="label label-default">
                                                            {!! date("d/m/Y H:i", strtotime($item->created_at)) !!}<br/>
                                                            {!! date("d/m/Y H:i", strtotime($item->updated_at)) !!}
                                                        </span>
                                                    </td>
                                                    <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                                                        @if ($item->status == 1)
                                                            <a href="javascript:void(0)" link="{!! route('admin.comments.disapprove', ['id' => $news->id, 'commentId' => $item->id]) !!}" class="btn-confirm-disapprove btn btn-default btn-xs"><i class="text-default fa fa-thumbs-o-down"></i>
                                                            </a>
                                                        @elseif ($item->status == 0)
                                                            <a href="javascript:void(0)" link="{!! route('admin.comments.approve', ['id' => $news->id, 'commentId' => $item->id]) !!}" class="btn-confirm-approve btn btn-default btn-xs"><i class="text-success fa fa-thumbs-o-up"></i>
                                                            </a>
                                                        @endif
                                                        <a href="javascript:void(0)" link="{!! route('admin.comments.delete', ['id' => $news->id, 'commentId' => $item->id]) !!}" class="btn btn-default btn-xs btn-confirm-del"><i class="text-danger fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="alert alert-warning" style="margin-top: 20px;"> Chưa có bình luận nào!</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            {!! $news->title !!}
                        </h3>
                        <div class="box-tools pull-right">
                            <span data-toggle="tooltip" title="" class="badge bg-green">
                                {!!$news->category()->first()->name !!}
                            </span>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class='table table-striped table-bordered'>
                            <tr>
                                <td colspan="2">
                                    {!! $news->summary !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{!! asset('assets/media/images/news/' . $news->image) !!}" height="150px">
                                </td>
                                <td>
                                    {!! $news->ref !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer">
                        <span class="fa fa-user text-info"></span>
                        @if($user->hasRole(['system', 'admin']))
                            <a href="{!! route('admin.news.index') !!}?creator={!! $news->created_by !!}" class="small-box-footer">
                                {!! is_null( $user ) ? '-' : $user->fullname !!}&nbsp;&nbsp;&nbsp;
                            </a>
                        @else
                            {!! is_null( $user ) ? '-' : $user->fullname !!}
                        @endif
                        @if($news->featured)
                            <label class="label label-success">{!! trans('news.featured') !!}</label>&nbsp;&nbsp;&nbsp;
                        @endif
                        <span class="fa fa-clock-o"></span> {!! date("d/m/Y H:i", strtotime($news->created_at)) !!}&nbsp;&nbsp;&nbsp;
                        <span class="fa fa-edit"></span> {!! date("d/m/Y H:i", strtotime($news->updated_at)) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">
                        {!! $news->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer')
<div id="confirm-modal-approve" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Xác nhận </h4>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn HIỂN THỊ bình luận này?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;"> {!! trans('system.confirm_no') !!} </button>
                <form action="" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="hidden" name="_method" value="PUT">
                    <button type="submit" class="btn btn-danger" id="confirm-approve"> {!! trans('system.action.ok') !!} </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="confirm-modal-disapprove" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Xác nhận </h4>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn ẨN bình luận này?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;"> {!! trans('system.confirm_no') !!} </button>
                <form action="" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input type="hidden" name="_method" value="PUT">
                    <button type="submit" class="btn btn-danger" id="confirm-disapprove"> {!! trans('system.action.ok') !!} </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    !function ($) {
        $(function() {
            $(".btn-confirm-approve").click(function(b) {
                var c = $("#confirm-approve").closest("form");
                c.attr('action', $(this).attr("link"));
                b.preventDefault();
                $("#confirm-modal-approve").modal({
                    backdrop: "static",
                    keyboard: !1
                });
            });
            $(".btn-confirm-disapprove").click(function(b) {
                var c = $("#confirm-disapprove").closest("form");
                c.attr('action', $(this).attr("link"));
                b.preventDefault();
                $("#confirm-modal-disapprove").modal({
                    backdrop: "static",
                    keyboard: !1
                });
            });
        });
    }(window.jQuery);
</script>
@stop