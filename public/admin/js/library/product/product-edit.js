const app_service = new Vue({
    el: '#product-field-add',

    data: {

        service: service,
        isTable: false
    },

    methods: {
        addService: function (e) {
            switch (e) {
                case 'name':
                    this.service.name.push('');
                    let serLeng = this.service.value.length
                    if (serLeng > 0) {
                        for (i = 0; i < serLeng; i++) {
                            this.service.value[i].push('')
                        }
                    }
                    break;
                case 'val':
                    this.service[0].val.push('');
                    break;
            }
        },
        del (index, name) {
            var vm = this

            if (confirm('Bạn có chắc chắn muốn thực hiện thao tác này!')) {
                switch (name) {
                    case 'service':
                        vm.$delete(vm.service.name, index)
                        let serLeng = this.service.name.length
                        if (serLeng > 0) {
                            for (i = 0; i < serLeng; i++) {
                                vm.$delete(vm.service.value[i], index)
                            }
                        }
                        break;
                    case 'setTrValue':
                        vm.$delete(vm.service.value, index)
                        break;
                }
            }
        },
        clickCreateValue: function () {
            var vm = this;
            var serLeng = vm.service.name.length
            if (serLeng > 0) {
                let arr = []
                for (i = 0; i < serLeng; i++) {
                    arr[i] = '';
                }
                vm.service.value.push(arr);
                return vm.isTable = true;
            }
        },
        clickCreateRowValue: function () {
            var vm = this;
            let arr = []
            if (vm.service.value.length > 0) {
                for (i = 0; i < vm.service.name.length; i++) {
                    arr[i] = '';
                }
                return vm.service.value.push(arr);
            }
        }
    }
});