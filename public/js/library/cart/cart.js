var app_cart = new Vue({
    // options content
    el: '#app_cart',
    data: {
        cart_items:[],
        filter_ids: {},
        total_items:0,
        total_cart:0,
        shipping_fee:0,
        grand_total:0,
        dropped : 0,
        toidongy:false,
        dccoupon: 0
    },
    mounted(){
        this.load();
        // this.loader();
        var coupon = $('#coupon').val();
        if(coupon != '') {
            pure_apply_coupon(coupon);
        }
    },
    computed: {
        
    },
    updated: function(){
        // this.load();
    },
    watch:{
        'loading':function(){
            // console.log(1)
        }
    },
    methods:{
        loader: function() {
            setTimeout(function() {
                if($('#pb_loader').length > 0) {
                    $('#pb_loader').removeClass('show');
                }
            }, 700);
        },
        show_loader: function() {
            if($('#pb_loader').length > 0) {
                $('#pb_loader').addClass('show');
            }
        },
        hide_loader: function() {
            if($('#pb_loader').length > 0) {
                $('#pb_loader').removeClass('show');
            }
        },
        returnPros: function(filter_id) {
            return list_filter[filter_id];
        },
        check_out_info: function(e) {
            window.location.href = e.target.getAttribute('data-link');
        },
        load:function() {
            $(window).bind('load', function () {
                $.ajax({
                    type: 'POST',
                    url: ENV.BASE_URL+"ajax/cart-load",
                    data: {_token:ENV.token},
                    dataType: 'json',
                }).done(function(json) {
                    if (json.error == 1) {
                        Swal.fire({
                            title: 'Thông báo',
                            text: json.msg,
                            type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26',
                        });
                    } else {
                        app_cart.cart_items = json.data.details;
                        app_cart.updatePriceToShow(json.data);
                        $('.cart-popup').show();
                        $('.qty-rece').text(json.data.number);
                        $('.qty-cart-show').html(json.data.number);
                        $('.qty-cart-show').show();
                    }
                })
            })

        },
        updatePriceToShow: function(data){
            this.total_cart = data.total;
            if(data.total > data.free_ship) {
                data.shipping_fee = 0;
            }else {
                data.shipping_fee = this.shipping_fee ;
            }
            var sum = 0
            data.details.forEach((item,index)=>{
                if(item.opt.po > 0){
                    sum += (item.opt.po*item.quan) - (item.price*item.quan)
                }
            })
            this.dropped = sum 
            this.grand_total = parseFloat(data.total) + parseFloat(this.shipping_fee);

            this.total_items = data.number;
            // alert(data.number);
            $('#total_cart_top').html(data.number);
            if(data.pass_min_order == 1) {

            }else {

            }
        },
        up_quan: function(e,item,index) {
            var fk = this
            e.preventDefault();
            for(let i in item.filter) {
                app_cart.$set(fk.filter_ids, i+'_id', item.filter[i]['id'])
            }
            fk.dccoupon = 0
            this.$nextTick(function () {
                $('#mgg').html('Không');
            });
            this.update(index, Number(item.quan)+1,item.quan,item);
        },
        down_quan: function(e,item,index) {
            var fk = this
            e.preventDefault();
            for(let i in item.filter) {
                app_cart.$set(fk.filter_ids, i+'_id', item.filter[i]['id'])
            }
            if(item.quan > 1 ) {
                fk.dccoupon = 0
                this.$nextTick(function () {
                    $('#mgg').html('Không');
                });
                this.update(index, Number(item.quan) - 1, item.quan, item);
            }
        },
        change_input: function(index,item,e) {
            this.update(index, item.filter, parseInt(e.target.value), item.quan, item);
        },
        update:function(index, quan,old_quan, item, opt){
            var fk = this
            if(quan > 0) {
                $.ajax({
                    type: 'POST',
                    url: ENV.BASE_URL+"ajax/cart-update",
                    data: {
                        _token:ENV.token,
                        index:index,
                        id:item.id,
                        filter_ids: fk.filter_ids,
                        quan:quan,
                        opt:opt
                    },
                    dataType: 'json',
                }).done(function(json) {
                    if (json.error == 1) {
                        Swal.fire({
                            title: 'Thông báo',
                            text: json.msg,
                            type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26',
                        });
                    } else {
                        item.quan = quan;
                        app_cart.cart_items = json.data.details;
                        app_cart.updatePriceToShow(json.data);
                        app_cart.shipping_fee=json.data.shipping_fee;
                        $('.cart-popup').show();
                        $('.qty-rece').text(json.data.number);
                        $('.qty-cart-show').html(json.data);
                        $('.qty-cart-show').show();
                    }
                });
            }else{
                item.quan = old_quan;
                Swal.fire({
                    title: 'Thông báo',
                    text: 'Số lượng sản phẩm không hợp lệ',
                    type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26',
                });
            }
        },
        remove: function(e,index,item){
            e.preventDefault();
            Swal.fire({
                title: 'Thông báo',
                text:'Bạn muốn loại sản phẩm này ra khỏi giỏ hàng?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41bb29',
                cancelButtonColor: '#f36f21',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Không',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: ENV.BASE_URL+"ajax/cart-remove",
                        data: {
                            _token:ENV.token,
                            index:index,
                            id:item.id,
                            filter:item.filter,
                        },
                        dataType: 'json',
                    }).done(function(json) {
                        if (json.error == 1) { 
                            Swal.fire({
                                title: 'Thông báo',
                                text: json.msg,
                                type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26',
                            });
                        } else {
                            app_cart.cart_items = json.data.details;
                            app_cart.updatePriceToShow(json.data);
                            $('.cart-popup').show();
                            $('.qty-rece').text(json.data.number);
                            $('.qty-cart-show').html(json.data);
                            $('.qty-cart-show').show();
                        }
                    });
                }
            });
        },
        wishlist: function(e,index,item){
            e.preventDefault();
            Swal.fire({
                title: 'Thông báo',
                text:'Bạn muốn thêm sản phẩm này vào WishList',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#41bb29',
                cancelButtonColor: '#f36f21',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Không',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: ENV.BASE_URL+"ajax/product-wishlist",
                        data: {
                            _token:ENV.token,
                            id:item.id,
                        },
                        dataType: 'json',
                    }).done(function(json) {
                        if (json.error == 1) {
                            Swal.fire({
                                title: 'Thông báo',
                                text: json.msg,
                                type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26',
                            });
                        } else {
                            Swal.fire({
                                title: 'Thông báo',
                                text: json.msg,
                                type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26',
                            });
                        }
                    });
                }
            });
        },
        formatPrice: function(value) {
            let val = (value/1).toFixed(0).replace('.', ',');
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        apply_coupon: function () {
            var fk = this
            var coupon = $('#coupon').val();
            if (coupon != '') {
                shop.ajax_popup('check-coupon', 'post', {
                    coupon: coupon,
                }, function (json) {
                    // $('#pb_loader').toggleClass('show');
                    if (json.error == 1) {
                        Swal.fire({
                            title: 'Thông báo',
                            text: json.msg,
                            type: 'warning',
                            confirmButtonText: 'Đồng ý',
                            confirmButtonColor: '#f37d26',
                        }).then((result) => {
                            if (result.value) {
                                if (isLogged == true) {} else {
                                    $('.js-click-login').click();
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Thông báo',
                            text: 'Áp dụng Coupon thành công!',
                            type: 'success',
                            confirmButtonText: 'Đồng ý',
                            confirmButtonColor: '#f37d26',
                        }).then((result) => {
                            fk.dccoupon = json.data.dccoupon
                            fk.grand_total = json.data.total_after_coupon
                            fk.shipping_fee = json.data.coupon_info.free_ship
                            // var is_free_ship = json.data.coupon_info.free_ship;
                            // var toto = shop.numberFormat(json.data.total_after_coupon);
                            // $('#co').html('<span class="">Số tiền đã giảm</span>\n' +
                            //     '            <span class="value"> - ' + dc + ' đ</span>');
                            // $('#to').html(toto + ' đ');
                            $('#mgg').html(json.data.coupon_info.coupon_code);
                            // $("#mgg").val(function () {
                            //     return this.value = json.data.coupon_info.coupon_code;
                            // });
                            // $("#coupon").val(function() {
                            //     return this.value + json.data.coupon_info.coupon_code;
                            // });
                            if (typeof json.data.coupon_info.coupon_code != 'undefined ') {
                                $('#showcou').removeClass('d-none');
                                $("#codecpuo").html('<span class="des" ><b>' + json.data.coupon_info.coupon_code + '</b></span>\n' +
                                    '<span class=" code-policy">- ' + (json.data.dccoupon > 0 ? dc : '') + (is_free_ship == 1 ? (json.data.dccoupon > 0 ? ' & ' : '') + 'Phí ship' : '') + '</span>');
        
                                if (is_free_ship == 1) {
                                    $('.delivery .value').html(0);
                                    var ship_fee = parseInt($('.delivery .value').attr('data-number'));
                                    var total = parseInt($('.pay .value').attr('data-number'));
        
                                    $('.pay .value').html(shop.priceFormat(total - ship_fee));
                                }
                            }
        
                            // shop.setGetParameter('coupon_code', json.data.coupon_code);
        
                        });
                    }
                });
            }else {
                fk.dccoupon = 0
                fk.grand_total = fk.total_cart
                fk.shipping_fee = 0
                // var is_free_ship = json.data.coupon_info.free_ship;
                // var toto = shop.numberFormat(json.data.total_after_coupon);
                // $('#co').html('<span class="">Số tiền đã giảm</span>\n' +
                //     '            <span class="value"> - ' + dc + ' đ</span>');
                // $('#to').html(toto + ' đ');
                $('#mgg').html('Không');
            }
        }
    }
});