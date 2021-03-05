shop.login = function () {
    var email = $('#pop-email-login'),
        password = $('#pop-pw-login');
    if(shop.is_email(email.val())){
        if(password.val()!= ''){
            shop.ajax_popup('login', 'post', {
                email: $.trim(email.val()),
                password: $.trim(password.val())
            }, function(json) {
                if(json.error == 1){
                    alert(shop.authMsg(json.code));
                }else {
                    shop.reload();
                    // shop.popup.hide('loginModal', function () {
                    //     shop.redirect(data.data['url']);
                    // });
                }
            });
        }else{
            alert('Vui lòng nhập mật khẩu');
            password.focus();
        }
    }else {
        alert('Email không hợp lệ');
        email.focus();
    }
};

shop.checkComment = function(){
   
    var form = $('#checkComment').serializeArray(), result = [];
    $.each(form, function() {
        result[this.name] = this.value;
    });
    console.log(result);
    if(result['content'] && shop.is_str(result['content'])){
        if(result['fullname']){
            if(shop.is_str(result['fullname'])){
                if(result['phone']){
                    if(shop.is_phone(result['phone'])){
                            // send data
                                shop.ajax_popup('checkComment', 'post', {
                                form
                            }, function (json) {
                                var msg = json.msg;
                                if (json.error == 1) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oopss...!',
                                        text: msg,
                                    });
                                } else {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Cám ơn bạn đã bình luận!',
                                        text:   msg,
                                    }).then((re) => {
                                        if (re.value) {
                                            document.getElementById('checkComment').reset();
                                            $("input").removeClass('is-invalid');
                                            location.reload();
                                        }
                                    });
                                }
                            });
                        
                    }else{
                        $('#cmt_phone_1').addClass('is-invalid');
                        $('#cmt_phone_1').focus();
                        Swal.fire({
                            type: 'warning',
                            title: 'Thông báo',
                            text: 'Số điện thoại chưa đúng định dạng!',
                        });
                    }
                }else{
                    $('#cmt_phone_1').addClass('is-invalid');
                    $('#cmt_phone_1').focus();
                    Swal.fire({
                        type: 'warning',
                        title: 'Thông báo',
                        text: 'Bạn chưa nhập số điện thoại!',
                    });
                }
            }else{
                $('#cmt_name_1').addClass('is-invalid');
                $('#cmt_name_1').focus();
                Swal.fire({
                    type: 'warning',
                    title: 'Thông báo',
                    text: 'Họ và tên không đúng định dạng!',
                });
            }
        }else{
            $('#cmt_name_1').addClass('is-invalid');
            $('#cmt_name_1').focus();
            Swal.fire({
                type: 'warning',
                title: 'Thông báo',
                text: 'Bạn chưa nhập Họ và tên!',
            });
        }
    }else {
        $('#cmt_content').addClass('is-invalid');
        $('#cmt_content').focus();
        Swal.fire({
            type: 'warning',
            title: 'Thông báo',
            text: 'Hãy nhập nội dung!',
        });
    }
};


