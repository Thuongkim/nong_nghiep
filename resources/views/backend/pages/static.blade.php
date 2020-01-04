@extends('backend.master')
@section('title')
{!! $page->title !!}
@stop
@section('content')
<section class="content-header">
    <h1>
            <small>Hôm nay {!! date('d/m/Y', strtotime('now')) !!}</small>
        </h1>
    <ol class="breadcrumb">
        <li><a href="{!! route('admin.home') !!}">{!! trans('system.home') !!}</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{!! $page->title !!}</h3>
                </div>
                <div class="box-body">
                    {!! $page->description !!}
                </div>
                <div class="box-footer">
                    {!! trans('system.updated_at') !!} {!! date("d/m/Y H:i", strtotime($page->updated_at)) !!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop