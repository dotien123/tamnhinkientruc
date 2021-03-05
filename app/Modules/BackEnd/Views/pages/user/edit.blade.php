@extends('BackEnd::layouts.default')

@section('CONTENT_REGION')
    @include('BackEnd::pages.user.include.input-form')
@stop

@section('CSS_REGION')
    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/plugins/forms/validation/form-validation.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/css/pickers/pickadate/pickadate.css') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/css/pages/page-users.min.css') !!}
@stop


@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.date.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/pickers/pickadate/picker.time.js') !!}
    {!! \Lib::addMedia('admin/frest-admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') !!}
@endpush