shop.register = function () {
    var form = $('#form-register').serializeArray();
    var result = [];
    $.each(form, function () {
        result[this.name] = $.trim(this.value);
    });
    if(result['user_name']){
        if(shop.is_username(result['user_name'])){
            if(shop.is_email(result['email'])){
                if(result['fullname']!= ''){
                    if(shop.is_phone(result['phone'])){
                        if(result['password']!= ''){
                            if(result['password'].length >= 8){
                                if(result['password'] === result['re-pwd']){
                                    shop.ajax_popup('register' , 'post' , {
                                        form
                                    }, function (json) {
                                        if (json.error == 1) {
                                            var msg = json.code;
                                            Swal.fire({
                                                type: 'error',
                                                title: 'Oopss...!',
                                                text: msg,
                                            });
                                        } else {
                                            Swal.fire({
                                                type: 'success',
                                                title: 'Thành công',
                                                text: 'Đăng ký nhận tin thành công.',
                                            }).then((re) => {
                                                if (re.value) {
                                                    // document.getElementById('subscribe').reset()
                                                }
                                            });
                                        }
                                    })
                                }else{
                                    alert('Xác thực mật khẩu không khớp');
                                    $('#pop-re-pwd').focus();
                                }
                            }else{
                                alert('Mat khau phai nhieu hon 8 ky tu');
                                $('#pop-pwd').focus();
                            }
                        }else{
                            alert('Mật khẩu không được để trống');
                            $('#pop-pwd').focus();
                        }
                    }else{
                        alert('Số điện thoại không đúng định dạng');
                        $('#pop-phone').focus();
                    }
                }else{
                    alert('Họ tên không được để trống');
                    $('#pop-fullname').focus();
                }
            }else{
                alert('Email không hợp lệ');
                $('#pop-email').focus();
            }
        }else {
            alert('User không hợp lệ');
            $('#pop-username').focus();
        }
    }else{
        alert('User không để trống');
        $('#pop-username').focus();
    }

};
shop.subscribe = function(){
    var form = $('#subscribe').serializeArray(), result = [];
    $.each(form, function() {
        result[this.name] = this.value;
    });
    console.log(result);
    if(result['fullname']){
        if(shop.is_str(result['fullname'])){
            if(result['phone']){
                if(shop.is_phone(result['phone'])){
                    if(result['email']){
                        if(shop.is_email(result['email'])){
                            // send data
                                shop.ajax_popup('subscribe', 'post', {
                                form
                            }, function (json) {
                                var msg = json.msg;
                                if (json.error == 1) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oopss...!',
                                        text: msg,
                                    });
                                } else {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Thành công',
                                        text:   'Chúng tôi sẽ liên hệ với Bạn trong thời gian sớm nhất!',
                                    }).then((re) => {
                                        if (re.value) {
                                            document.getElementById('subscribe').reset();
                                            $("input").removeClass('is-invalid');
                                            grecaptcha.reset();
                                        }
                                    });
                                }
                            });
                        }else{
                            $('#email_1').addClass('is-invalid');
                            $('#email_1').focus();
                            Swal.fire({
                                type: 'warning',
                                title: 'Thông báo',
                                text: 'Email chưa đúng đinh dạng!',
                            });
                        }
                    }else{
                        $('#email_1').addClass('is-invalid');
                        $('#email_1').focus();
                        Swal.fire({
                            type: 'warning',
                            title: 'Thông báo',
                            text: 'Bạn chưa nhập email!',
                        });
                    }
                }else{
                    $('#phone_1').addClass('is-invalid');
                    $('#phone_1').focus();
                    Swal.fire({
                        type: 'warning',
                        title: 'Thông báo',
                        text: 'Số điện thoại chưa đúng định dạng!',
                    });
                }
            }else{
                $('#phone_1').addClass('is-invalid');
                $('#phone_1').focus();
                Swal.fire({
                    type: 'warning',
                    title: 'Thông báo',
                    text: 'Bạn chưa nhập số điện thoại!',
                });
            }
        }else{
            $('#name_1').addClass('is-invalid');
            $('#name_1').focus();
            Swal.fire({
                type: 'warning',
                title: 'Thông báo',
                text: 'Họ và tên không đúng định dạng!',
            });
        }
    }else{
        $('#name_1').addClass('is-invalid');
        $('#name_1').focus();
        Swal.fire({
            type: 'warning',
            title: 'Thông báo',
            text: 'Bạn chưa nhập Họ và tên!',
        });
    }

};

shop.subscribe2 = function(){
    var form = $('#subscribe2').serializeArray(), result = [];
    $.each(form, function() {
        result[this.name] = this.value;
    });
    console.log(result['fullname']);
    if(result['fullname']){
        if(shop.is_str(result['fullname'])){
            if(result['phone']){
                if(shop.is_phone(result['phone'])){
                    if(result['email']){
                        if(shop.is_email(result['email'])){
                            // send data
                                shop.ajax_popup('subscribe', 'post', {
                                form
                            }, function (json) {
                                var msg = json.msg;
                                if (json.error == 1) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oopss...!',
                                        text: msg,
                                    });
                                } else {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Thành công',
                                        text:   'Chúng tôi sẽ liên hệ với Bạn trong thời gian sớm nhất!',
                                    }).then((re) => {
                                        if (re.value) {
                                            document.getElementById('subscribe2').reset();
                                            $("input").removeClass('is-invalid');
                                            grecaptcha.reset();
                                        }
                                    });
                                }
                            });
                        }else{
                            $('#email_1').addClass('is-invalid');
                            $('#email_1').focus();
                            Swal.fire({
                                type: 'warning',
                                title: 'Thông báo',
                                text: 'Email chưa đúng đinh dạng!',
                            });
                        }
                    }else{
                        $('#email_1').addClass('is-invalid');
                        $('#email_1').focus();
                        Swal.fire({
                            type: 'warning',
                            title: 'Thông báo',
                            text: 'Bạn chưa nhập email!',
                        });
                    }
                }else{
                    $('#phone_1').addClass('is-invalid');
                    $('#phone_1').focus();
                    Swal.fire({
                        type: 'warning',
                        title: 'Thông báo',
                        text: 'Số điện thoại chưa đúng định dạng!',
                    });
                }
            }else{
                $('#phone_1').addClass('is-invalid');
                $('#phone_1').focus();
                Swal.fire({
                    type: 'warning',
                    title: 'Thông báo',
                    text: 'Bạn chưa nhập số điện thoại!',
                });
            }
        }else{
            $('#name_1').addClass('is-invalid');
            $('#name_1').focus();
            Swal.fire({
                type: 'warning',
                title: 'Thông báo',
                text: 'Họ và tên không đúng định dạng!',
            });
        }
    }else{
        $('#name_1').addClass('is-invalid');
        $('#name_1').focus();
        Swal.fire({
            type: 'warning',
            title: 'Thông báo',
            text: 'Bạn chưa nhập Họ và tên!',
        });
    }

};

