<!DOCTYPE html>
<html lang="en">
<head>
    <title>ViCloud.vn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        a {text-decoration: none; color: #428bca;} a:hover{text-decoration: underline;}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td,img{line-height:100%}body,p{margin:0;padding:0}#outlook a,body,p{padding:0}.appleBody a,.appleFooter a,img{text-decoration:none}.ExternalClass,.ReadMsgBody{width:100%}a,body,table,td{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0;mso-table-rspace:0}img{-ms-interpolation-mode:bicubic;border:0;height:auto;outline:0}p{line-height:1.5}table{border-collapse:collapse!important}body{height:100%!important;width:100%!important}.appleBody a{color:#68440a}.appleFooter a{color:#999}@media screen and (max-width:649px){table[class=wrapper],table[class=responsive-table]{width:100%!important}td[class=logo]{text-align:left;padding:20px 0!important}td[class=logo] img{margin:0 auto!important}td[class=mobile-hide]{display:none}img[class=mobile-hide]{display:none!important}img[class=img-max]{max-width:100%!important;width:100%!important;height:auto!important}td[class=mobile-wrapper],td[class=padding]{padding:10px 5% 15px!important}td[class=padding-copy]{padding:10px 5%!important;text-align:center}td[class=padding-meta]{padding:30px 5% 0!important;text-align:center}td[class=no-pad]{padding:0 0 20px!important}td[class=no-padding]{padding:0!important}td[class=section-padding]{padding:50px 15px!important}td[class=section-padding-bottom-image]{padding:50px 15px 0!important}table[class=mobile-button-container]{margin:0 auto;width:100%!important}a[class=mobile-button]{width:80%!important;padding:15px!important;border:0!important;font-size:16px!important}
    </style>

</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#fff">
                <div align="center" style="padding: 0px 15px 0px 15px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="650" class="wrapper">
                        <tr>
                            <td style="padding: 20px 0px 20px 0px; border-bottom: 5px solid #3193cf;" class="logo">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td bgcolor="#fff" width="200" align="left">
                                            <a href="http://vicloud.vn/">
                                                <img alt="logo" src="http://vicloud.vn/assets/frontend/images/logo-full.png" width="161" height="50" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                                            </a>
                                        </td>
                                        <td bgcolor="#fff" width="450" align="right" class="mobile-hide">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="right" style="padding: 0 0 5px 0; font-size: 14px; font-family: Arial, sans-serif; color: #666666; text-decoration: none;"><p style="font-size:24px;text-transform:uppercase;font-weight:bold;">Cộng đồng chia sẻ kiến thức</p>
                                                    <label style="font-size: 24px; color: #3193cf;">ViCloud.vn</label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 40px 15px 20px 15px;" class="section-padding">
                <table border="0" cellpadding="0" cellspacing="0" width="650" class="responsive-table">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="padding-copy">
                                        <p>[BQT] <a href="http://vicloud.vn/community">cộng đồng</a><span style="color: #3193cf; font-weight: bold;"> VICLOUD.VN</span> thông báo!</p>
                                        <?php $approved = 0; ?>
                                        @if(isset($changeAttributes['status']) && $changeAttributes['status'])
                                            <?php $approved = 1; unset($changeAttributes['status']); ?>
                                            <p><span style="color:#3193cf;font-weight:bold;">BÀI VIẾT CỦA BẠN ĐÃ ĐƯỢC DUYỆT!</span></p>
                                        @endif

                                        @if (count($changeAttributes))
                                            @if(is_null($creator))
                                                <p>{!! $approved ? 'Và' : 'Bạn vừa' !!} thay đổi thông tin bài viết của mình lúc {!! date("d/m/Y H:i", time()) !!}</p>
                                            @else
                                                <p>{!! $approved ? 'Và' : '' !!} [QTV] {!! $user->fullname !!} vừa có một vài thay đổi thông tin bài viết của bạn lúc {!! date("d/m/Y H:i", time()) !!}</p>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @if (count($changeAttributes))
                                <tr>
                                    <td style="padding:30px 0 0 0; overflow-x: auto">
                                        <table width="100%" class="respon-table" border="1" cellspacing="5" cellpadding="10" style="border-collapse:collapse;border-color:#ccc;">
                                            <thead>
                                                <tr style="background: #F4F4F4;border-bottom:3px solid #3193cf;">
                                                    <td style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 5px; white-space: nowrap;" class="padding-copy">THUỘC TÍNH</td>
                                                    <td style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 5px; white-space: nowrap;" class="padding-copy">THÔNG TIN CŨ</td>
                                                    <td style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 5px; white-space: nowrap;" class="padding-copy">THÔNG TIN MỚI</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($changeAttributes as $attribute)
                                                    <?php if ($attribute == 'content') continue; ?>
                                                    @if ($attribute=='paid')
                                                        <tr>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                                {!! trans('news.' . $attribute) !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">
                                                                {!! $news->{$attribute} ? 'Đã thanh toán' : 'Chưa thanh toán' !!}
                                                            </td>
                                                        </tr>
                                                    @elseif ($attribute=='closed')
                                                        <tr>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                                {!! trans('news.' . $attribute) !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">
                                                                {!! $news->{$attribute} ? 'Đóng hộp thoại' : 'Mở hộp thoại' !!}
                                                            </td>
                                                        </tr>
                                                    @elseif ($attribute=='featured')
                                                        <tr>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                                {!! trans('news.' . $attribute) !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">

                                                                {!! $news->{$attribute} ? 'Nổi bật' : 'Bỏ nổi bật' !!}
                                                            </td>
                                                        </tr>
                                                    @elseif ($attribute=='category_id')
                                                        <tr>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                                {!! trans('news.' . $attribute) !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                                {!! App\NewsCategory::find($original[$attribute])->name !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">
                                                                {!! App\NewsCategory::find($news->{$attribute})->name !!}
                                                            </td>
                                                        </tr>
                                                    @elseif ($attribute=='image')
                                                        <tr>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                                {!! trans('news.' . $attribute) !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                                <img src="{!! asset('assets/media/images/news/' . $original[$attribute]) !!}" height="100px" style="max-width: 100px;">
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">
                                                                <img src="{!! asset('assets/media/images/news/' . $news->{$attribute}) !!}" height="100px" style="max-width: 100px;">
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                                {!! trans('news.' . $attribute) !!}
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                                <strike>{!! $original[$attribute] !!}</strike>
                                                            </td>
                                                            <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">
                                                                {!! $news->{$attribute} !!}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                @if (isset($changeAttributes['content']))
                                <tr>
                                    <td style="padding:30px 0 0 0; overflow-x: auto">
                                        <table width="100%" class="respon-table" border="1" cellspacing="5" cellpadding="10" style="border-collapse:collapse;border-color:#ccc;">
                                            <tbody>
                                                <tr>
                                                    <th style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                        NỘI DUNG CŨ
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #c2c2c2; padding-top: 5px;" class="padding-copy">
                                                        {!! $original['content'] !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; padding-top: 5px;" class="padding-copy">
                                                        NỘI DUNG MỚI
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 13px; font-family: Helvetica, Arial, sans-serif; color: #3193cf; padding-top: 5px;" class="padding-copy">
                                                        {!! $news->content !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td align="center">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                            <tr>
                                                <td align="left" style="padding: 25px 0 0 0;" class="padding-copy">
                                                    <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                                                        <tr>
                                                            <td align="left">
                                                                <p>Bạn có thể review bài viết của mình <a href="{!! route('admin.news.show', $news->id) !!}">tại đây</a> hoặc theo link chi tiết: {!! route('admin.news.show', $news->id) !!}.</p>
                                                                <p><span style="color:#3193cf;font-weight:bold;">VICLOUD.VN</span> rất hân hạnh được hợp tác!</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#F4F4F4" align="center" style="padding: 20px 10px;">
                <table width="650" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
                    <tr>
                        <td width="450">
                            <label>Dịch vụ được cung cấp bởi:</label>
                            <p><b>Công ty Cổ phần Giải pháp Công nghệ cao BCTech</b></p>
                        </td>
                        <td width="200">
                            <img src="http://bctech.vn/assets/frontend/images/logo.png" alt="bctech.vn" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#fff" align="center" style="padding: 20px 0px;">
                <!-- UNSUBSCRIBE COPY -->
                <table width="650" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
                    <tr>
                        <td width="300" style="padding:15px 0 0 0;">
                            <a href="https://www.facebook.com/vicloud.vn/" title="Facebook" style="display: inline-block; padding: 5px; margin: 0 5px; background: #3c5a9a;color:#fff;text-decoration:none;font-weight:bold;">Facebook</a>
                            <a href="http://bctech.vn/" title="bctech" style="display: inline-block; padding: 5px; margin: 0 5px; background: #6D3C1D;color:#fff;text-decoration:none;font-weight:bold;">BCTech</a>
                            <a href="http://vicloud.vn/" title="vicloud" style="display: inline-block; padding: 5px; margin: 0 5px; background: #287EC2;color:#fff;text-decoration:none;font-weight:bold;">ViCloud</a>
                        </td>
                        <td width="350" align="right" style="padding:0 10px 0 0;">
                            <p>Website: <a href="http://vicloud.vn">http://vicloud.vn</a></p>
                            <label>Hotline: <span><a href="tel:02466883355" style="color:#f00 !important;">024 6688 3355</a></span> - Email: <a href="mailto:hello@vicloud.vn">hello@vicloud.vn</a></label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


