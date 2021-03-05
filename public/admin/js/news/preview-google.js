const preview = new Vue({
    el: '#pre-google',

    data: {
        input: news.title,
        alias: news.alias,
        id: news.id,
        isShow: false
    },
    computed: {
        slug: function () {
            return this.slugify(this.input)
        }
    },

    methods: {
        changeSlug: function () {
            var el = $('#sample-permalink');
            $('#sample-permalink a').remove();
            el.append(ENV.PUBLIC_URL + '<input type="text" id="new-post-slug" class="fs-13" style="width: 527px;" value="'+ this.alias +'" autocomplete="off">');
            return this.isShow = true;

        },
        slugEdit: function () {
            return this.alias = this.slugify(this.input);
        },
        cancel: function () {
            let val = this.alias;
            $('#sample-permalink').empty().append('<strong>Liên kết tĩnh: </strong> <a href="'+ ENV.PUBLIC_URL + val +'" target="_blank"> '+ ENV.PUBLIC_URL +'  <span id="editable-post-name">'+ val +'</span></a>')
            return this.isShow = false;
        },
        save: function (type = 'news') {
            var vm = this;
            vm.alias =  vm.slugify($('#new-post-slug').val());
            let val = vm.alias;
            $('#sample-permalink').empty().append('<strong>Liên kết tĩnh: </strong> <a href="'+ ENV.PUBLIC_URL + val +'" target="_blank"> '+ ENV.PUBLIC_URL +'  <span id="editable-post-name">'+ val +'</span></a>')

            if(vm.alias) {
                axios.post(ENV.BASE_URL+'ajax/'+type+'/alias', {
                    alias: val,
                    id: vm.id,
                })
                    .then(resp => {

                        console.log(resp);
                        // vm.lines.push(resp)
                    })
                    .catch(function(resp) {
                        console.log(resp);
                        alert("Không thể tạo thành viên mới.");
                    })
            }
            return vm.isShow = false;
        },
        slugify (title) {
            var slug = "";
            // Change to lower case
            var titleLower = title.toLowerCase();
            slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
            slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a')
                .replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o')
                .replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u')
                .replace(/ị|í|ì|ỉ|ĩ/gi, 'i')
                .replace(/ý|ỵ|ỳ|ỷ|ỹ/gi, 'y')
                .replace(/đ/gi, 'd')
                .replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '')
                .replace(/\-\-\-\-\-/gi, '-')
                .replace(/\-\-\-\-/gi, '-')
                .replace(/\-\-\-/gi, '-')
                .replace(/\-\-/gi, '-');
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '').replace(/\s+/g, '-');
            return slug;
        }
    }
});