shop.subscribe3 = function(){
    var form = $('#subscribe3').serializeArray(), result = [];
    $.each(form, function() {
        result[this.name] = this.value;
    });
    console.log(result['fullname']);
    if(result['fullname']){
        if(shop.is_str(result['fullname'])){
            if(result['phone']){
                if(shop.is_phone(result['phone'])){
                    if(result['email']){
                        if(shop.is_email(result['email'])){
                            if(result['content'] && shop.is_str(result['content'])){
                                // send data
                                    shop.ajax_popup('subscribe', 'post', {
                                    form
                                }, function (json) {
                                    var msg = json.msg;
                                    if (json.error == 1) {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oopss...!',
                                            text: msg,
                                        });
                                    } else {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Thành công',
                                            text:   'Chúng tôi sẽ liên hệ với Bạn trong thời gian sớm nhất!',
                                        }).then((re) => {
                                            if (re.value) {
                                                document.getElementById('subscribe3').reset();
                                                $("input").removeClass('is-invalid');
                                                grecaptcha.reset();
                                                location.reload();
                                            }
                                        });
                                    }
                                });
                            }else {
                                $('#textbox_1').addClass('is-invalid');
                                $('#textbox_1').focus();
                                Swal.fire({
                                    type: 'warning',
                                    title: 'Thông báo',
                                    text: 'Hãy nhập nội dung!',
                                });
                            }
                        }else{
                            $('#email_1').addClass('is-invalid');
                            $('#email_1').focus();
                            Swal.fire({
                                type: 'warning',
                                title: 'Thông báo',
                                text: 'Email chưa đúng đinh dạng!',
                            });
                        }
                    }else{
                        $('#email_1').addClass('is-invalid');
                        $('#email_1').focus();
                        Swal.fire({
                            type: 'warning',
                            title: 'Thông báo',
                            text: 'Bạn chưa nhập email!',
                        });
                    }
                }else{
                    $('#phone_1').addClass('is-invalid');
                    $('#phone_1').focus();
                    Swal.fire({
                        type: 'warning',
                        title: 'Thông báo',
                        text: 'Số điện thoại chưa đúng định dạng!',
                    });
                }
            }else{
                $('#phone_1').addClass('is-invalid');
                $('#phone_1').focus();
                Swal.fire({
                    type: 'warning',
                    title: 'Thông báo',
                    text: 'Bạn chưa nhập số điện thoại!',
                });
            }
        }else{
            $('#name_1').addClass('is-invalid');
            $('#name_1').focus();
            Swal.fire({
                type: 'warning',
                title: 'Thông báo',
                text: 'Họ và tên không đúng định dạng!',
            });
        }
    }else{
        $('#name_1').addClass('is-invalid');
        $('#name_1').focus();
        Swal.fire({
            type: 'warning',
            title: 'Thông báo',
            text: 'Bạn chưa nhập Họ và tên!',
        });
    }

};

