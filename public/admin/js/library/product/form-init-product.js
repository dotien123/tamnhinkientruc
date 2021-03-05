

const lsObj = new Vue({
   el: '#lsObj',
   data() {
       return {
           lsColors: lsColors,
           lsSizes: lsSizes,
           item: {
               sku: '', color_id: 0, size_id: 0,
               original_price: 0, sale_price: 0,
               status: false, quantity: 0,
           },
           lsItem: lsItem,
           money: {
               decimal: ',',
               thousands: '.',
               prefix: '',
               suffix: ' VNĐ',
               precision: 2,
               masked: false /* doesn't work with directive */
           },
           myDropzone: 0,
           pid: pid,
       }
   },
    mounted() {
        this.$nextTick(() => {
            let vm = this
            this.initSwitchery()
            Dropzone.autoDiscover = false;
            this.myDropzone = new Dropzone("#uploadImage", {
                addRemoveLinks: true,

                url: ENV.BASE_URL+'ajax/product/upload-file',
                headers: {
                    'X-CSRF-TOKEN': ENV.token
                },
                init:function(){
                    var self = this;
                    // config
                    self.options.addRemoveLinks = true;
                    self.options.dictRemoveFile = "Delete";
                    //New file added
                    self.on("addedfile", function (file) {
                        /*file.previewElement.addEventListener("click", function() {
                            self.removeFile(file);
                        });*/
                    });
                    // Send file starts
                    self.on("sending", function (file, xhr, formData) {
                        formData.append("detail_pid", vm.item.id);
                        $('.meter').show();
                    });

                    self.on("success", function (file, json) {
                        console.log(file)
                        if(json.error == 0) {
                            if(typeof vm.lsItem[vm.item.id]['detail_images'] == 'undefined') {
                                lsObj.$set(vm.lsItem[vm.item.id], 'detail_images', [])
                            }
                            lsObj.$set(vm.lsItem[vm.item.id]['detail_images'], json.data.id, json.data)
                        }
                    });

                    // File upload Progress
                    self.on("totaluploadprogress", function (progress) {
                        console.log("progress ", progress);
                        $('.roller').width(progress + '%');
                    });

                    self.on("queuecomplete", function (progress) {
                        $('.meter').delay(999).slideUp(999);
                    });

                    // On removing file
                    self.on("removedfile", function (file) {
                        console.log(file);
                        shop.ajax_popup('product/remove-file', 'POST', {id: file.id}, function(json){
                            if(json.error == 0) {
                                lsObj.$delete(vm.lsItem[vm.item.id]['detail_images'], file.id)
                                Swal.fire({
                                    title: 'Xóa Thành Công',
                                    type: "success",
                                    showCancelButton: 0,
                                    showConfirmButton: !0,
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonClass: "btn btn-success mt-2 btn-sm",
                                    buttonsStyling: !1,
                                });
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
                    });
                }
            });
        })
    },

    methods: {
        showPopUpForm(id = false){
            var vm = this
            if(id) {
                // chỉnh sửa
                lsObj.$set(vm.item, 'id', vm.lsItem[id]['id']),
                lsObj.$set(vm.item, 'sku', vm.lsItem[id]['sku']),
                lsObj.$set(vm.item, 'color_id', vm.lsItem[id]['color_id']),
                lsObj.$set(vm.item, 'size_id', vm.lsItem[id]['size_id']),
                lsObj.$set(vm.item, 'original_price', vm.lsItem[id]['original_price']),
                lsObj.$set(vm.item, 'sale_price', vm.lsItem[id]['sale_price']),
                lsObj.$set(vm.item, 'quantity', vm.lsItem[id]['quantity']),
                lsObj.$set(vm.item, 'status', vm.lsItem[id]['status'])

                this.$nextTick(function () {
                    $('#uploadImage .dz-preview').remove();
                    if($('#uploadImage .dz-message').css('display') == 'none') {
                        $('#uploadImage .dz-message').show();
                    }
                    $('.switchery_popup').siblings('span').remove();
                    new Switchery($('.switchery_popup')[0], $('.switchery_popup').data());


                    var mockFile = vm.lsItem[id]['detail_images'];
                    $.each(mockFile, function( index, value ) {
                        vm.myDropzone.options.addedfile.call(vm.myDropzone, value);
                        vm.myDropzone.options.thumbnail.call(vm.myDropzone, value, value.link);
                    });

                });



            }else {
                vm.item.sku =  '', vm.item.color_id =  0, vm.item.size_id = 0,
                    vm.item.original_price = 0, vm.item.sale_price = 0,
                    vm.item.status = true, vm.item.quantity = 0, delete vm.item.id
            }
        },
        _saveItem(itm = false) {
            var vm = this; let item = 0
            if(itm && typeof itm == 'object') {
                item = itm
            }else {
                item = vm.item
            }
            item['basic_pid'] = vm.pid
            shop.ajax_popup('product/save-detail', 'POST', item, function(json){
                if(json.error == 0) {
                    lsObj.$set(vm.lsItem, json.data.id, json.data)
                    vm.item.sku = '', vm.item.color_id = 0, vm.item.size_id = 0,
                    vm.item.original_price = 0, vm.item.sale_price = 0,
                    vm.item.status = true, vm.item.quantity = 0
                    if (!itm || typeof itm != 'object') {
                        Vue.nextTick(function () {
                            lsObj.initSwitchery(json.data.id);
                        });
                    }
                    $('#formDetailInfo').modal('hide');
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

        },
        removeItem(id = false) {
            Swal.fire({
                title: "Bạn có chắc chắn muốn xóa bản ghi này?",
                text: "Lưu ý: dữ liệu bị xóa sẽ không thể phục hồi lại được!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                buttonsStyling: !1,
                confirmButtonText: "Vâng, Tôi muốn xóa!"
            }).then(function (t) {
                if (t.value) {
                    var vm = this
                    shop.ajax_popup('product/delete-detail', 'POST', {id: id}, function(json){
                        if(json.error == 0) {
                            lsObj.$delete(vm.lsItem, id)
                            Swal.fire({
                                title: 'Xóa Thành Công',
                                type: "success",
                                showCancelButton: 0,
                                showConfirmButton: !0,
                                confirmButtonColor: "#3085d6",
                                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                                buttonsStyling: !1,
                            });
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
        },
        initSwitchery(id = false) {
            var vm = this
            if(id) {
                if(typeof vm.item.id != "undefined") {
                    $('#switchery-'+id).siblings('span').remove();
                }
                new Switchery($('#switchery-'+id)[0], $('#switchery-'+id).data())
            }else {
                $('[data-plugin="switchery"]').each(function (idx, obj) {
                    new Switchery($(this)[0], $(this).data());
                });
                new Switchery($('#switchery-undefined')[0], $('#switchery-undefined').data());
            }
        }
    }
});