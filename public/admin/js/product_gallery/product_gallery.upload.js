shop.updateScriptData = function(controller){
    jQuery('#uploadify_hotel_img').uploadifive('destroy');
    shop.multiupload_hotel_img(controller);
};
var arr_ids = [];
shop.multiupload_hotel_img = function(controller){
    var oobject_id = jQuery('#gallery-object_id').val();
    var counting_completed = 0, counting_on_queue = 0;
    var config = {
        'uploadScript' : ENV.BASE_URL+'ajax/'+controller+'/upload_img',
        'formData' : {
            'object_id': oobject_id,
            'type':controller,
            '_token': ENV.token,
            'lang': jQuery('#filter-lang').val()
        },
        'buttonText' : 'CHỌN ẢNH',
        'fileType'     : 'image/*',
        // 'fileObjName'   : 'img_files',
        'onError': function(file, errorCode, errorMsg, errorString) {
            alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
        },
        'onUploadComplete' : function(file, data, response) {
            var myObject;
            try {
                myObject = eval('(' + data + ')');
            } catch (e) {
                alert('Lỗi hệ thống upload ' + data);
                return;
            }

            if(oobject_id != '') {
                if (myObject.error == 0) {
                    counting_completed++;

                    if(counting_completed == counting_on_queue) {
                        app.listImages(myObject.data.images, true);
                    }
                } else {
                    alert(file.name + "\nError !!! " + myObject.msg);
                }
            }else {
                if(typeof myObject.data.id != 'undefined') {
                    arr_ids.push(myObject.data.id);
                    $('#img_upload_for_add').val(arr_ids.join(','));
                }
                return true;
            }
        },
        'onAddQueueItem' : function(file) {
            counting_on_queue ++;
        }
    };

    if(oobject_id == '') {
        // config.auto = false;
        config.fadeAfterupload = false;
    }

    jQuery('#uploadify_hotel_img').uploadifive(config);
};