shop.subscribeContribute = function(){
    var data = $('#subscribe-contribute').serializeArray(), result = [];
    $.each(data, function() {
        result[this.name] = this.value;
    });
    if(result['fullname']){
        if(shop.is_str(result['fullname'])){
            if(result['address']){
                if(result['phone']){
                    if(shop.is_phone(result['phone'])){
                                // send data
                                shop.ajax_popup('subscribe-contribute', 'post', {
                                    data
                                }, function (json) {
                                    var msg = json.msg;
                                    if (json.error == 1) {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oopss...!',
                                            text: msg,
                                        });
                                    } else {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Thành công',
                                            text:   'Chúng tôi sẽ liên hệ với Bạn trong thời gian sớm nhất!',
                                        }).then((re) => {
                                            if (re.value) {
                                                document.getElementById('subscribe-contribute').reset();
                                                $("input").removeClass('is-invalid');
                                            }
                                        });
                                    }
                                });
                            
                        
                    }else{
                        $('#phone_2').addClass('is-invalid');
                        $('#phone_2').focus();
                        Swal.fire({
                            type: 'warning',
                            title: 'Thông báo',
                            text: 'Số điện thoại chưa đúng định dạng!',
                        });
                    }
                }else{
                    $('#phone_2').addClass('is-invalid');
                    $('#phone_2').focus();
                    Swal.fire({
                        type: 'warning',
                        title: 'Thông báo',
                        text: 'Bạn chưa nhập số điện thoại!',
                    });
                }
            }else{
                $('#adress_2').addClass('is-invalid');
                $('#adress_2').focus();
                Swal.fire({
                    type: 'warning',
                    title: 'Thông báo',
                    text: 'Bạn chưa nhập địa chỉ!',
                });
            }
        }else{
            $('#name_2').addClass('is-invalid');
            $('#name_2').focus();
            Swal.fire({
                type: 'warning',
                title: 'Thông báo',
                text: 'Họ và tên không đúng định dạng!',
            });
        }
    }else{
        $('#name_2').addClass('is-invalid');
        $('#name_2').focus();
        Swal.fire({
            type: 'warning',
            title: 'Thông báo',
            text: 'Bạn chưa nhập Họ và tên!',
        });
    }
};

// mua trả góp
shop.moneySale = function(){
    // var response = grecaptcha.getResponse();
    // if (response.length == 0) {
    //     Swal.fire({
    //         type: 'warning',
    //         title: 'Thông báo',
    //         text: 'Hãy xác nhận bạn không phải người máy!',
    //     });
    //     evtpreventDefault();
    //     return false;
    // }
  
    var form = $('#subscribeMoney').serializeArray(), result = [];
    $.each(form, function() {
        result[this.name] = this.value;
    });

    if(result['gia_xe']){
    if(result['lai_suat'] ){
        if(result['tra_truoc']!= 0){
                if(result['fullname']){
                    if(shop.is_str(result['fullname'])){
                        if(result['phone']){
                            if(shop.is_phone(result['phone'])){
                                if(result['email']){
                                    if(shop.is_email(result['email'])){
                                        // send data
                                            shop.ajax_popup('subscribeSale', 'post', {
                                            form
                                        }, function (json) {
                                            var msg = json.msg;
                                            if (json.error == 1) {
                                                Swal.fire({
                                                    type: 'error',
                                                    title: 'Oopss...!',
                                                    text: msg,
                                                });
                                            } else {
                                                Swal.fire({
                                                    type: 'success',
                                                    title: 'Thành công',
                                                    text:   'Chúng tôi sẽ liên hệ với Bạn trong thời gian sớm nhất!',
                                                }).then((re) => {
                                                    if (re.value) {
                                                        document.getElementById('subscribeMoney').reset();
                                                        $("input").removeClass('is-invalid');
                                                        // grecaptcha.reset();
                                                        location.reload();
                                                    }
                                                });
                                            }
                                        });
                                    }else{
                                        $('#email_sale').addClass('is-invalid');
                                        $('#email_sale').focus();
                                        Swal.fire({
                                            type: 'warning',
                                            title: 'Thông báo',
                                            text: 'Email chưa đúng đinh dạng!',
                                        });
                                    }
                                }else{
                                    $('#email_sale').addClass('is-invalid');
                                    $('#email_sale').focus();
                                    Swal.fire({
                                        type: 'warning',
                                        title: 'Thông báo',
                                        text: 'Bạn chưa nhập email!',
                                    });
                                }
                            }else{
                                $('#phoneby_sale').addClass('is-invalid');
                                $('#phoneby_sale').focus();
                                Swal.fire({
                                    type: 'warning',
                                    title: 'Thông báo',
                                    text: 'Số điện thoại chưa đúng định dạng!',
                                });
                            }
                        }else{
                            $('#phoneby_sale').addClass('is-invalid');
                            $('#phoneby_sale').focus();
                            Swal.fire({
                                type: 'warning',
                                title: 'Thông báo',
                                text: 'Bạn chưa nhập số điện thoại!',
                            });
                        }
                    }else{
                        $('#nameby_sale').addClass('is-invalid');
                        $('#nameby_sale').focus();
                        Swal.fire({
                            type: 'warning',
                            title: 'Thông báo',
                            text: 'Họ và tên không đúng định dạng!',
                        });
                    }
                }else{
                    $('#nameby_sale').addClass('is-invalid');
                    $('#nameby_sale').focus();
                    Swal.fire({
                        type: 'warning',
                        title: 'Thông báo',
                        text: 'Bạn chưa nhập Họ và tên!',
                    });
                }
            }else{
                $('#tra_truoc').addClass('is-invalid');
                $('#tra_truoc').focus();
                Swal.fire({
                    type: 'warning',
                    title: 'Thông báo',
                    text: 'Bạn chưa nhập số tiền trả trước!',
                });
            }
        }else{
            $('#lai_suat').addClass('is-invalid');
            $('#lai_suat').focus();
            Swal.fire({
                type: 'warning',
                title: 'Thông báo',
                text: 'Bạn chưa nhập lãi xuất!',
            });
        }
    }else{
        $('#gia_xe').addClass('is-invalid');
        $('#gia_xe').focus();
        Swal.fire({
            type: 'warning',
            title: 'Thông báo',
            text: 'Bạn chưa nhập giá xe!',
        });
    }

};

