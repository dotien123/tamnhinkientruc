@extends('emails.template')

@section('content')
<div style="padding:25px 20px;text-align:left;font-size: 14px;">
    <div style="font-style: italic;font-weight: 600;color: #333;">
        Xin chào bạn,
    </div>
    <div style="padding:10px 0 15px;text-align:left;line-height: 20px">
        <p>Bạn nhận được email này do bạn hoặc một ai đó đã sử dụng tính năng <em>quên mật khẩu</em> trên <b>{{ env('APP_NAME') }}</b></p>

        <p>Nếu bạn không yêu cầu, vui lòng bỏ qua nội dung của email này, lệnh sẽ được huỷ trong vòng 24 giờ và thông tin của bạn vẫn như bình thường.</p>

        <p>Nếu bạn muốn thay đổi mật khẩu, vui lòng <a href="{{ route('password.reset', $data->token->token) }}">Nhấn vào đây</a> để đặt lại mật khẩu cho tài khoản.</p>

        <p>Trong trường hợp trình duyệt web không tự chuyển được vui lòng copy link dưới đây vào trình duyệt và nhấn Enter: <br> <a href="{{ route('password.reset', $data->token->token) }}">{{ route('password.reset', $data->token->token) }}</a></p>

        <p>Cảm ơn bạn đã sử dụng dịch vụ của <b>{{env('APP_NAME')}}</b></p>
    </div>
</div>
@stop