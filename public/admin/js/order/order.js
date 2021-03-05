if(typeof Vue != 'undefined') {
    var app = new Vue({
        // options content
        el: '#vue-order',
        data: {

        },
        mounted() {
        },
        methods: {

            priceFormat: function (p) {
                return shop.numberFormat(p) + ' ' + ENV.CURRENCY;
            },
            checkAll: function () {
                return $('.check-item').prop("checked", $('#checkAll').prop("checked"))
            },

            assignOrder: function (id, is_take, url) {
                let confirm_msg = "Bạn có chắc chắn muốn tiếp nhận đơn hàng này?";
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
                            alert(is_take === 0 ? "Bỏ tiếp nhận thành công!" : "Tiếp nhận thành công!");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmXacNhanThongtin: function (id,url) {
                if (confirm('Bạn muốn xác nhận đơn này đang xác thực thông tin')) {
                    shop.ajax_popup((url ? url : 'order/confirm_transport'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đơn hàng đã chuyển trạng thái đang xác thực thông tin");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmDangKetNoi: function (id,url) {
                if (confirm('Bạn muốn xác nhận đơn này đang trong quá trình kết nối?')) {
                    shop.ajax_popup((url ? url : 'order/confirm_transport'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đơn hàng đã chuyển trạng thái đang trong quá trình kết nối");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmThanhCong: function (id,url) {
                if (confirm('Bạn muốn xác nhận đơn này hoàn thành và giải ngân?')) {
                    shop.ajax_popup((url ? url : 'order/confirm_transport'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đơn hàng đã chuyển trạng thái hoàn thành và giải ngân");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmChooseOne: function (id,url) {
                if (confirm('Bạn muốn Chọn người cho vay này để giải ngân?')) {
                    shop.ajax_popup((url ? url : 'order/confirm_transport'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đã kết nối người cho vay và người vay!");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmChooseOneBreakup: function (id,url) {
                if (confirm('Bạn muốn Hủy kết nối này?')) {
                    shop.ajax_popup((url ? url : 'order/confirm_transport'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đã hủy kết nối thành công!");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmGiaiNgan: function (id,url) {
                if (confirm('Bạn muốn xác nhận giải ngân đơn này?')) {
                    shop.ajax_popup((url ? url : 'order/confirm_transport'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đã xác nhận thanh công!");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            confirmOrder: function (id,url) {
                if (confirm('Bạn muốn xác nhận đơn hàng này hoàn thành?')) {
                    shop.ajax_popup((url ? url : 'order/confirm'), 'POST', {id: id}, function (json) {
                        if (json.error == 0) {
                            alert("Đơn hàng đã được xác nhận hoàn thành");
                            shop.reload();
                        } else {
                            alert(json.msg);
                        }
                    });
                }
            },
            cancelOrder:function (id,url) {
                shop.ajax_popup((url ? url : 'order/cancel'), 'POST', {id: id}, function (json) {
                    if (json.error == 0) {
                        alert("Hủy đơn hàng thành công");
                        shop.reload();
                    } else {
                        alert(json.msg);
                    }
                });
            }
        }
    });
}

order = {};

order.refreshTotalPrice = function() {
    var total = 0;
    var inputs = $('input.quantity');
    if(inputs.length > 0) {
        inputs.each(function(i, obj) {
            total += $(obj).val()*$(obj).attr('data-price-origin')
        });

        $('#totalCart').html(shop.numberFormat(total)+' đ').attr('data-total',total);
        $('#grandTotal').html(shop.numberFormat(total+parseFloat($('#shippingFee').attr('data-shipping')))+' đ')
    }else {
        $('#totalCart').html(0);
        $('#grandTotal').html(0);
    }
    $('#temp_data_foods').val(getHtml($('#admin_book_cart')));
};

function getHtml(div) {
    div.find("input").each(function () {
        $(this).attr("value", $(this).val());
    });
    return div.html();
}
order.get_district = function(id,callback) {
    shop.ajax_popup('get-list-districts', 'post', {city_id:id}, function(json) {
        if(json.error == 1){
            alert(json.msg);
        }else {
            var i;
            var html = shop.join('<option value="">--Chọn Quận/huyện--</option>')();
            for(i in json.data){
                html += shop.join('<option value="'+json.data[i].id+'">'+json.data[i].title+'</option>')();
            }

            $('#district_id').html(html);
            if (shop.is_exists(callback)) {
                callback();
            }
        }
    });
};
order.get_ward = function(id,callback) {
    shop.ajax_popup('get-list-wards', 'post', {district_id:id}, function(json) {
        if(json.error == 1){
            alert(json.msg);
        }else {
            var i;
            var html = shop.join('<option value="">--Chọn phường--</option>')();
            for(i in json.data){
                html += shop.join('<option value="'+json.data[i].id+'">'+json.data[i].title+'</option>')();
            }

            $('#ward_id').html(html);
            if (shop.is_exists(callback)) {
                callback();
            }
        }
    });
};

order.toJSONString = function ( form ) {
    var obj = {};
    var elements = form.querySelectorAll("input, select, textarea");
    for (var i = 0; i < elements.length; ++i) {
        var element = elements[i];
        var name = element.name;
        var value = element.value;

        if (name) {
            obj[name] = value;
        }
    }

    return obj;
};

order.showModalCancelOrder = function (id) {
    $('#order_id').val(id);
    $('.popup-reason').modal('show');
};

order.showModalRefundOrder = function (id) {
    $('#order_id').val(id);
    $('.popup-refund-reason').modal('show');
};
order.showModalConfirmRefundOrder = function (id) {
    $('#order_id').val(id);
    $('.popup-confirm-refund').modal('show');
};

order.CancelOrder = function ( url ) {
    var id = $('#order_id').val();
    var reason = $('#reason').val();
    shop.ajax_popup((url ? url : 'order/cancel'), 'POST', {id: id,reason: reason}, function (json) {
        if (json.error == 0) {
            alert("Hủy đơn hàng thành công");
            shop.reload();
        } else {
            alert(json.msg);
        }
    });
};
order.RefundOrder = function ( url ) {
    var id = $('#order_id').val();
    var reason = $('#reason_refund').val();
    var refund_fee = $('#refund_fee').val();
    shop.ajax_popup((url ? url : 'order/refund'), 'POST', {id: id,reason: reason,refund_fee:refund_fee}, function (json) {
        if (json.error == 0) {
            alert("Yêu cầu hoàn đơn hàng thành công");
            shop.reload();
        } else {
            alert(json.msg);
        }
    });
};
order.ConfirmRefundOrder = function ( url ) {
    var id = $('#order_id').val();
    var note = $('#reason_note').val();
    shop.ajax_popup((url ? url : 'order/confirm-refund'), 'POST', {id: id,note: note}, function (json) {
        if (json.error == 0) {
            alert("Xác nhận hoàn đơn hàng thành công");
            shop.reload();
        } else {
            alert(json.msg);
        }
    });
};
order.DoneRefundOrder = function ( id,url ) {
    if (confirm('Bạn muốn hoàn thành hoàn tiền cho đơn hàng? Hãy chắc chắn đã hoàn tiền cho khách hàng.')) {
        shop.ajax_popup((url ? url : 'order/done-refund'), 'POST', {id: id}, function (json) {
            if (json.error == 0) {
                alert("Đơn hàng đã được hoàn tất quá trình hoàn tiền!");
                shop.reload();
            } else {
                alert(json.msg);
            }
        });
    }
};