// mua trả góp

shop.changeCustomerPassword = function(){
    var curPass = $('#current_password'),
        newPass = $('#new_password'),
        rePass = $('#re_password');

    $('.feedback').html('');
    $('.is-invalid').removeClass('is-invalid');

    //check old pass
    console.log(curPass.parent());
    if (shop.is_blank($.trim(curPass.val()))) {
        // nếu chưa nhâp thì vào đây
        curPass.addClass('is-invalid');
        $('.feedback', curPass.parent()).html('Vui lòng nhập mật khẩu cũ');
        return;
    }

    //check new pass
    if (shop.is_blank($.trim(newPass.val()))) {
        newPass.addClass('is-invalid');
        $('.feedback', newPass.parent()).html('Vui lòng nhập mật khẩu mới');
        return;
    } else if (newPass.val().length < 8) {
        newPass.addClass('is-invalid');
        $('.feedback', newPass.parent()).html('Mật khẩu mới phải có 8 kí tự trở lên');
        return;
    } else if (newPass.val() == curPass.val()) {
        newPass.addClass('is-invalid');
        $('.feedback', newPass.parent()).html('Mật khẩu mới phải khác mật khẩu cũ');
        return;
    }

    //check retype pass
    if (shop.is_blank($.trim(rePass.val()))) {
        rePass.addClass('is-invalid');
        $('.feedback', rePass.parent()).html('Vui lòng nhập lại mật khẩu mới');
        return;
    } else if (newPass.val()!= rePass.val()) {
        rePass.addClass('is-invalid');
        $('.feedback', rePass.parent()).html('Nhập lại mật khẩu mới không khớp');
        return;
    }
    shop.ajax_popup('change-password', 'post', {
        oldPassword: $.trim(curPass.val()),
        newPassword: $.trim(newPass.val()),
        password_confirm : $.trim(rePass.val()),
    }, function(json) {
        $('.feedback').html('');
        if (json.error == 1) {
            var msg = shop.authMsg(json.code);
            if(msg == '') {
                for(var i in json.code){
                    msg += json.code[i] + '\n';
                }
            }
            alert(msg);
        } else {
            shop.redirect(json.data['url']);
        }
    });
}

shop.changeProfle = function(){
    var form = $('#form-change-profile').serializeArray();
    var result = [];
    $.each(form, function () {
        result[this.name] = $.trim(this.value);
    });
    if(shop.is_email(result['email'])){
        if(result['fullname']!= ''){
            if(shop.is_phone(result['phone'])){
                shop.ajax_popup('change-profile' , 'post' , {
                    form
                }, function (json) {
                    if (json.error == 1) {
                        var msg = json.code;
                        Swal.fire({
                            type: 'error',
                            title: 'Oopss...!',
                            text: msg,
                        });
                    } else {
                        Swal.fire({
                            type: 'success',
                            title: 'Thành công',
                            text: 'Cập nhật thông tin thành công.',
                        }).then((re) => {
                            if (re.value) {
                                // document.getElementById('subscribe').reset()
                            }
                        });
                    }
                })
            }else{
                alert('Số điện thoại không đúng định dạng');
                $('#phone').focus();
            }
        }else{
            alert('Họ tên không được để trống');
            $('#fullname').focus();
        }
    }else{
        alert('Email không hợp lệ');
        $('#email').focus();
    }
};

