@extends('BackEnd::layouts.default')
{{-- @push('preloader')
<div id="preloader">
    <div id="status">
        <div class="spinner">Loading...</div>
    </div>
</div>
@endpush --}}
@section('CONTENT_REGION')
    <div class="wrapper" id="formMainInput">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Cấu hình trang chủ</a></li>
                            </ol>

                        </div>
                    </div>
                </div>
            </div>
            {{--@include('views/include/sumary-basic')--}}
            {!! Form::open(['url' => route('admin.confighome.post'), 'files' => true ]) !!}
                <div class="card mt-2 pb-3">
                    <div class="card-header">
                        <i class="fe-database"></i> Hình ảnh minh họa về sản phẩm phục hồi chức năng
                        <a href="javascript:void(0);" @click="createdNewSlide('lsSlideOne')" class="text-white float-right"><i class="fe-folder-plus"></i> Thêm mới</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3" v-for="(box, _box_) in lsSlideOne" :key="_box_">
                                <div class="form-group">
                                    <label for="image">Hình ảnh
                                    </label>
                                    <a href="javascript:void(0);" v-show="showDeleteButtonSlideOne" @click="deleteSlide('lsSlideOne', _box_)" class="text-danger float-right"><i class="fe-delete"></i> Xóa</a>
                                    <input type="hidden" :name="'lsSlideOne['+_box_+'][id]'" v-model="box.id">
                                    <input type="hidden" :name="'lsItem['+box.id+']'" v-model="box.id">
                                    <input type="file" required :id="'dropify-'+_box_" :name="'lsSlideOne['+_box_+'][image]'" :data-default-file="box.link"  />
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control placement" :name="'lsSlideOne['+_box_+'][title]'" v-model="box.title" maxlength="250" placeholder="Tiêu đề hình ảnh" />
                                    </div>
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control text-primary" :name="'lsSlideOne['+_box_+'][link_website]'" v-model="box.link_website" placeholder="Link website" />
                                    </div>
                                    <div class="input-group">
                                        <textarea :name="'lsSlideOne['+_box_+'][description]'" id="" cols="30" class="form-control placement" v-model="box.description" maxlength="250" placeholder="Mô tả hình ảnh"></textarea>
                                    </div>
                                    
                                </div>
                            </div>  <!-- end col -->
                            <div class="col-lg-6">

                            </div>

                        </div>
                        <button type="submit" class="btn btn-teal-800 text-white float-right"><i class="fe-save"></i> Cập nhật</button>
                    </div>
                    
                </div>
            {!! Form::close() !!}
            {!! Form::open(['url' => route('admin.confighome.post'), 'files' => true ]) !!}
                <div class="card mt-2 pb-3">
                    <div class="card-header">
                        <i class="fe-database"></i> Hình ảnh minh họa về sản phẩm phục hồi chức năng
                        <a href="javascript:void(0);" @click="createdNewSlide('lsSlideTwo')" class="text-white float-right"><i class="fe-folder-plus"></i> Thêm mới</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3" v-for="(box, _box_) in lsSlideTwo" :key="_box_">
                                <div class="form-group">
                                    <label for="image">Hình ảnh
                                    </label>
                                    <a href="javascript:void(0);" v-show="showDeleteButtonSlideTwo" @click="deleteSlide('lsSlideTwo', _box_)" class="text-danger float-right"><i class="fe-delete"></i> Xóa</a>
                                    <input type="hidden" :name="'lsSlideTwo['+_box_+'][id]'" v-model="box.id">
                                    <input type="hidden" :name="'lsItem['+box.id+']'" v-model="box.id">
                                    <input type="file" required :id="'dropify-two-'+_box_" :name="'lsSlideTwo['+_box_+'][image]'" :data-default-file="box.link"  />
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control placement" :name="'lsSlideTwo['+_box_+'][title]'" v-model="box.title" maxlength="250" placeholder="Tiêu đề hình ảnh" />
                                    </div>
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control placement" :name="'lsSlideTwo['+_box_+'][link_website]'" v-model="box.link_website" placeholder="Link website" />
                                    </div>
                                    <div class="input-group">
                                        <textarea :name="'lsSlideTwo['+_box_+'][description]'" id="" cols="30" class="form-control placement" v-model="box.description" maxlength="250" placeholder="Mô tả hình ảnh"></textarea>
                                    </div>
                                    
                                </div>
                            </div>  <!-- end col -->
                            <div class="col-lg-6">

                            </div>

                        </div>
                        <button type="submit" class="btn btn-teal-800 text-white float-right"><i class="fe-save"></i> Cập nhật</button>
                    </div>
                    
                </div>
            {!! Form::close() !!}



            {!! Form::open(['url' => route('admin.confighome.post'), 'files' => true ]) !!}
                <div class="card mt-2 pb-3">
                    <div class="card-header">
                        <i class="fe-database"></i> Hình ảnh đối tác
                        <a href="javascript:void(0);" @click="createdNewSlide('lsSlideHeader')" class="text-white float-right"><i class="fe-folder-plus"></i> Thêm mới</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3" v-for="(box, _box_) in lsSlideHeader" :key="_box_">
                                <div class="form-group">
                                    <label for="image">Hình ảnh
                                    </label>
                                    <a href="javascript:void(0);" v-show="showDeleteButtonSlideThree" @click="deleteSlide('lsSlideHeader', _box_)" class="text-danger float-right"><i class="fe-delete"></i> Xóa</a>
                                    <input type="hidden" :name="'lsSlideHeader['+_box_+'][id]'" v-model="box.id">
                                    <input type="hidden" :name="'lsItem['+box.id+']'" v-model="box.id">
                                    <input type="file" :required="box.link == ''" :id="'dropify-three-'+_box_" :name="'lsSlideHeader['+_box_+'][image]'" :data-default-file="box.link"  />
                                    <div class="input-group my-2">
                                        <input type="text" required class="form-control placement" :name="'lsSlideHeader['+_box_+'][title]'" v-model="box.title" maxlength="250" placeholder="Tiêu đề hình ảnh" />
                                    </div>
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control placement" :name="'lsSlideHeader['+_box_+'][link_website]'" v-model="box.link_website" placeholder="Link website" />
                                    </div>
                                    <div class="input-group">
                                        <textarea :name="'lsSlideHeader['+_box_+'][description]'" id="" cols="30" class="form-control placement" v-model="box.description" maxlength="250" placeholder="Mô tả hình ảnh"></textarea>
                                    </div>
                                    
                                </div>
                            </div>  <!-- end col -->
                            <div class="col-lg-6">

                            </div>

                        </div>
                        <button type="submit" class="btn btn-teal-800 text-white float-right"><i class="fe-save"></i> Cập nhật</button>
                    </div>
                    
                </div>
            {!! Form::close() !!}
            <div class="preview"></div>
        </div>
    </div>
