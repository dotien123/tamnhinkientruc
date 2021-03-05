<style>
    .card-box {
        background-color: #fff;
        padding: 1.5rem;
        -webkit-box-shadow: 0 0.75rem 6rem rgba(56,65,74,.03);
        box-shadow: 0 0.75rem 6rem rgba(56,65,74,.03);
        margin-bottom: 12px;
        border-radius: .25rem;
    }
</style>
<div class="modal fade bs-example-modal-center" id="formDetailInfo" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myCenterModalLabel">Hóa đơn</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div id="invoice-content">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-3">
                                <p><b>Xin chào, {{ $obj->full_name }}</b></p>
                                <p class="text-muted">Cảm ơn rất nhiều vì bạn tiếp tục mua sản phẩm của chúng tôi.
                                Cửa hàng chúng tôi hứa sẽ cung cấp các sản phẩm chất lượng cao cho bạn cũng như dịch vụ khách hàng xuất sắc cho mọi giao dịch. </p>
                            </div>

                        </div><!-- end col -->
                        <div class="col-md-5 offset-md-1">
                            <div class="mt-3 float-right">
                                <p class="m-b-10"><strong>Ngày đặt hàng : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; {{ \Lib::dateFormat(@$obj['published'], 'd/m/Y - H:i') }}</span></p>
                                @php($arrSta = \App\Models\Order::getListStatus(FALSE, @$obj->status))
                                <p class="m-b-10"><strong>Tình trạng đặt hàng : </strong> <span class="float-right"><span class="badge badge-{{ $arrSta['style'] }}">{{ $arrSta['text'] }}</span></span></p>
                                <p class="m-b-10"><strong>Mã đơn hàng : </strong> <span class="float-right font-weight-bold text-warning">&nbsp; #{{ @$obj['code'] }} </span></p>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <h6>Phương thức thanh toán</h6>
                            @php($pay = \App\Models\Order::getListPayment(TRUE, @$obj->payment_type))
                            <b class="text-warning d-block">{{ @$pay['text'] }}</b>
                            @if(@$obj->payment_type == 2)
                            <b>Tên Ngân Hàng:</b> {{ @$bank->bank }}<br>
                            <b>Số tài khoản:</b> {{ @$bank->account }}<br>
                            <b>Tên Chủ tài khoản:</b> {{ @$bank->name }}<br>
                            <b>Chi nhánh:</b> {{  @$bank->branch }}
                            @endif
                        </div> <!-- end col -->

                        <div class="col-sm-6">
                            <h6>Địa chỉ giao hàng</h6>
                            <address>
                                Địa chỉ: {{ @$obj['street']?:'Chưa cập nhật' }}<br>
                                Ghi chú: {{ @$obj['note']?:'Chưa cập nhật' }}<br>
                                <abbr title="Số điện thoại">SĐT:</abbr> {{ @$obj['telephone'] }}
                            </address>
                        </div> <!-- end col -->
                    </div> 
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mt-4 table-centered">
                                    <thead>
                                    <tr><th>#</th>
                                        <th>Sản phẩm</th>
                                        <th style="width: 20%">Số lượng</th>
                                        <th style="width: 20%" class="text-right">Tiền</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach ($obj->items as $item)
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <b>{{ @$item->title}}</b> <br/>
                                        </td>
                                        <td>{{ \Lib::numberFormat(@$item->quantity?:0) }}</td>
                                        <td class="text-right">{{ \Lib::priceFormat(@$item->sale_price*@$item->quantity?:0) }}</td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="clearfix pt-5">
                                {{-- <h6 class="text-muted">Notes:</h6>

                                <small class="text-muted">
                                    All accounts are to be paid within 7 days from receipt of
                                    invoice. To be paid by cheque or credit card or direct payment
                                    online. If account is not paid within 7 days the credits details
                                    supplied as confirmation of work undertaken will be charged the
                                    agreed quoted fee noted above.
                                </small> --}}
                            </div>
                        </div> <!-- end col -->
                        <div class="col-sm-6">
                            <div class="float-right">
                                {{-- <p><b>Phí vận chuyển:</b> <span class="float-right">{{ \Lib::priceFormat(@$obj->transport_fee?:0) }}</span></p> --}}
                                {{--<p><b>Mã giảm giá:</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; {{ \StringLib::getStrVal(@$obj->coupon_code?:"Chưa áp dụng") }}</span></p>--}}
                                <h3>{{ \Lib::priceFormat(@$obj->grandTotal?:0) }}</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- end card-box -->
            </div>
            <div class="modal-footer">
                <div class="text-right d-print-none">
                    <a href="javascript:void(0);" id="invoice-print" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Print</a>
                </div>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Bỏ qua</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    document.getElementById("invoice-print").onclick = function () {
        printElement(document.getElementById("invoice-content"));
    };

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
</script>
<style>
    @media screen {
    #printSection {
        display: none;
    }
    }

    @media print {
    body * {
        visibility:hidden;
    }
    #printSection, #printSection * {
        visibility:visible;
    }
    #printSection {
        position:absolute;
        left:0;
        top:0;
    }
    }
</style>