shop.authMsg = function ($code) {
    switch ($code){
        case 'LOGIN_FAIL': return 'Sai tên đăng nhập hoặc mật khẩu';
        case 'BANNED': return 'Tài khoản đã bị vô hiệu, không thể đăng nhập';
        case 'NOT_ACTIVE': return 'Tài khoản chưa được kích hoạt';
        case 'NOT_EXISTED': return 'Email không hợp lệ';
        case 'LOGINED': return 'Đã đăng nhập thành công trước đó';
        case 'EXISTED': return 'Email không hợp lệ';
    }
    return '';
};

shop.getCat = function(type, def, lang, container) {
    shop.ajax_popup('category/fetch-cat-lang', 'POST', {type: type, def: def, lang:lang}, function(json){
        if(json.error == 0) {
            $(container).html(json.data);
        }else{
            alert(json.msg);
        }
    });
}

shop.loadProcess = function(id, type = ''){
    shop.ajax_popup(type+'load-process', 'POST', {id: id}, function(json){
        if(json.error == 0) {
            var data = json.data,
                html = shop.join
                ('<figure class="m-0">')
                ('<img class="w-100" src="'+data.image+'" alt="">')
                ('</figure>')
                ();
                $('#quy-trinh-1').empty();
                $('#quy-trinh-1').append(html);
                $('#content').empty();
                $('#content').append(data.body);
        }else{
            alert(json.msg);
        }
    });
},

shop.system = {
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
                if(typeof abc!= 'undefined') {
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
};
shop.actived = function() {
    setTimeout(function () {shop.ajax_popup('user/actived', 'GET')}, 1000);
};
shop.tags = {
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
                    shop.tags.add(val, type);
                },
                beforeTagDelete: function (field, editor, tags, val) {
                    var q = confirm('Xóa tag "' + val + '"?');
                    if (q) {
                        shop.tags.remove(val, type, id);
                    }
                    return q;
                }
            });
        }else{
            shop.tags.loadSuggest(type, container, id);
        }
    },
    loadSuggest: function(type, container, id){
        shop.ajax_popup('tag-suggest', 'POST', {type: type}, function(json){
            if(json.error == 0) {
                shop.tags.init(type, container, id, json.data, true);
            }else{
                alert(json.msg);
            }
        });
    },
    add: function(tag, type){
        shop.ajax_popup('tag-add', 'POST', {tag: tag, type: type}, function(json){
            if(json.error!= 0) {
                alert(json.msg);
            }
        });
    },
    remove: function(tag, type, id){
        shop.ajax_popup('tag-del', 'POST', {tag: tag, type: type, id: id}, function(json){
            if(json.error!= 0) {
                alert(json.msg);
            }
        });
    }
},
shop.ready.add(function (){
    shop.actived();
    $('.datepicker').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true
    });
}, true);

shop.bookMsg = function ($code) {
    switch ($code){
        case 'BOOK_FAIL': return 'Vui lòng điền đầy đủ thông tin cần thiết';
        case 'BANNED': return 'Tài khoản đã bị vô hiệu, không thể đăng nhập';
        case 'NOT_ACTIVE': return 'Tài khoản chưa được kích hoạt';
        case 'NOT_EXISTED': return 'Email không hợp lệ';
        case 'LOGINED': return 'Đã đăng nhập thành công trước đó';
        case 'EXISTED': return 'Email không hợp lệ';
    }
    return '';
};

shop.book = function () {
    let email = $('#bok-email'),
        phone = $('#bok-phone');
        user_name = $('#bok-name');
        address = $('#bok-address');
        option = $('#bok-option');
        coupon = $('#bok-coupon');
        opt_detail = $('#bok-opt-detail');

    if(shop.is_phone(phone.val())){
        if(user_name.val()!= ''){
            if (option.val()!= -1) {
                shop.ajax_popup('book', 'post', {
                    email: $.trim(email.val()),
                    phone: $.trim(phone.val()),
                    user_name: $.trim(user_name.val()),
                    opt_detail: (opt_detail) ?  $.trim(opt_detail.val()) : '',
                    address: $.trim(address.val()),
                    option: $.trim(option.val()),
                    coupon: $.trim(coupon.val()),
                }, function(json) {
                    if(json.error == 1){
                        alert(shop.bookMsg(json.code));
                    }else {
                        Swal.fire({
                            type: 'success',
                            title: 'Thành Công',
                            text: 'Bạn đã đặt dịch vụ thành công!',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            confirmButtonText: 'ok',
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                shop.reload();
                            },
                        });
                    }
                });
            } else {
                alert('Vui lòng chọn dịch vụ bạn muốn!');
                option.focus();
            }

        }else{
            alert('Vui lòng nhập họ tên');
            user_name.focus();
        }
    }else {
        alert('Số điện thoại không hợp lệ');
        phone.focus();
    }

}