@endsection


@section('CSS_REGION')
    {!! \Lib::addMedia('admin/libs/select2/select2.min.css') !!}
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.css') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.css') !!}
    {!! \Lib::addMedia('admin/libs/custombox/custombox.min.css') !!}
@stop

@push('JS_PLUGINS_REGION')
    {!! \Lib::addMedia('admin/libs/select2/select2.min.js') !!}
    {!! \Lib::addMedia('admin/libs/flatpickr/flatpickr.min.js') !!}
    {!! \Lib::addMedia('admin/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') !!}
    {!! \Lib::addMedia('admin/libs/switchery/switchery.min.js') !!}
    {!! \Lib::addMedia('admin/libs/custombox/custombox.min.js') !!}
    {!! \Lib::addMedia('admin/libs/tippy-js/tippy.all.min.js') !!}

    <script>
        $(document).ready(function() {
            $(".placement").maxlength({
                alwaysShow: !0,
                placement: "bottom",
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger"
            });
        });
        <?php
            echo "var data ='" . json_encode(@$data) . "';";
        ?>
        data = JSON.parse(data);
        console.log(data);
        if(typeof data['slide_one'] == 'undefined') {
            data['slide_one'] = [{
                id: 'none', 
                title: '',
                link_website: '',
                description: '',
                link: ''
            }];
        }
        if(typeof data['slide_two'] == 'undefined') {
            data['slide_two'] = [{
                id: 'none', 
                title: '',
                link_website: '',
                description: '',
                link: ''
            }];
        }
        if(typeof data['ls_vai'] == 'undefined') {
            data['ls_vai'] = [{
                id: 'none',
                title: '',
                link_website: '',
                description: '',
                link: ''
            }];
        }
        if(typeof data['slide_header'] == 'undefined') {
            data['slide_header'] = [{
                id: 'none', 
                title: '',
                link_website: '',
                description: '',
                link: ''
            }];
        }
        const lsObj = new Vue({
            el: '#formMainInput',
            data: {
                lsSlideOne: data['slide_one'],
                lsSlideTwo: data['slide_two'],
                lsSlideHeader: data['slide_header'],
                lsVai: data['ls_vai'],
                showDeleteButtonSlideOne: false,
                showDeleteButtonSlideTwo: false,
                showDeleteButtonSlideThree: false,
                showDeleteButtonlsVai: false
            },
            mounted() {
                this.$nextTick(() => {
                    this.initDropify()
                })
            },
            methods: {
                createdNewSlide(slide) {
                    var fk = this
                    fk[slide].push({
                        id: 'none', 
                        title: '',
                        link_website: '',
                        description: ''
                    })
                    Swal.fire({
                        title: 'Tạo thành công!',
                        type: "success",
                        showConfirmButton: !0,
                        confirmButtonClass: "#d33",
                        confirmButtonClass: "btn btn-success ml-2 mt-2 btn-sm",
                        buttonsStyling: !1,
                    });
                    length = fk[slide].length
                    fk.$nextTick(() => {
                        fk.initDropify(length - 1, slide)
                    })
                    if(length > 1) {
                        if(slide == 'lsSlideOne') {
                            fk.showDeleteButtonSlideOne = true
                        }else if(slide == 'lsSlideTwo') {
                            fk.showDeleteButtonSlideTwo = true
                        }else if(slide == 'lsVai') {
                            fk.showDeleteButtonlsVai = true
                        }else {
                            fk.showDeleteButtonSlideThree = true
                        }
                        
                    }
                },
                deleteSlide(slide, ind) {
                    var fk = this
                    Swal.fire({
                        title: 'Xóa',
                        text: 'Bạn có chắc chắn muốn thực hiện hành động này!',
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
                            if (fk[slide].length > 1) {
                                fk.$delete(fk[slide], ind)
                            }
                            if (fk[slide].length <= 1) {
                                if(slide == 'lsSlideOne') {
                                    fk.showDeleteButtonSlideOne = false
                                }else if(slide == 'lsSlideTwo') {
                                    fk.showDeleteButtonSlideTwo = false
                                }else if(slide == 'lsVai') {
                                    fk.showDeleteButtonlsVai = false
                                }else {
                                    fk.showDeleteButtonSlideThree = false
                                }
                            }
                        }
                    });
                },
                _save(slide) {

                },
                initDropify(id = false, slide = 'lsSlideOne') {
                    var fk = this
                    console.log(id)
                    if(id) {
                        if(slide == 'lsSlideOne') {
                            $('#dropify-'+id).dropify();
                        }else if(slide == 'lsSlideTwo'){
                            $('#dropify-two-'+id).dropify();
                        }else if(slide == 'lsVai'){
                            $('#dropify-lsVai-'+id).dropify();
                        }else {
                            $('#dropify-three-'+id).dropify();
                        }
                    }else {
                        $.each(fk.lsSlideOne, function(i, e) {
                            $('#dropify-'+i).dropify();
                        })
                        $.each(fk.lsSlideTwo, function(i, e) {
                            $('#dropify-two-'+i).dropify();
                        })
                        $.each(fk.lsSlideHeader, function(i, e) {
                            $('#dropify-three-'+i).dropify();
                        })
                        $.each(fk.lsVai, function(i, e) {
                            $('#dropify-lsVai-'+i).dropify();
                        })
                    }
                    
                }
            },
        });

    </script>
@endpush