
var app = new Vue({
    el: '#addLine',
    data() {
        return {
            lines: data_body,
            isShow: true
        }
    },
    mounted() {
        // $(document).ready(function(){
        for(i = 0; i < data_body.length; i++) {
            this.initSystem(i);
        }
        
        // });
    },
    methods: {
        addLine: function (line_index) {
            // console.log(line_index);
            this.isShow = true;
            this.lines.push(
                {value: "", method: "addLine"},
            );

            Vue.nextTick(function () {
                app.initSystem(line_index);
            });
        },
        initSystem: function(line_index) {
            shop.admin.system.ckEditor('body_poll_'+line_index, 100 + '%', 500, 'moono',[
                ['Undo','Redo','-'],
                ['Bold','Italic','Underline','Strike'],
                ['Link','Unlink','Anchor'],['Image','Youtube','Table'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                '/',
                ['Font','FontSize', 'Format'],
                ['TextColor','BGColor','SelectAll','RemoveFormat'],['PasteFromWord','PasteText'],['Subscript','Superscript','SpecialChar'],['Source'],['ImgUploadBtn']
            ],false,'uploadify_'+line_index);
            shop.multiupload_ele('body_poll_'+line_index,'','#uploadify_'+line_index);
        },
        trashElement: function (index) {
            if(this.lines.length > 1) {
                this.lines.splice(index, 1);
                
            }else {
                this.isShow = false
                return this.lines[0] = ''
            }
        },
        handleSubmit() {
            event.preventDefault();
            var vm = this;
            var newMember = vm.lines
            if(vm.lines) {
                axios.post('/api/abc', newMember)
                .then(resp => {
                    this.$router.push({path: '/'});
                    console.log(resp);
                    // vm.lines.push(resp)
                })
                .catch(function(resp) {
                    console.log(resp);
                    alert("Không thể tạo thành viên mới.");
                })
            }
        }
    },
});