shop.get_district = function(id,callback,type=0) {
    if(type==0){
        shop.ajax_popup('list-districts', 'post', {province_id:id}, function(json) {
            if(json.error == 1){
                $.alertable.alert(json.msg);
            }else {
                var i;
                var html = shop.join('<option value="">Chọn Quận/Huyện</option>')();
                for(i in json.data){
                    html += shop.join('<option value="'+json.data[i].id+'">'+json.data[i].Name_VI+'</option>')();
                }

                $('#selectDistrict').html(html);
                if (shop.is_exists(callback)) {
                    callback();
                }
            }
        });
    }
};

shop.get_ward = function(id,callback) {
    shop.ajax_popup('list-ward', 'post', {district_id:id}, function(json) {
        if(json.error == 1){
            $.alertable.alert(json.msg);
        }else {
            var i;
            var html = shop.join('<option value="">Chọn Xã/Phường</option>')();
            for(i in json.data){
                html += shop.join('<option value="'+json.data[i].id+'">'+json.data[i].Name_VI+'</option>')();
            }

            $('#selectWard').html(html);
            if (shop.is_exists(callback)) {
                callback();
            }
        }
    });
};

shop.getPriceTabService = function ($id) {
    let email = $('#bok-email'),
        phone = $('#bok-phone');
        user_name = $('#bok-name');
        address = $('#bok-address');
        option = $('#bok-option');
        coupon = $('#bok-coupon');

    if(shop.is_phone(phone.val())){
        if(user_name.val()!= ''){
            if (option.val()!= -1) {
                shop.ajax_popup('getPriceTabService', 'post', {
                    email: $.trim(email.val()),
                    phone: $.trim(phone.val()),
                    user_name: $.trim(user_name.val()),
                    address: $.trim(address.val()),
                    option: $.trim(option.val()),
                    coupon: $.trim(coupon.val()),
                }, function(json) {
                    if(json.error == 1){
                        alert(shop.bookMsg(json.code));
                    }else {
                        Swal.fire({
                            type: 'success',
                            title: 'Thành Công',
                            text: 'Bạn đã đặt dịch vụ thành công!',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            confirmButtonText: 'ok',
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                shop.reload();
                            },
                        });
                    }
                });
            } else {
                alert('Vui lòng chọn dịch vụ bạn muốn!');
                option.focus();
            }

        }else{
            alert('Vui lòng nhập họ tên');
            user_name.focus();
        }
    }else {
        alert('Số điện thoại không hợp lệ');
        phone.focus();
    }

}

var Member = {
    /***
     * Lay template form login
     * @param innerElement
     */
    getLoginForm: function (innerElement) {
        shop.ajax_popup('/member/login/get-template', [], function (json) {
            if (typeof json.data!== 'undefined') {
                if (typeof json.data.template!== 'undefined') {
                    document.getElementById(innerElement).innerHTML = json.data.template;
                }
            }
        });
    },
    showLoginForm: function () {
        $('#registerForm').modal('hide');

        $('#loginForm').modal('show');

    },
    doLogin: function (form) {
        var data = jQuery(form).serializeArray();
        var result = [];
        $.each(data , function () {
            result[this.name] = this.value;
        });
        if(result['userOrEmail']!= ''){
            if(result['password']!= ''){
                shop.ajax_popup('login', 'post', data, function (json) {
                    console.log(json);
                    if (typeof json.data!== 'undefined') {
                        if (json.error == 0) {
                            // window.location.reload();
                            alert("Thanh cong");
                        } else {
                            alert(shop.authMsg(json.code));
                        }
                    } else {
                        if (typeof json.msg === 'undefined') {
                            alert('Đăng nhập không thành công. Vui lòng liên hệ admin để được hỗ trợ: 0886.509.919');
                        } else {
                            alert(shop.authMsg(json.code));
                        }

                    }
                });
            }else{
                alert('Hẳn là không nhập mật khẩu luôn!')
            }
        }else{
            alert('Email không để trống!');
        }
    },
    doRegister: function (form) {
        var data = jQuery(form).serializeArray();
        console.log(data);
        shop.ajax_popup('register', 'post', data, function (json) {
            if (json.error == 0) {
                window.location.reload();
            }else {
                alert(shop.authMsg(json.code));
            }
        });
    },

};

