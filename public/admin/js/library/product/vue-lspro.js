const lsObj = new Vue({
    el: '#lsObj',
    data() {
        return {
            lsColors: lsColors,
            lsSizes: lsSizes,
            lsItem: Object.assign({}, lsItem),
            item: {
                sku: "", id: 0, color_id: 0, size_id: 0,
                original_price: 0, sale_price: 0,
                status: false, quantity: 0,
                detail_images: {}
            },
            money: {decimal: ',', thousands: '.', prefix: '', suffix: ' VNĐ', precision: 2, masked: false },
            pid: pid,
            action: 'add',
            myDropzone: ''
        }
    },
    mounted() {
        this.$nextTick(() => {
            let vm = this
            this.initSwitchery()
            this.initDropzone()
        })
    },
    methods: {
        showPopUpForm(id = false){
            var vm = this
            if(id) {
                // chỉnh sửa
                vm.action = 'edit'
                lsObj.$set(vm.item, 'id', vm.lsItem[id]['id']),
                lsObj.$set(vm.item, 'sku', vm.lsItem[id]['sku']),
                lsObj.$set(vm.item, 'color_id', vm.lsItem[id]['color_id']),
                lsObj.$set(vm.item, 'size_id', vm.lsItem[id]['size_id']),
                lsObj.$set(vm.item, 'original_price', vm.lsItem[id]['original_price']),
                lsObj.$set(vm.item, 'sale_price', vm.lsItem[id]['sale_price']),
                lsObj.$set(vm.item, 'quantity', vm.lsItem[id]['quantity']),
                lsObj.$set(vm.item, 'status', vm.lsItem[id]['status'])
                // vm.initDropzone(id)
                this.$nextTick(function () {
                    $("div#lsimg-"+vm.item.sku).find('.dz-processing').remove();
                });
                var mockFile = vm.lsItem[vm.item.sku]['detail_images'];
                $.each(mockFile, function( index, value ) {
                    vm.myDropzone.options.addedfile.call(vm.myDropzone, value);
                    vm.myDropzone.options.thumbnail.call(vm.myDropzone, value, value.link);
                });
            }else {
                vm.action = 'add'
                vm.item.sku =  "", vm.item.color_id =  0, vm.item.size_id = 0,
                vm.item.original_price = 0, vm.item.sale_price = 0,
                vm.item.status = true, vm.item.quantity = 0, vm.item.id = 0;
                this.$nextTick(function () {
                    $("div#lsimg-"+vm.item.sku).removeClass('dz-started').find('.dz-preview').remove();
                });
                
            }
            this.$nextTick(function () {
                $('.switchery_popup').siblings('span').remove();
                $('.select2-vue').siblings('span').remove();
                $('.select2-vue').select2();
                new Switchery($('.switchery_popup')[0], $('.switchery_popup').data());
            });
        },
        _saveItem(itm = false) {
            var vm = this; let item = 0
            if(itm && typeof itm == 'object') {
                item = itm
                vm.item = itm
            }else {
                item = vm.item
            }
            item['basic_pid'] = vm.pid
            var fds = {
                color_id: item.color_id,
                size_id: item.size_id
            }
            lsItem = Object.entries(vm.lsItem)
            let selectedItem = lsItem.filter(
                function(it) {
                    var temp = 0;
                    $.each(fds,function(i,v){
                        if(it[1][i] == v) {
                            temp++;
                        }else {
                            temp = 0;
                        }
                    });
                    return temp > 1;
                }
            );
            if(vm.action == 'add' && selectedItem.length > 0 && item.color_id > 0 && item.size_id > 0 && !itm && typeof itm != 'object') {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Thuộc tính sản phẩm trùng lặp.',
                    type: "warning",
                    showCancelButton: 0,
                    showConfirmButton: !0,
                    confirmButtonColor: "#d33",
                    confirmButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                    buttonsStyling: !1,
                });
            }else {
                shop.ajax_popup('product/save-detail', 'POST', item, function(json){
                    if(json.error == 0) {
                        let sku = json.data.sku, status = json.data.status, id = json.data.id
                        vm.item.id = id
                        vm.item.sku = sku
                        vm.item.status = status
                    
                        lsObj.$set(vm.lsItem, sku, JSON.parse(JSON.stringify(vm.item)))
                        if (typeof itm != 'object') {
                            vm.item.sku = '', vm.item.color_id = 0, vm.item.size_id = 0,
                                vm.item.original_price = 0, vm.item.sale_price = 0,
                                vm.item.status = true, vm.item.quantity = 0, vm.item.id = 0, vm.item.detail_images = {}
                            Vue.nextTick(function () {
                                if(id == 0) {
                                    $.each(vm.lsItem[sku]['detail_images'], function(i, val) {
                                        $('#data-hide-'+sku).append('<input type="hidden" name="lsPro['+sku+'][images]['+val.id+']" value="'+val.id+'">')
                                    })
                                }
                                lsObj.initSwitchery(sku);
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
            }

        },
        _submitForm() {
            var fk = this
            let title = $('input[name="title"]').val(),
            cate_id = $('select[name="cate_id"]').val(),
            alias = $('input[name="alias"]').val();
            $btn = $('#btnUpdate[type="button"]')
            if($btn.length) {
                if(Object.keys(fk.lsItem).length === 0) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Vui lòng thêm thuộc tính sản phẩm',
                        type: "warning",
                        showCancelButton: !0,
                        showConfirmButton: 0,
                        cancelButtonColor: "#d33",
                        cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                        buttonsStyling: !1,
                    });
                }else {
                    shop.ajax_popup('product/save', 'POST', {
                        title: title,
                        alias: alias,
                        cate_id: cate_id
                    }, function (json) {
                        if (json.error == 0) {
                            return $('#btnUpdate').attr('type', 'submit').trigger('click')
                        } else {
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

            }
        },
        _clearForm(id = 0) {
            $container = $('#lsimg-'+id)
            $container.find('.dz-preview').remove()
            $container.removeClass('dz-started')
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
                new Switchery($('#switchery-0')[0], $('#switchery-0').data());
            }
        },
        initDropzone(id = 0) {
            var vm = this
            Dropzone.autoDiscover = false;
            this.myDropzone = new Dropzone(".dropzone", {
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
                        if(json.error == 0) {
                            let data = json.data
                            lsObj.$set(vm.item.detail_images, json.data.id, json.data)
                            
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
                        shop.ajax_popup('product/remove-file', 'POST', {id: file.id}, function(json){
                            if(json.error == 0) {
                                lsObj.$delete(vm.lsItem[vm.item.sku]['detail_images'], file.id)
                                $('#data-hide-'+vm.item.sku).find('input[name="lsPro['+vm.item.sku+'][images]['+file.id+']"]').remove()
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

        },
        removeItem(id = false, sku = '') {
            console.log(id, sku)
            var vm = this
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
                    if(id > 0) {
                        shop.ajax_popup('product/delete-detail', 'POST', {id: id}, function(json){
                            if(json.error == 0) {
                                lsObj.$delete(vm.lsItem, sku)
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
                    }else {
                        lsObj.$delete(vm.lsItem, sku)
                        Swal.fire({
                            title: 'Xóa Thành Công',
                            type: "success",
                            showCancelButton: 0,
                            showConfirmButton: !0,
                            confirmButtonColor: "#3085d6",
                            confirmButtonClass: "btn btn-success mt-2 btn-sm",
                            buttonsStyling: !1,
                        });
                    }
                }
            });
        },
        revertItem(id = false, remove = true) {
            // remove: false => delete
            var title = "Bạn có chắc chắn muốn xóa bản ghi này?", confirmButtonText = "Vâng, Tôi muốn xóa!", titleDone = "Xóa Thành Công"
            if(remove) {
                title = "Bạn có chắc chắn muốn khôi phục bản ghi này?"
                titleDone = "Khôi Phục Thành Công"
                confirmButtonText = "Vâng, tôi muốn khôi phục"
            }
            Swal.fire({
                title: title,
                // text: "Lưu ý: dữ liệu bị xóa sẽ không thể phục hồi lại được!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonClass: "btn btn-success mt-2 btn-sm",
                cancelButtonClass: "btn btn-danger ml-2 mt-2 btn-sm",
                buttonsStyling: !1,
                confirmButtonText: confirmButtonText
            }).then(function (t) {
                if (t.value) {
                    shop.ajax_popup('product/delete', 'POST', {id: id, removed: remove}, function(json){
                        if(json.error == 0) {
                            Swal.fire({
                                title: titleDone,
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
        }
    }
});