const lsObj = new Vue({
    el: '#lsObj',
    data() {
        return {
            lsOrders: Object.assign({}, lsOrders),
            isShowDeleteAll: false
        }
    },
    methods: {
        _save(step = [], id = 0) {
            step['order_id'] = id
            Swal.fire({
                title: 'Cập nhật tình trạng đơn',
                text: 'Xác nhận chuyển đơn sang trạng thái ' + step.text,
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
                    shop.ajax_popup('order/save', 'POST', step, function(json){
                        if(json.error == 0) {
                            Swal.fire({
                                title: 'Cập nhật thành công',
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
        _delele() {
            $('.delete-all-checked').click(function () { 
                var order_ids = [];
                $.each($("input.item-check[type='checkbox']:checked"), function(){
                    order_ids.push($(this).data('id'));
                });
                Swal.fire({
                title: 'Xóa đơn hàng',
                text: 'Xác nhận chuyển tất cả đơn đã chọn sang trạng thái Đã xóa',
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
                        shop.ajax_popup('order/delete', 'POST', {ids: order_ids}, function(json){
                            if(json.error == 0) {
                                Swal.fire({
                                    title: 'Cập nhật thành công',
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
            });
        }
    }
});