// function apply_coupon() {
//     var coupon = $('#coupon').val();
//     if (coupon!= '') {
//         shop.ajax_popup('check-coupon', 'post', {
//             coupon: coupon,
//         }, function (json) {
//             // $('#pb_loader').toggleClass('show');
//             if (json.error == 1) {
//                 Swal.fire({
//                     title: 'Thông báo',
//                     text: json.msg,
//                     type: 'warning',
//                     confirmButtonText: 'Đồng ý',
//                     confirmButtonColor: '#f37d26',
//                 }).then((result) => {
//                     if (result.value) {
//                         if (isLogged == true) {} else {
//                             $('.js-click-login').click();
//                         }
//                     }
//                 });
//             } else {
//                 Swal.fire({
//                     title: 'Thông báo',
//                     text: 'Áp dụng Coupon thành công!',
//                     type: 'success',
//                     confirmButtonText: 'Đồng ý',
//                     confirmButtonColor: '#f37d26',
//                 }).then((result) => {
//                     var dc = shop.numberFormat(json.data.dccoupon);
//                     var is_free_ship = json.data.coupon_info.free_ship;
//                     var toto = shop.numberFormat(json.data.total_after_coupon);
//                     $('#co').html('<span class="">Số tiền đã giảm</span>\n' +
//                         '            <span class="value"> - ' + dc + ' đ</span>');
//                     $('#to').html(toto + ' đ');
//                     $('#mgg').html(json.data.coupon_info.coupon_code);
//                     // $("#mgg").val(function () {
//                     //     return this.value = json.data.coupon_info.coupon_code;
//                     // });
//                     // $("#coupon").val(function() {
//                     //     return this.value + json.data.coupon_info.coupon_code;
//                     // });
//                     if (typeof json.data.coupon_info.coupon_code!= 'undefined ') {
//                         $('#showcou').removeClass('d-none');
//                         $("#codecpuo").html('<span class="des" ><b>' + json.data.coupon_info.coupon_code + '</b></span>\n' +
//                             '<span class=" code-policy">- ' + (json.data.dccoupon > 0 ? dc : '') + (is_free_ship == 1 ? (json.data.dccoupon > 0 ? ' & ' : '') + 'Phí ship' : '') + '</span>');

//                         if (is_free_ship == 1) {
//                             $('.delivery .value').html(0);
//                             var ship_fee = parseInt($('.delivery .value').attr('data-number'));
//                             var total = parseInt($('.pay .value').attr('data-number'));

//                             $('.pay .value').html(shop.priceFormat(total - ship_fee));
//                         }
//                     }

//                     // shop.setGetParameter('coupon_code', json.data.coupon_code);

//                 });
//             }
//         });
//     }
// }

function pure_apply_coupon(coupon) {
    if (coupon!= '') {
        shop.ajax_popup('check-coupon', 'post', {
            coupon: coupon,
        }, function (json) {
            // $('#pb_loader').toggleClass('show');
            if (json.error == 1) {

            } else {
                var dc = shop.numberFormat(json.data.dccoupon.dccoupon);
                var is_free_ship = json.data.dccoupon.free_ship;
                var toto = shop.numberFormat(json.data.total_after_coupon);
                $('#co').html('<span class="">Số tiền đã giảm</span>\n' +
                    '            <span class="value"> - ' + dc + '</span>');
                $('#to').html(toto);
                $("#cpu").val(function () {
                    return this.value = json.data.coupon_info.coupon_code;
                });
                // $("#coupon").val(function() {
                //     return this.value + json.data.coupon_info.coupon_code;
                // });
                if (typeof json.data.coupon_info.coupon_code!= 'undefined ') {
                    $('#showcou').removeClass('d-none');
                    $("#codecpuo").html('<span class="des" ><b>' + json.data.coupon_info.coupon_code + '</b></span>\n' +
                        '<span class=" code-policy">- ' + (json.data.dccoupon.dccoupon > 0 ? dc : '') + (is_free_ship == 1 ? (json.data.dccoupon.dccoupon > 0 ? ' & ' : '') + i18n.site.phiship : '') + '</span>');

                    if (is_free_ship == 1) {
                        $('.delivery .value').html(0);
                        var ship_fee = parseInt($('.delivery .value').attr('data-number'));
                        var total = parseInt($('.pay .value').attr('data-number'));

                        $('.pay .value').html(shop.priceFormat(total - ship_fee));
                    }
                }
            }
        });
    }
}
