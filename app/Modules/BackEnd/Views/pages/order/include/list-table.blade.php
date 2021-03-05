<!-- table checkbox start -->
<section id="table-chechbox">
    <div class="card" id="lsObj">
        <div class="card-header">
            <!-- head -->
            <h5 class="card-title">Danh sách {{ @$site_title }}</h5>
            <!-- Single Date Picker and button -->
            <form id="search">
                <input type="hidden" name="status" value="{{ $search_data->status }}">
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm theo ngày tạo sản phẩm">
                                <input style="width:200px;" autocomplete="off" type="text" name="time_between" value="{{ $search_data->time_between }}" class="form-control range-datepicker" placeholder="Chọn ngày tạo"/>
                                <div class="form-control-position">
                                    <i class="bx bx-calendar font-medium-1"></i>
                                </div>
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="has-icon-left" data-toggle="tooltip" data-placement="top" title="Tìm kiếm mã đơn hàng">
                                <input type="text" name="code" value="{{ $search_data->title }}"  class="form-control" />
                                <div class="form-control-position">
                                    <i class="bx bxl-amazon font-medium-1"></i>
                                </div>
                            </fieldset>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
        <!-- datatable start -->
        <div class="table-responsive">
            <table id="table-extended-chechbox" class="table table-transparent">
                <thead>
                <tr>
                    <th></th>
                    @foreach([
                            "Đơn hàng",
                            "Chi tiết đơn hàng",
                            "Phương thức thanh toán",
                            "Tình trạng đơn hàng",
                            "Ngày tạo"
                        ] as $k=> $label)
                        <th title="{{$label}}">{{ $label }}@if($k==0)
                                <div><span class="text-danger">({{ @$lsObj->total() }}) bản ghi</span></div>@endif</th>
                    @endforeach
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($lsObj as $k => $value)
                    <tr>
                        <td></td>
                        <td>
                        <span class="">
                            <strong>Mã đơn hàng:</strong> <span class="text-primary" style="cursor: pointer; font-weight: bold;" onclick="SHOW_POPUP_PREVIEW('order', {{ $value->id }})" data-toggle="tooltip" data-placement="top" data-original-title="Click xem thông tin chi tiết đơn hàng">{{ \StringLib::getStrVal(@$value->code) }}</span>
                        </span><br>
                                <span class="">
                            <strong>Họ tên:</strong> <span class="text-success">{{ \StringLib::getStrVal(@$value->full_name) }}</span>
                        </span><br>
                                <span class="">
                            <strong>Email:</strong> {{ \StringLib::getStrVal(@$value->email) }}
                        </span><br>
                                <span class="">
                            <strong>Phone:</strong> {{ \StringLib::getStrVal(@$value->telephone) }}
                        </span>
                        </td>
                        <td>
                    <span>
                        Số sản phẩm: <strong class="text-danger">{{ \Lib::numberFormat(@$value->number?:0) }}</strong>
                    </span><br>
                            <span>
                        Phí ship: <strong class="text-danger">{{ \Lib::priceFormat($value->transport_fee?:0) }}</strong>
                    </span><br>
                            <span>
                        Tổng tiền: <strong class="text-danger">{{ \Lib::priceFormat(@$value->grandTotal, ',', '.00 VNĐ') }}</strong>
                    </span>
                        </td>
                        <td style="width:150px">
                            @php($pay = \App\Models\Order::getListPayment(TRUE, @$value->payment_type))
                            {{ @$pay['text'] }}
                        </td>
                        @php($arrSta = \App\Models\Order::getListStatus(FALSE, @$value->status))
                        <td style="width:110px">
                            <span class="badge badge-{{ $arrSta['style'] }}">{{ $arrSta['text'] }}</span>
                        </td>

                        <td style="width:100px">
                            {{ \Lib::dateFormat(@$value->created, 'd/m/Y - H:i') }}
                        </td>



                        <td>
                            <div class="dropdown">
                                <span class="bx bx-dots-horizontal-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                </span>
                                @php($lsStatus = \App\Models\Order::getListStatus())
                                @php($groupAction = \App\Models\Order::getListStatus(FALSE, @$value->status))
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach($groupAction['group-action'] as $kf => $fail)
                                        <a title="Click để đưa đơn sang trạng thái {{ $lsStatus[$fail]['text-action'] }}"
                                           @click="_save({{ json_encode($lsStatus[$fail]) }}, {{ $value->id }})"
                                           class="dropdown-item ">
                                            <i class="menu-livicon mr-1" data-options="name: {{ $lsStatus[$fail]['icon'] }}; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i> {{ $lsStatus[$fail]['text'] }}
                                        </a>
                                    @endforeach
                                    <a title="Xem lịch sử đơn hàng" href="{{ route('admin.'.$key.'.log', ['id' => $value->id]) }}"
                                       data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"  class="dropdown-item cursor-pointer text-info">
                                        <i class="menu-livicon mr-1" data-options="name: timer.svg; size: 20px; style: lines; strokeColor:#475f7b; eventOn:grandparent; duration:0.85;"></i> Xem lịch sử
                                    </a>
                                </div>
                            </div>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- datatable ends -->
    </div>
