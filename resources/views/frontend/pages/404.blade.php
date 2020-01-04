@extends('frontend.master')
@section('title') 404 - {!! trans('system.have_an_error') !!} @stop
@section('content')
    <!--************************************
            Home Slider Start
    *************************************-->
    <div id="tg-innerbanner" class="tg-innerbanner tg-haslayout">
        <div class="tg-breadcrumbarea">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ol class="tg-breadcrumb">
                            <li><a href="{!! route('home') !!}">{!! trans('system.home') !!}</a></li>
                            <li class="tg-active">404</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--************************************
            Home Slider End
    *************************************-->
    <!--************************************
            Main Start
    *************************************-->
    <main id="tg-main" class="tg-main tg-haslayout">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div id="tg-content" class="tg-content">
                        <div class="tg-404content">
                            <div class="tg-404message">
                                <h2>404</h2>
                                <h3>
                                    <span>Ooooops!</span>
                                    @if(\Session::has('error_404'))
                                        {!! \Session::get('error_404') !!}
                                    @else
                                        {!! trans('system.have_an_error') !!}...
                                    @endif
                                </h3>
                            </div>
                            {{-- <form class="tg-formtheme tg-form404search">
                                <fieldset>
                                    <a href="" class="form-control">Phone</a>
                                    <input type="search" name="search" class="form-control" placeholder="Search Here">
                                    <button class="tg-btn" type="button">Search Now</button>
                                </fieldset>
                            </form> --}}
                            <div class="tg-description">
                                <span>{!! trans('system.back') !!} <a href="{!! route('home') !!}">{!! trans('system.home') !!}</a></span>
                                {{-- <div class="tg-btnbox">
                                    <a class="tg-btn" href="javascript:void(0);">Đăng ký</a>
                                </div>
                                <span>Hoặc quay về <a href="{!! route('home') !!}">{!! trans('system.home') !!}</a></span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--************************************
            Main End
    *************************************-->
@stop