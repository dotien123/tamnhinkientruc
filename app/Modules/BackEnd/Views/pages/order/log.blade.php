@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
@include('BackEnd::pages.order.include.list-table-log')
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/tippy-js/tippy.all.min.js') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/moment.min.js') !!}
    {!! \Lib::addMedia('admin/libs/daterangepicker/daterangepicker.js') !!}
    {!! \Lib::addMedia('admin/js/form-pickers.init.js') !!}

    <script>

        $(document).ready(function() {
            jQuery(".range-datepicker").daterangepicker({
                locale: {
                    format: 'D/M/Y',
                    cancelLabel: 'Xóa'
                }
            })
        });
    </script>

@endpush
