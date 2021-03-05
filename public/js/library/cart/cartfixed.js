var app_cart = new Vue({
    // options content
    el: '#cart-fixed-right',
    data: {
        cart_items:[],
        total_items:0,
        total_cart:0,
        shipping_fee:0,
        grand_total:0,
        dropped : 0
    },
    mounted(){
        this.load();
    },
    computed: {

    },
    updated: function(){

    },
    created() {
        
    },
    methods:{
        returnPros: function(filter_id) {
            return list_filter[filter_id];
        },
        load:function() {
            $.ajax({
                type: 'POST',
                url: ENV.BASE_URL+"ajax/cart-load",
                data: {_token:ENV.token},
                dataType: 'json',
                async:true,
            }).done(function(json) {
        
                if (json.error == 1) {
                    Swal.fire({
                        title: 'Thông báo',
                        text: json.msg,
                        type: 'warning',confirmButtonText: 'Đồng ý',confirmButtonColor: '#f37d26', 
                    });
                } else {
                    app_cart.shipping_fee=json.data.shipping_fee;
                    app_cart.cart_items = json.data.details;
                    app_cart.updatePriceToShow(json.data);
                    if ($(".cart-fixed-wrap").length > 0) {
                        window.onclick = function (event) {
                           if ($(event.target).hasClass("cart-fixed-wrap")) {
                              handleHideCartFixed();
                           }
                        }
                        $("#close_cart_fixed").click(function () {
                           handleHideCartFixed();
                        });
                     }
                     function handleHideCartFixed() {
                        if ($(".cart-fixed-wrap").length > 0) {
                           $(".cart-fixed-wrap").removeClass('show');
                           $(".cart-fixed").removeClass('show');
                           $(".utilities").removeClass('d-none');
                           setTimeout(function () { $(".cart-fixed-wrap").addClass("d-none"); }, 100);
                        }
                     }
                     
                     if ($(".utilities .cart").length > 0 && $(".cart-fixed-wrap").length > 0) {
                        $(".utilities .cart").click(() => {
                           $(".cart-fixed-wrap").addClass('show');
                           $(".cart-fixed-wrap").removeClass('d-none');
                           $(".cart-fixed").addClass('show');
                     
                           $(".utilities").addClass('d-none');
                        });
                     
                     }
                    
                }
            })
        },
        updatePriceToShow: function(data){
            this.total_cart = data.total;
            // var sum = 0
            // data.details.forEach((item,index)=>{
            //     if(item.opt.po > 0){
            //         if(data.total > data.free_ship) {
            //             sum += (item.opt.po*item.quan) - (item.price*item.quan)
            //         }
            //     }
            // })
            // if(data.total > data.free_ship) {
            //     this.shipping_fee = 0;
            //     // sum += ( parseInt(data.shipping_fee))
            //     this.dropped = sum
            // }else {
            //     this.shipping_fee = parseInt( data.shipping_fee);
            //     this.dropped = sum
            // }
            // var sum = 0




            this.grand_total = parseFloat(data.total) + parseFloat(this.shipping_fee);

            this.total_items = data.number;
            $('#total_cart_top').html(data.number);
            $('.qty-rece').html(data.number);
            if(data.pass_min_order == 1) {

            }else {

            }
        },
        up_quan: function(e,item,index) {
            e.preventDefault();
            this.update(index,item.filter_key,item.quan+1,item.quan,item);
        },
        down_quan: function(e,item,index) {
            e.preventDefault();
            if(item.quan > 1 ) {
                this.update(index, item.filter_key, item.quan - 1, item.quan, item);
            }
        },
        change_input: function(index,item,e) {
            this.update(index, item.filter_key, parseInt(e.target.value), item.quan, item);
        },
        update:function(index,filter_key, quan,old_quan, item, opt){
            if(quan > 0) {
                $.ajax({
                    type: 'POST',
                    url: ENV.BASE_URL+"ajax/cart-update",
                    data: {
                        _token:ENV.token,
                        index:index,
                        id:item.id,
                        filter_key:filter_key,
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
                            filter_key:item.filter_key,
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
                            if(json.data.number == 0){
                                // $('#icon-cart-pop').removeClass('bounce-3');
                                // $('#icon-cart-pop').removeClass('cart-buyed');
                                $('.qty-cart-show').hide()
                                $('.qty-rece').html('0')
                            }
                        }
                    });
                }
            });
        },
        formatPrice: function(value) {
            let val = (value/1).toFixed(0).replace('.', ',');
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    }
});