</section>
<!-- table checkbox ends -->


@push('JS_REGION')
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function() {
                $('.item-check').prop('checked', this.checked);
            });

            $('.item-check').change(function () {
                var check = ($('.item-check').filter(":checked").length == $('.item-check').length);
                $('#checkAll').prop("checked", check);
            });

            $('.delete-all-checked').click(function () { 
                var order_ids = [];
                $.each($("input.item-check[type='checkbox']:checked"), function(){
                    order_ids.push($(this).data('id'));
                });
                Swal.fire({
                title: 'Xóa đơn hàng',
                text: 'Xác nhận chuyển tất cả đơn đã chọn sang trạng thái Đã xóa',
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                buttonsStyling: !1,
                confirmButtonText: "Vâng, tôi muốn"
            }).then(function (t) {
                    if (t.value) {
                        shop.ajax_popup('order/delete', 'POST', {ids: order_ids}, function(json){
                            if(json.error == 0) {
                                Swal.fire({
                                    title: 'Cập nhật thành công',
                                    type: "success",
                                    showCancelButton: 0,
                                    showConfirmButton: !0,
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonClass: "btn btn-success mt-2 btn-sm",
                                    buttonsStyling: !1,
                                });
                                shop.reload();
                            }else{
                                Swal.fire({
                                    title: 'Oops!',
                                    text: json.msg,
                                    type: "warning",
                                    showCancelButton: !0,
                                    showConfirmButton: 0,
                                    cancelButtonColor: "#d33",
                                    cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                                    buttonsStyling: !1,
                                });
                            }
                        });
                    }
                });
            });

            $("#table-extended-chechbox").DataTable({
                searching: !1,
                lengthChange: !1,
                paging: !1,
                bInfo: !1,
                columnDefs: [{orderable: !1, targets: [0, 6]}, {
                    targets: 0,
                    render: function (e, t, a, s) {
                        return "display" === t && (e = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'), e
                    },
                    checkboxes: {
                        selectRow: !0,
                        selectAllRender: '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" checked=""><label></label></div >'
                    }
                }],
                select: "multi",
            });
            $(".range-datepicker").daterangepicker({
                autoUpdateInput: false,
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                minYear: 1990,
                maxYear: parseInt(moment().format("YYYY"), 10),
                locale: {
                    format: 'DD/MM/YYYY hh:mm A',
                    cancelLabel: 'Xóa',
                    applyLabel: 'Cập nhật',
                }

            });
            $('.range-datepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY hh:mm A') + ' - ' + picker.endDate.format('DD/MM/YYYY hh:mm A'));
                $('#search').trigger('submit');
            });
            $('.range-datepicker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#search').trigger('submit');
            });
        });
    </script>
@endpush
