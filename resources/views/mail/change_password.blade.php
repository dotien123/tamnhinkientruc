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
                    <td align="center" class="masthead" style="background-color: #FF5722;">
                        <h1>Beacons.vn</h1>
                    </td>
                </tr>
                <tr>
                    <td class="content">

                        <h2>Xin chào {{$name}}</h2>

                        <p>Email này được gửi tự động từ hệ thống phần mềm beacons.vn, thông báo đến bạn về việc thay đổi mật khẩu đăng nhập</p>
                        <fieldset style="border-radius: 5px;padding:12px;border-color: #ccc">
                            <legend style="margin-left: 15px;">Thông tin cập nhật như sau:</legend>
                            <p style="margin: 0"><b>Thay đổi mật khẩu đăng nhập của {{$obj['name']}}</b></p>
                            <p style="margin: 0">Mật khẩu mới của bạn là : <b>{{@value_show($new_password)}}</b></p>
                            <p style="margin: 0">Tài khoản đăng nhập : <b>{{@value_show($obj['account'],'Liên hệ admin biết')}}</b></p>
                            <p style="margin: 0">Cập nhật gần nhất: {{@date_time_show(\App\Elibs\Helper::getMongoDateTime(),'d/m/Y H:i:s')}}</p>
                            <p style="margin: 0">Cập nhật bởi: {{@value_show(\App\Http\Models\Staff::getCreatedByToSaveDb()['name'],@\App\Http\Models\Staff::getCreatedByToSaveDb()['email'])}}</p>
                            @if(isset($obj['removed']) && $obj['removed']=='yes')
                                <p style="margin: 0">Tình trạng : <b style="color: red;">Đã bị xóa</b></p>
                            @else
                                <p style="margin: 0">Tình trạng : <b style="color: green;">Đang hoạt động</b></p>
                            @endif
                        </fieldset>


                        <table>
                            <tr>
                                <td align="center">
                                    <p style="margin-top: 20px">
                                        <a href="{!! admin_link('/auth/login?ref=mail-change-password') !!}" class="button" style="color: #fff">Click vào đây để đăng nhập</a>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <div>Chỉ có bạn nhận được thông báo này</div>
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