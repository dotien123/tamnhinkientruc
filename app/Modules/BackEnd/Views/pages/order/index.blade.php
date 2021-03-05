@extends('BackEnd::layouts.default')
@section('CONTENT_REGION')
    <ul class="nav nav-tabs nav-bordered">
        <li class="nav-item">
            <a href="{{ route('admin.order') }}" aria-expanded="false" class="nav-link {{ (!$search_data->status) ? 'active' : ''}}">
                Tất cả
            </a>
        </li>
        @foreach ($lsStatus as $item)
            <li class="nav-item">
                <a href="?status={{ $item['alias'] }}" aria-expanded="false" class="nav-link {{ ($search_data->status == $item['alias']) ? 'active' : ''}}">
                    {{ $item['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content pl-0">
        <div class="tab-pane show active" id="all">
            @include('BackEnd::pages.order.include.list-table')
            {!! $lsObj->links('BackEnd::layouts.pagin', ['data' => $lsObj]) !!}
        </div>
    </div>
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/pickers/daterange/daterangepicker.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/tables/datatable/datatables.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.date.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.time.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/legacy.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/daterange/moment.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/daterange/daterangepicker.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tables/datatable/datatables.min.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') !!}
    <script>
        $(document).ready(function() {

        });
        function SHOW_POPUP(id, bidx) {
            shop.ajax_popup('order/popup-preview', 'POST', {
                    id: id
                }, function (response) {
                    if (response.error == 1) {
                        Swal.fire({
                            title: 'Oops!',
                            text: response.msg,
                            type: "warning",
                            showCancelButton: !0,
                            showConfirmButton: 0,
                            cancelButtonColor: "#d33",
                            cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                            buttonsStyling: !1,
                        });
                    }else {
                        $('.preview').empty().html(response);
                        $('.bs-example-modal-center').modal({backdrop: 'static'});
                        $('.switchery-popup').each(function (idx, obj) {
                            new Switchery($(this)[0], $(this).data());
                        });
                    }
                },
                'html');
        }
        <?php
                $lsOrder = @$lsObj->toArray();
            echo "var lsOrders ='" . json_encode($lsOrder['data']) . "';";
        ?>
        lsOrders = JSON.parse(lsOrders);
    </script>
    {!! \Lib::addMedia('admin/js/library/order/order.js') !!}
@endpush