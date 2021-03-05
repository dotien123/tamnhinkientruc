<section id="table-chechbox">
    <div class="card">
        <div class="card-header">
            <!-- head -->
            <h5 class="card-title">
                Danh sách {{ @$site_title }}
                <span>

                </span>
            </h5>
            <form id="search">
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li>
                            <div class="row">
                                <div class="form-group col">
                                    <div class="input-group">
                                        <input title="Tìm theo khoảng thời gian thực hiện hành động" data-plugin="tippy"
                                               data-tippy-animation="scale" data-tippy-inertia="true"
                                               data-tippy-duration="[600, 300]" data-tippy-arrow="true"
                                               type="text" name="time_between" value="{{ $search_data->time_between }}"
                                               class="form-control range-datepicker"
                                               placeholder="Khoảng thời gian bắt đầu">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-teal-800"><i class="fa fa-search"></i> Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
        @if(empty($lsObj) || $lsObj->isEmpty())
            <div class="alert alert-danger" role="alert">
                <i class="mdi mdi-block-helper mr-2"></i>
                Không tìm thấy dữ liệu nào ở trang này. (Hãy kiểm tra lại các điều kiện tìm kiếm hoặc phân trang...)
            </div>
        @else
        <div class="table-responsive">
            <table id="table-extended-chechbox" class="table table-transparent">
                <thead>
                <tr>
                    <th style="width: 20px;">
                    </th>
                    @foreach([
                        "Người dùng",
                        "Hành động",
                        "Thời gian",
                        "IP",
                        "Ghi chú"
                    ] as $k=> $label)
                        <th title="{{$label}}">
                            <div class="sp-line-1">
                                {{$label}}
                            </div>
                            @if($k==0)
                                <div><span class="text-danger">({{@$lsObj->total()}}) bản ghi</span></div>
                            @endif
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($lsObj as $k=>$value)
                    <tr>
                        <td class="td-number ribbon-box">
                            <span class="td-number-value ribbon ribbon-teal-800 float-left">
                                {{str_pad($k+1, 2, '0', STR_PAD_LEFT)}}
                            </span>
                        </td>
                        <td class="text-capitalize">
                            <a title="Click xem thông tin thành viên" href="{{ route('admin.user.edit', ['id' => @$value->user->id]) }}"
                                data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"  class="cursor-pointer text-info">
                                {{ \StringLib::getStrVal(@$value->username) }}
                                </a>
                        </td>
                        <td style="width:500px" class="text-capitalize">
                            @if(@$value->action_key != 'email_buy')
                            @php($arrSta = \App\Models\Order::getListStatus(FALSE, @$value->action_key))
                            <span class="text-success">{{ \StringLib::getStrVal('Đã chuyển đơn sang trạng thái ' .@$arrSta['text']?:'') }}</span>
                            @else
                            <span class="text-success">{{ \StringLib::getStrVal(\App\Models\OrderLog::$actions[$value->action_key]) }}</span>
                            @endif
                        </td>

                        <td>
                            {{ \Lib::dateFormat($value->created, 'd/m/Y - H:i:s') }}
                        </td>
                        <td class="text-capitalize">
                            {{ \StringLib::getStrVal(@$value->ip) }}
                        </td>
                        <td>
                            {{ \StringLib::getStrVal(@$value->note) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $lsObj->links('BackEnd::layouts.pagin', ['data' => $lsObj]) !!}
        @endif
    </div>
</section>
