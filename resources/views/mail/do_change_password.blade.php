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

                        <h1>Ứng dụng SuperKid</h1>

                    </td>
                </tr>
                <tr>
                    <td class="content">

                        <h2>Xin chào </h2>

                        <p>Email này được gửi tự động từ hệ thống phần mềm SuperKid, gửi cho bạn về việc lấy lại mật
                            khẩu tài khoản trên ứng dụng SuperKid</p>
                        <p>
                            Đây là link đổi mật khẩu: <a href="{{$url}}" target="_blank">Link</a>
                        </p>
                        <div>Nếu bạn cảm thấy phiền toái về những gì nhận được từ email này. Hãy gửi phản hồi đến chúng
                            tôi.
                        </div>

                        <p><em>– SuperKid Apk -</em></p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    @include('mail.includes._footer')
</table>
</body>
</html>