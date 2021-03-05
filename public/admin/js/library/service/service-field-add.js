const app_service = new Vue({
    el: '#service-field-add',

    data: {

        service: [''],
        setThValue: [],
        setTdValue: '',
        setTrValue: [],
        isTable: false
    },

    methods: {
        addService: function (e) {
            switch (e) {
                case 'name':
                    this.service.push('');
                    let serLeng = this.service.length
                    if (serLeng > 0) {
                        for (i = 0; i < serLeng; i++) {
                            this.setTrValue[i].push('')
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
                        vm.$delete(vm.service, index)
                        let serLeng = this.service.length
                        if (serLeng > 0) {
                            for (i = 0; i < serLeng; i++) {
                                vm.$delete(vm.setTrValue[i], index)
                            }
                        }
                        break;
                    case 'setTrValue':
                        vm.$delete(vm.setTrValue, index)
                        break;
                }
            }
        },
        clickCreateValue: function () {
            var vm = this;
            var thLeng = vm.setThValue.length
            var serLeng = vm.service.length
            if (vm.service.length > 0) {
                if (thLeng != serLeng) {
                    vm.setThValue = vm.service;
                }

                let arr = []
                for (i = 0; i < vm.setThValue.length; i++) {
                    arr[i] = '';
                }
                vm.setTrValue.push(arr);
                return vm.isTable = true;
            }
        },
        clickCreateRowValue: function () {
            var vm = this;
            let arr = []
            if (vm.service.length > 0) {
                for (i = 0; i < vm.setThValue.length; i++) {
                    arr[i] = '';
                }
                return vm.setTrValue.push(arr);
            }
        }
    }
});