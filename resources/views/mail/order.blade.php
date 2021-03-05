<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    @include('mail.includes._style')
</head>
<body>
<table class="body-wrap">
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td align="center" class="masthead">

                        <h1>Vpdt.beacons.vn</h1>

                    </td>
                </tr>
                <tr>
                    <td class="content">

                        <h2>Xin chào </h2>

                        <p>Email này được gửi tự động từ hệ thống phần mềm vpdt.beacons.vn, thông báo đến bạn về việc có update mới trên hệ thống</p>
                        <fieldset style="border-radius: 5px;padding:12px;border-color: #ccc">
                            <legend style="margin-left: 15px;">Thông tin cập nhật như sau:</legend>
                            {{--                            <p style="margin: 0"><b>{{$title}}</b></p>--}}
                            {{--                            <p style="margin: 0">Tạo mới lúc: {{@date_time_show($obj['created_at'],'d/m/Y H:i:s')}}</p>--}}
                            {{--                            <p style="margin: 0">Cập nhật gần nhất: {{@date_time_show($obj['updated_at'],'d/m/Y H:i:s')}}</p>--}}
                            {{--                            <p style="margin: 0">Cập nhật bởi: {{@value_show($obj['created_by']['name'],@$obj['created_by']['email'])}}</p>--}}
                            {{--                            @if(isset($obj['removed']) && $obj['removed']=='yes')--}}
                            {{--                                <p style="margin: 0">Tình trạng : <b style="color: red;">Đã bị xóa</b></p>--}}
                            {{--                            @else--}}
                            {{--                                <p style="margin: 0">Tình trạng : <b style="color: green;">Đang hiển thị</b></p>--}}
                            {{--                            @endif--}}
                        </fieldset>

                        @if(@$link)
                            <table>
                                <tr>
                                    <td align="center">
                                        <p style="margin-top: 20px">
                                            <a href="{{$link}}" class="button" style="color: #fff">Click vào đây để xem chi tiết</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if(isset($obj['members']) && $obj['members'])
                            <div>Có: {{@count($obj['members'])}} nhân sự nhận được thông báo này</div>
                        @endif
                        <div>Nếu bạn cảm thấy phiền toái về những gì nhận được từ email này. Hãy gửi phản hồi đến chúng tôi. Hoặc tắt chức năng thông báo qua email trong thông tin nhân sự của bạn.</div>

                        <p><em>– Beacons.vn</em></p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    @include('mail.includes._footer')
</table>
</body>
</html>