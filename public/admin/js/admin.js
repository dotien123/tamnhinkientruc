shop.admin = {
    showChangePasswordForm: function() {
        var html = shop.join('<form class="form-horizontal" name="changePassword">')
            ('<div class="form-group row">')
                ('<label class="col-md-3 form-control-label" for="current_password">Mật khẩu cũ</label>')
                ('<div class="col-md-9">')
                    ('<input type="password" id="current_password" name="current_password" class="form-control" placeholder="Mật khẩu hiện tại...">')
                    ('<span class="invalid-feedback"></span>')
                ('</div>')
            ('</div>')
            ('<div class="form-group row">')
                ('<label class="col-md-3 form-control-label" for="new_password">Mật khẩu mới</label>')
                ('<div class="col-md-9">')
                    ('<input type="password" id="new_password" name="new_password" class="form-control" placeholder="Mật khẩu mới...">')
                    ('<span class="invalid-feedback"></span>')
                ('</div>')
            ('</div>')
            ('<div class="form-group row">')
                ('<label class="col-md-3 form-control-label" for="re_password">Nhập lại</label>')
                ('<div class="col-md-9">')
                    ('<input type="password" id="re_password" name="re_password" class="form-control" placeholder="Nhập lại mật khẩu mới...">')
                    ('<span class="invalid-feedback"></span>')
                ('</div>')
            ('</div>')
        ('</form>')();

        if($('#changePassword').length <= 0){
            html = shop.join
            ('<div class="modal" id="changePassword">')
                ('<div class="modal-dialog">')
                    ('<div class="modal-content">')
                        ('<div class="modal-header">')
                            ('<h4 class="modal-title">Thay đổi mật khẩu</h4>')
                            ('<button type="button" class="close" data-dismiss="modal">&times;</button>')
                        ('</div>')
                        ('<div class="modal-body">'+html+'</div>')
                        ('<div class="modal-footer">')
                            ('<button type="button" class="btn btn-success" onclick="shop.admin.changePassword()">Cập nhật</button>')
                            ('<button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>')
                        ('</div>')
                    ('</div>')
                ('</div>')
            ('</div>');
            $('body').append(html);
        }
        $('#changePassword').modal();
    },
    changePassword:function(){
        var obj = $('#changePassword'),
            curPass = $('#current_password', obj),
            newPass = $('#new_password', obj),
            rePass = $('#re_password', obj);

        $('.invalid-feedback').html('');
        $('.is-invalid').removeClass('is-invalid');

        //check old pass
        if (shop.is_blank($.trim(curPass.val()))) {
            curPass.addClass('is-invalid');
            $('.invalid-feedback', curPass.parent()).html('Vui lòng nhập mật khẩu cũ');
            return;
        }

        //check new pass
        if (shop.is_blank($.trim(newPass.val()))) {
            newPass.addClass('is-invalid');
            $('.invalid-feedback', newPass.parent()).html('Vui lòng nhập mật khẩu mới');
            return;
        } else if (newPass.val().length < 6) {
            newPass.addClass('is-invalid');
            $('.invalid-feedback', newPass.parent()).html('Mật khẩu mới phải có 6 kí tự trở lên');
            return;
        } else if (newPass.val() == curPass.val()) {
            newPass.addClass('is-invalid');
            $('.invalid-feedback', newPass.parent()).html('Mật khẩu mới phải khác mật khẩu cũ');
            return;
        }

        //check retype pass
        if (shop.is_blank($.trim(rePass.val()))) {
            rePass.addClass('is-invalid');
            $('.invalid-feedback', rePass.parent()).html('Vui lòng nhập lại mật khẩu mới');
            return;
        } else if (newPass.val() != rePass.val()) {
            rePass.addClass('is-invalid');
            $('.invalid-feedback', rePass.parent()).html('Nhập lại mật khẩu mới không khớp');
            return;
        }

        shop.ajax_popup('user/change-password', 'post', {
            old: $.trim(curPass.val()),
            new: $.trim(newPass.val())
        }, function(data) {
            $('.invalid-feedback').html('');
            $('.is-invalid').removeClass('is-invalid');
            if (data.error) {
                var getObject;
                switch (data.code) {
                    case 1:
                        getObject = curPass;
                        break;
                    case 2:
                        getObject = newPass;
                        break;
                }
                getObject.addClass('is-invalid');
                $('.invalid-feedback', getObject.parent()).html(data.msg);
            } else {
                $('#changePassword').modal('hide');
                alert(data.msg);
                shop.redirect(data.data['url']);
            }
        });
    },
    saveSlug: function() {
        let val = $('#new-post-slug').val();
        $('#sample-permalink').empty().append('<strong>Liên kết tĩnh: </strong> <a href="'+ ENV.PUBLIC_URL + val +'" target="_blank"> '+ ENV.PUBLIC_URL +'  <span id="editable-post-name">'+ val +'</span></a>')
        $('#change-slug').empty().append('<button class="change-slug position-relative btn" type="button" onclick="shop.admin.changeSlug()">Chỉnh sửa</button>')
    },
    changeSlug: function () {
        var el = $('#sample-permalink');
        var val = $('#editable-post-name').text();
        $('#sample-permalink a').remove();
        el.append(ENV.PUBLIC_URL + '<input type="text" id="new-post-slug" class="fs-13" style="width: 527px;" value="'+ val +'" autocomplete="off">');
        return $('#change-slug').empty().append('<button class="col-auto change-slug position-relative btn" type="button" onclick="shop.admin.saveSlug()">Ok</button> <a href="" class="fs-13">Hủy</a>');

    },
    actived: function() {
        setTimeout(function () {shop.ajax_popup('user/actived', 'GET')}, 1000);
    },
    activeUser: function(id, status){
        if(confirm('Bạn muốn ' + (status == 0 ? 'bỏ ':'') + 'kích hoạt với người dùng này ?')){
            shop.ajax_popup('user/user-active', 'POST', {id: id, status: status}, function(json){
                if(json.error == 0) {
                    shop.reload();
                }else{
                    alert(json.msg);
                }
            });
        }
    },
    getCat:function(type, def, lang, container){
        shop.ajax_popup('category/fetch-cat-lang', 'POST', {type: type, def: def, lang:lang}, function(json){
            if(json.error == 0) {
                $(container).html(json.data);
            }else{
                alert(json.msg);
            }
        });
    },
    setHot:function(id, show, type){
        shop.ajax_popup(type+'/hot', 'POST', {id: id, show: show ? 1 : 0}, function(json){
            if(json.error == 0) {
                $('#valid-feedback-'+id+' > a').remove();
                if(!show) {
                    $('#valid-feedback-'+id).append('<a href="javascript:;" onclick="shop.admin.setHot('+id+',true,\'product\')" class="text-info" title="Click để chọn sản phẩm ưa chuộng"><i class="fe-trending-up"></i></a>');
                }else{
                    $('#valid-feedback-'+id).append('<a href="javascript:;" onclick="shop.admin.setHot('+id+',false,\'product\')" class="text-danger" title="Sản phẩm ưa chuộng"><i class="fe-trending-up"></i></a>');
                }
            
            }else{
                alert(json.msg);
            }
        });
    },
    setHome:function(id, show, type){
        shop.ajax_popup(type+'/home', 'POST', {id: id, show: show ? 1 : 0}, function(json){
            if(json.error == 0) {
                $('#valid-feedback-home-'+id+' > a').remove();
                if(!show) {
                    $('#valid-feedback-home-'+id).append('<a href="javascript:;" onclick="shop.admin.setHome('+id+',true,\'product\')" class="text-info" title="Click để chọn sản phẩm nổi bật"><i class="fe-heart-on"></i></a>');
                }else{
                    $('#valid-feedback-home-'+id).append('<a href="javascript:;" onclick="shop.admin.setHome('+id+',false,\'product\')" class="text-danger" title="Hiển thị sản phẩm nổi bật ở trang chủ"><i class="fe-heart-on"></i></a>');
                    shop.reload();
                }

            }else{
                alert(json.msg);
            }
        });
    },
    copy:function(id, type){
        if(confirm('Bạn muốn copy nội dung?')) {
            shop.ajax_popup(type + '/copy', 'POST', {id: id}, function (json) {
                if (json.error == 0) {
                    shop.reload();
                } else {
                    alert(json.msg);
                }
            });
        }
    },
    // updateStatus:function(id, show, type){
    //     shop.ajax_popup(type+'/status', 'POST', {id: id, show: show ? 1 : 0}, function(json){
    //         if(json.error == 0) {
    //             shop.reload();
    //         }else{
    //             alert(json.msg);
    //         }
    //     });
    // },
    assignOrder: function (id, is_take, url, cancel = false) {
        let confirm_msg = "Bạn có chắc chắn muốn tiếp nhận đơn hàng này?";
        if(cancel) {
            confirm_msg = "Bạn có chắc chắn muốn bỏ tiếp nhận đơn hàng này?";
        }
        if (is_take === 0) {
            confirm_msg = "Bạn có chắc chắn muốn bỏ tiếp nhận đơn hàng này?";
        } else if (is_take === 3) {
            confirm_msg = "Bạn có chắc muốn lấy đơn hàng này!";
        } else if (is_take === 4) {
            confirm_msg = "Xác nhận lấy hàng thành công và bạn có muốn đưa vào xử lý ngay bây giờ không?";
        }else if (is_take === 5) {
            confirm_msg = "Bạn có chắc muốn giao đơn hàng này!";
        }else if (is_take === 6) {
            confirm_msg = "Giao hàng thành công!";
        }else if (is_take === -1) {
            confirm_msg = "Bạn có chắc chắn muốn hủy đơn hàng này?";
        }
        if (confirm(confirm_msg)) {
            shop.ajax_popup((url ? url : 'order/assign'), 'POST', {id: id, is_take: is_take}, function (json) {
                if (json.error == 0) {
                    alert((is_take === 0 || cancel == true)? "Bỏ tiếp nhận thành công!" : "Tiếp nhận thành công!");
                    shop.reload();
                } else {
                    alert(json.msg);
                }
            });
        }
    },
    system:{
        ckEditor: function (ele,width,height,theme,toolbar, css,id_img_btn) {
            css = css ? css : (ENV.BASE_URL + 'css/style_editor.css?v=1');
            var instance_ck = CKEDITOR.replace(ele ,
                {
                    toolbar : toolbar,
                    width: width,
                    height: height,
                    language : 'vi',
                    contentsCss: css
                });
            instance_ck.addCommand("mySimpleCommand", {
                exec: function(edt) {
                    var abc = $('#uploadifive-'+id_img_btn+' input');
                    if(typeof abc != 'undefined') {
                        $(abc[abc.length - 1]).click();
                    }
                }
            });
            instance_ck.ui.addButton('ImgUploadBtn', {
                type: 'button',
                label: "Upload ảnh lên chèn vào nội dung",
                command: 'mySimpleCommand',
                // toolbar: 'insert',
                icon: 'plugins/iconfinder_image_272698.png',
            });
        }
    },
    tags:{
        init_more:function (container){
            $(container).tagEditor({
                initialTags: $(container).val().split(','),
                sortable: false,
                forceLowercase: false,
                placeholder: '',
                onChange: function (field, editor, tags) {
                    $(field).val(tags.length ? tags.join(',') : '');
                }

            });
        },
        init: function(type, container, id, suggest, no_load_more){
            if(suggest || no_load_more) {
                $(container).tagEditor({
                    initialTags: $(container).val().split(','),
                    autocomplete: {
                        delay: 0, // show suggestions immediately
                        position: {collision: 'flip'}, // automatic menu position up/down
                        source: suggest ? suggest : []
                    },
                    sortable: false,
                    forceLowercase: false,
                    placeholder: '',
                    onChange: function (field, editor, tags) {
                        $(field).val(tags.length ? tags.join(',') : '');
                    },
                    beforeTagSave: function (field, editor, tags, tag, val) {
                        shop.admin.tags.add(val, type);
                    },
                    beforeTagDelete: function (field, editor, tags, val) {
                        var q = confirm('Xóa tag "' + val + '"?');
                        if (q) {
                            shop.admin.tags.remove(val, type, id);
                        }
                        return q;
                    }
                });
            }else{
                shop.admin.tags.loadSuggest(type, container, id);
            }
        },
        loadSuggest: function(type, container, id){
            shop.ajax_popup('tag/tag-suggest', 'POST', {type: type}, function(json){
                if(json.error == 0) {
                    shop.admin.tags.init(type, container, id, json.data, true);
                }else{
                    alert(json.msg);
                }
            });
        },
        add: function(tag, type){
            shop.ajax_popup('tag/tag-add', 'POST', {tag: tag, type: type}, function(json){
                if(json.error != 0) {
                    alert(json.msg);
                }
            });
        },
        remove: function(tag, type, id){
            shop.ajax_popup('tag/tag-del', 'POST', {tag: tag, type: type, id: id}, function(json){
                if(json.error != 0) {
                    alert(json.msg);
                }
            });
        }
    },
    api:{
        showLog: function(id){
            shop.ajax_popup('api-log', 'POST', {id: id}, function(json){
                if(json.error != 0) {
                    alert(json.msg);
                }else{
                    //update title
                    var data = json.data,
                        html = shop.join
                        ('<div><b>Request URL:</b> '+data.url+'</div>')
                        ('<div class="mt-2"><b>Call time:</b> '+data.created+'</div>')
                        ('<div class="mt-2"><b>Status:</b> '+(data.error ? '<span class="text-danger">Error</span>' : '<span class="text-success">Success</span>')+'</div>')
                        ('<div class="mt-2"><b>Params:</b></div>')
                        ('<div class="mt-2" style="word-wrap: break-word;">'+data.params+'</div>')
                        ('<div class="mt-2"><b>Return:</b></div>')
                        ('<div class="mt-2" style="word-wrap: break-word;">'+(data.error ? data.error : data.return)+'</div>')
                        ();
                    $('#primaryModal .modal-body').html(html);
                    $('#primaryModal').modal();
                }
            });
        }
    },
    previewVideo: function(id) {
        return $('#preview_videos').attr('src', 'https://www.youtube.com/embed/' + id).parent().addClass('d-block');
    },
    previewVideoAjax: function(id, type){
        shop.ajax_popup(type+'/load-video', 'POST', {id: id}, function(json){
            if(json.error == 0) {
                var data = json.data
                 return $('#preview_videos').attr('src', 'https://www.youtube.com/embed/' + data)
            }else{
                alert(json.msg);
            }
        });
    },
    addWidgetAjax: function(){
        var title = $('#wd-title').val(), cate = $('#wd-cate-id').val(), orderby = $('#wd-orderby').val(), display = $('#wd-display').val(), numpost = $('#wd-num-post').val();
        shop.ajax_popup('widget/add-widget', 'POST', {title: title, cate: cate, orderby: orderby, display: display, numpost: numpost}, function(json){
            if(json.error == 0) {
                var data = json.data
                 return $('#preview_videos').attr('src', 'https://www.youtube.com/embed/' + data)
            }else{
                alert(json.msg);
            }
        });
    },
    getDistrictsByProvinceId: function (type, district_id = null) {
        $('select[name="district_id"]').attr("disabled", true);
        let province_id = $('select[name="province_id"]').val();
        if (province_id !== '') {
            shop.ajax_popup(type + '/get_districts_by_province_id', 'POST',
                {
                    province_id: province_id,
                    district_id: district_id,
                }, function (json) {
                    if (json.error == 0) {
                        $('select[name="district_id"]').html(json.data).attr("disabled", false);
                        window.stop();
                    } else {
                        alert(json.msg);
                    }
                });
        }
    },
    removeImageCategory: function(id, type = '', dom){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                if (shop.is_num(id)){
                    shop.ajax_popup(type +'/removeImageCategory', 'POST',
                        {
                            id: id,
                        }, function(json){
                            if(json.error == 0) {
                                var el = document.getElementById(dom);
                                el.remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }else{
                                Swal.fire(
                                    'Oops..!',
                                    json.msg,
                                    'Error'
                                )
                            }
                        });
                } else{
                    Swal.fire(
                        'Oops..!',
                        'Error! An error occurred. Please try again later.',
                        'Error'
                    )
                }

            }
        })

    },
    updateStatus: function(type, id, show, field = 'status') {
        console.log(show, field);
        shop.ajax_popup(type+'/status', 'POST', {id: id, show: show ? 1 : 0, field: field}, function(json){
            if(json.error == 1) {
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
    checkAllAction:function(type, field, data_update){
        var arr_id = [];
        $.each($("input[name='checkbox-item-input[]']:checked"), function(){
            arr_id.push($(this).val());
        });
        Swal.fire({
            title: 'Bạn có chắc chắn thực hiện thao tác này?',
            text: "Tất cả bản ghi sẽ được thực thi ngay lập tức!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.value) {
                shop.ajax_popup(type+'/ajaxDeleteAll', 'POST', {arr_id: arr_id, type:type, field: field, data_update: data_update}, function(json){
                    if(json.error == 0) {
                        shop.reload();
                    }else{
                        alert(json.msg);
                    }
                });
            }
        })
    },
    revertItem: function(id = false, remove = true, type) {
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
                shop.ajax_popup(type+'/delete', 'POST', {id: id, removed: remove, type: type}, function(json){
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
    },
    notify:function(id){
        var time = 15 * 1000;
        if(id){
            clearTimeout(id);
        }else{
            id = setTimeout(function () {shop.admin.notify(id)}, 2000);
            return;
        }
        shop.ajax_popup('notify', 'GET', {}, function(json){
            id = setTimeout(function () {shop.admin.notify(id)}, time);
            if(json.error == 0) {
                var newTitle = document.title, total = 0;
                if(json.data.notify > 0) {
                    total = json.data.notify;
                    $('#alertNotify').html(json.data.notify).show();
                    if(json.data.order){
                        $('#newOrder .badge').html(json.data.order).show();
                    }
                    if(json.data.table){
                        $('#newTable .badge').html(json.data.table).show();
                    }
                }else{
                    $('#alertNotify').html(0).hide();
                    $('.dropdown-item .badge').html(0).hide();
                }
                if(newTitle.indexOf('(') > -1){
                    newTitle = newTitle.replace(/\([0-9]*\)/gi, total > 0 ? '('+total+')' : '');
                }else{
                    newTitle = (total > 0 ? '('+total+')' : '')+' '+newTitle;
                }
                document.title = newTitle
            }
        });
    },
    youtube_video_id: function(url){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        var match = url.match(regExp);
        return (match&&match[7].length==11)? match[7] : false;
    },
};
shop.ready.add(function (){
    $('.btn-disabled').click(function( event ) {
        event.preventDefault();
        $(this).attr("disabled", "disabled");
        $(this).parents('form:first').submit();
    });
    shop.admin.actived();
    $('.datepicker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
    });
    setTimeout(function(){
        $('div.alert.alert-success').hide();
    },2000);
    shop.admin.notify();
}, true);
