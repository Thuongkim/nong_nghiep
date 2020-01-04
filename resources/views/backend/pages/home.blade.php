@extends('backend.master')
@section('title')
    Trang chủ
@stop

@section('head')
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/backend/plugins/morris/morris.css') !!}" />
@stop

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>Hôm nay {!! date('d/m/Y', strtotime('now')) !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! route('admin.home') !!}"><i class="fa fa-home"></i> Trang chủ</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if(Request::user()->ability(['admin', 'system'], []))
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-newspaper-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng số tin</span>
                            <span class="info-box-number">{!! App\Helper\HString::currencyFormat($countNews) !!} bài</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Đã xuất bản</span>
                            <span class="info-box-number">{!! App\Helper\HString::currencyFormat($countPublishedNews) !!} bài</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tháng {!! date('m', strtotime('now')) !!}</span>
                            <span class="info-box-number">{!! App\Helper\HString::currencyFormat($countThisMonthNews) !!} bài</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Đã xuất bản</span>
                            <span class="info-box-number">{!! App\Helper\HString::currencyFormat($countThisMonthPublishedNews) !!} bài</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Thống kê bài viết theo người dùng</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ tên</th>
                                        <th>Tổng số bài gửi</th>
                                        <th>Số bài được xuất bản</th>
                                        <th>Tỉ lệ</th>
                                        <th></th>
                                    </tr>
                                    <?php $i = 1; ?>
                                    @foreach($countNewsByUser as $id => $user)
                                        <?php $u = \App\User::find($id); $published = isset($countPublishedNewsByUser[$id]) ? $countPublishedNewsByUser[$id]['counter'] : 0; ?>
                                        <tr>
                                            <td>{!! $i++ !!}</td>
                                            <td>{!! is_null( $u ) ? '-' : $u->fullname !!}</td>
                                            <td>{!! App\Helper\HString::currencyFormat($user['counter']) !!}</td>
                                            <td>{!! App\Helper\HString::currencyFormat($published) !!}</td>
                                            <?php $published = 100*number_format($published/$user['counter'], 2); ?>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar progress-bar-success" style="width: {!! $published !!}%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-green">{!! $published !!}%</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bài viết của bạn</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3>{!! App\Helper\HString::currencyFormat($myPostedToday) !!}</h3>
                                        <p>Bài mới hôm nay</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="{!! route('admin.news.index') !!}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div><!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3>{!! App\Helper\HString::currencyFormat($myPublishedToday) !!}</h3>
                                        <p>Bài xuất bản hôm nay</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="{!! route('admin.news.index') !!}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div><!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3>{!! App\Helper\HString::currencyFormat($myPostedThisMonth) !!}</h3>
                                        <p>Bài mới trong tháng </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="{!! route('admin.news.index') !!}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div><!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3>{!! App\Helper\HString::currencyFormat($myPublishedThisMonth) !!}</h3>
                                        <p>Bài xuất bản trong tháng</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="{!! route('admin.news.index') !!}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div><!-- ./col -->
                        </div><!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    @if ($myPostedYesterday > $myPostedToday)
                                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> {!! App\Helper\HString::decimalFormat(100* ($myPostedYesterday-$myPostedToday)/(!$myPostedToday ? 1: $myPostedToday)) !!}%</span>
                                    @elseif($myPostedYesterday < $myPostedToday)
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> {!! App\Helper\HString::decimalFormat(100* ($myPostedToday-$myPostedYesterday)/(!$myPostedYesterday ? 1: $myPostedYesterday)) !!}%</span>
                                    @else
                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> {!! $myPostedYesterday ? 100 : 0 !!}%</span>
                                    @endif
                                    <h5 class="description-header">{!! App\Helper\HString::currencyFormat($myPostedYesterday) !!}</h5>
                                    <span class="description-text">Hôm qua</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    @if ($myPublishedYesterday > $myPublishedToday)
                                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> {!! App\Helper\HString::decimalFormat(100* ($myPublishedYesterday-$myPublishedToday)/(!$myPublishedToday ? 1: $myPublishedToday)) !!}%</span>
                                    @elseif($myPublishedYesterday < $myPublishedToday)
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> {!! App\Helper\HString::decimalFormat(100* ($myPublishedToday-$myPublishedYesterday)/(!$myPublishedYesterday ? 1: $myPublishedYesterday)) !!}%</span>
                                    @else
                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> {!! $myPublishedYesterday ? 100 : 0 !!}%</span>
                                    @endif
                                        <h5 class="description-header">{!! App\Helper\HString::currencyFormat($myPublishedYesterday) !!}</h5>
                                    <span class="description-text">Hôm qua</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    @if ($myPostedLastMonth > $myPostedThisMonth)
                                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> {!! App\Helper\HString::decimalFormat(100* ($myPostedLastMonth-$myPostedThisMonth)/(!$myPostedThisMonth ? 1: $myPostedThisMonth)) !!}%</span>
                                    @elseif($myPostedLastMonth < $myPostedThisMonth)
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> {!! App\Helper\HString::decimalFormat(100* ($myPostedThisMonth-$myPostedLastMonth)/(!$myPostedLastMonth ? 1: $myPostedLastMonth)) !!}%</span>
                                    @else
                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> {!! $myPostedLastMonth ? 100 : 0 !!}%</span>
                                    @endif

                                    <h5 class="description-header">{!! App\Helper\HString::currencyFormat($myPostedLastMonth) !!}</h5>
                                    <span class="description-text">Tháng trước</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                    @if ($myPublishedLastMonth > $myPublishedThisMonth)
                                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> {!! App\Helper\HString::decimalFormat(100* ($myPublishedLastMonth-$myPublishedThisMonth)/(!$myPublishedThisMonth ? 1: $myPublishedThisMonth)) !!}%</span>
                                    @elseif($myPublishedLastMonth < $myPublishedThisMonth)
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> {!! App\Helper\HString::decimalFormat(100* ($myPublishedThisMonth-$myPublishedLastMonth)/(!$myPublishedLastMonth ? 1: $myPublishedLastMonth)) !!}%</span>
                                    @else
                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> {!! $myPublishedLastMonth ? 100 : 0 !!}%</span>
                                    @endif
                                    <h5 class="description-header">{!! App\Helper\HString::currencyFormat($myPublishedLastMonth) !!}</h5>
                                    <span class="description-text">Tháng trước</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Biểu đồ bạn tạo mới và xuất bản các bài viết của bạn trong tháng {!! date('m/Y') !!}</h3>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="news-statistic-chart" style="height: 300px;"></div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div><!-- /.row (main row) -->
    </section>
@stop
@section('footer')
    <!-- Morris.js charts -->
    <script src="{!! asset('assets/backend/js/raphael-2.1.0-min.js') !!}"></script>
    <script src="{!! asset('assets/backend/plugins/morris/morris.js') !!}"></script>
    <script>
        $(function () {
            "use strict";

            // AREA CHART
            var area = new Morris.Area({
                element: 'news-statistic-chart',
                resize: true,
                data: {!! $newsStatistic !!},
                xkey: 'y',
                'xLabels': 'day',
                // 'xLabelFormat': function (x) {
                //     var tmp = x.label.toString().split(" ");
                //     return tmp[1];
                // },
                parseTime: false,
                ykeys: ['created', 'published'],
                labels: ['Tạo mới', 'Xuất bản'],
                lineColors: ['#a0d0e0', '#3c8dbc'],
                hideHover: 'auto'
            });
        });
    </script>
@stop