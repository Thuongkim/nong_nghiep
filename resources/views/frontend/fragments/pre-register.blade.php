<figure class="item" data-vide-bg="poster: assets/frontend/img/slider/img-01.jpg" data-vide-options="position: 50% 50%">
    <figcaption>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-push-2 col-lg-8">
                    <div class="tg-bannercontent">
                        <h1>Đăng ký sử dụng miễn phí ngay!</h1>
                        <h2>{!! isset($staticPages['website-title']['description']) ? $staticPages['website-title']['description'] : env('APP_NAME') !!} đã có hơn 5,754 lượt người sử dụng</h2>
                        {!! Form::open(['url' => route('prePostRegister'), 'class' => "tg-formtheme tg-formbannersearch"]) !!}                                    <form>
                            <fieldset>
                                <div class="form-group tg-inputwithicon">
                                    <i class="icon-envelope"></i>
                                    {!! Form::email('email', old('email'), ["class" => "form-control", "placeholder" => trans('system.your_email'), "tabindex" => 1]) !!}
                                </div>
                                <div class="form-group tg-inputwithicon">
                                    <i class="icon-lock"></i>
                                    <a class="tg-btnsharelocation icon-eye" href="javascript:void(0);" id="eye"></a>
                                    {!! Form::password('password', ["class" => "form-control", "placeholder" => "Chọn một mật khẩu", "id" => "password", "tabindex" => 2]) !!}
                                </div>
                                <button class="tg-btn" type="submit" tabindex="3">{!! trans('system.use_now') !!}</button>
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </figcaption>
</figure>