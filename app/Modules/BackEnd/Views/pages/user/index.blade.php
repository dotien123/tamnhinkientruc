@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    <!-- BEGIN: Content-->
    @include('BackEnd::pages.'.$key.'.include.list-table')
    <!-- END: Content-->
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
            $('[data-plugin="switchery"]').each(function (idx, obj) {
                new Switchery($(this)[0], $(this).data());
            });
            $("#table-extended-chechbox").DataTable({
                searching: !1,
                lengthChange: !1,
                paging: !1,
                bInfo: !1,
                columnDefs: [{orderable: !1, targets: [0, 7]}, {
                    targets: 0,
                    render: function (e, t, a, s) {
                        return "display" === t && (e = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'), e
                    },
                    checkboxes: {
                        selectRow: !0,
                        selectAllRender: '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" checked=""><label></label></div >'
                    }
                }],
                select: "multi"
            });
        });
    </script>
@endpush
