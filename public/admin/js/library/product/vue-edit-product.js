const app_service = new Vue({
    el: '#product-field-add',

    data: {
        properties: JSON.parse(news.properties),
        isTable: false
    },
    methods: {
        addProperty: function (e) {
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
                case 'properties':
                    this.properties.push({
                        title: '', value: ''
                    });
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
                    case 'properties':
                        vm.$delete(vm.properties, index)
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