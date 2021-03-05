@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    @include('BackEnd::pages.'.$key.'.include.list-table')
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
    {!! \Lib::addMedia('admin/libs/dropify/dropify.min.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/pickers/daterange/daterangepicker.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/tables/datatable/datatables.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
{{--    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}--}}
    {!! \Lib::addMedia('admin/libs/select2/select2.min.js') !!}
    {!! \Lib::addMedia('admin/libs/tippy-js/tippy.all.min.js') !!}
{{--    {!! \Lib::addMedia('admin/js/form-pickers.init.js') !!}--}}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.js') !!}
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

            $('[data-toggle="select2"]').select2();

            $("input.placement").maxlength({
                alwaysShow: !0,
                placement: "top-left",
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
            $('.switchery').on('click', function() {
                let $ele = $(this).siblings('input[data-plugin="switchery"]');
                shop.admin.updateStatus('{{ $key }}', $ele.data('id'), $ele.prop("checked"))
            })
            $("#table-extended-chechbox").DataTable({
                searching: !1,
                lengthChange: !1,
                paging: !1,
                bInfo: !1,
                // columnDefs: [{orderable: !1, targets: [0, 5]}, {
                //     targets: 0,
                //     render: function (e, t, a, s) {
                //         return "display" === t && (e = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'), e
                //     },
                //     checkboxes: {
                //         selectRow: !0,
                //         selectAllRender: '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" checked=""><label></label></div >'
                //     }
                // }],
                // select: "multi"
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
