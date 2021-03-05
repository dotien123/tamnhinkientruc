<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org=/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body style="height: 100%;     background-color: #eaebed;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center"
        style="text-align: justify;color:#353535;background-color: #eaebed;font-family: arial,sans-serif;padding: 30px 0px;line-height: 24px; font-size: 14px">
        <tbody>
            <tr>
                <td align="center" valign="" style="padding:0;margin:0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="640"
                        style="border: 1px solid #DDDDDD;background: #FFF;padding:20px; border-bottom: 3px solid #ff9600">
                        <tbody>

                            <tr>
                                <td colspan="2" style="color: #53a11b; font-size: 20px; padding: 10px 0">Thông tin mua trả góp</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Tên khách hàng:  </b> {{ @$name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Email:  </b> {{ @$email }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Điện thoại:  </b> {{ @$phone }}</td>
                            </tr>

                           @if($titleProduct != '')
                               <tr>
                                   <td colspan="2"><b>Tên sản phẩm:  </b> {{ @$titleProduct }}</td>
                               </tr>
                           @endif

                            <tr>
                                <td colspan="2"><b>Giá sản phẩm:  </b> {{ numberFormat($giaxe ) }} VNĐ</td>
                            </tr>

                            <tr>
                                <td colspan="2"><b>Số tiền trả trước:  </b> {{ numberFormat($tratruoc ) }} VNĐ</td>
                            </tr>


                            <tr>
                                <td colspan="2"><b>Lãi suất:  </b> {{ @$laisuat }}%</td>
                            </tr>

                            <tr>
                                <td colspan="2"><b>Số tiền trả hàng tháng:  </b> {{ numberFormat($tra_hang_thang) }} VNĐ</td>
                            </tr>

                            <tr>
                                <td colspan="2"><b>Thời hạn:  </b> {{ @$thoihanvay }} tháng</td>
                            </tr>

                            {{-- @if($content)
                                <tr>
                                    <td colspan="2"><b>Nội dung:  </b> {{ @$content }}</td>
                                </tr>
                            @endif --}}

                            <tr>
                                <td
                                    style="width: 50%; padding-left: 15px; height: 100%; font-size: 12px; padding-top: 15px">
                                </td>
                            </tr>

                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>

    <style>
        * {
            padding: 0;
            margin: 0;
        }

    </style>



</body>

</html>
