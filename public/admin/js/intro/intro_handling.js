
const advantages = new Vue({
    el: '#advantages',
    data() {
        return {
            data: {
                val: advantages_data != '' ? JSON.parse(advantages_data) :  [{image_advantages:'', img_advantages_name:'', title_advantages:'', content_advantages:''}],
            },
            item: [
                {value: "", method: "addLine"}
            ],
            isShow: true,
            objDefault: [{image_advantages:'', img_advantages_name:'', title_advantages:'', content_advantages:''}]
        }
    },
    mounted(){
        // $('.dropify').dropify();
    },
    methods: {
        getIMG: function(event, value, item){
            var input = event.target;
            if (input.files && input.files[0]) {
                item.img_advantages_name = input.files[0].name;
                var reader = new FileReader();
                reader.onload = (e) => {
                    item.image_advantages = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        },
        addLine: function () {
            this.isShow = true;
            return this.data.val.unshift({image_advantages:'', img_advantages_name:'', title_advantages:'', content_advantages:''});
        },
        trashLine: function (topic_props,index) {
            if(topic_props.length > 1) {
                topic_props.splice(index, 1);
            }else {
                topic_props.splice(index, 1);
                return topic_props.unshift({image_advantages:'', img_advantages_name:'', title_advantages:'', content_advantages:''});
            }
        },
    },
});
// const highlights = new Vue({
//     el: '#highlights',
//     data() {
//         return {
//             data: {
//                 val: highlights_data != '' ? JSON.parse(highlights_data) : [{image_highlights:'', img_highlights_name:'', title_highlights:'', content_highlight:''}],
//             },
//             item: [
//                 {value: "", method: "addLine"}
//             ],
//             isShow: true,
//             objDefault: [{image_highlights:'', img_highlights_name:'', title_highlights:'', content_highlight:''}]
//         }
//     },
//     mounted(){
//         $('.dropify').dropify();
//     },
//     methods: {
//         getIMG: function(event, value, item){
//             var input = event.target;
//             if (input.files && input.files[0]) {
//                 item.img_highlights_name = input.files[0].name;
//                 var reader = new FileReader();
//                 reader.onload = (e) => {
//                     item.image_highlights = e.target.result;
//                 }
//                 reader.readAsDataURL(input.files[0]);
//             }
//         },
//         addLine: function () {
//             this.isShow = true;
//             return this.data.val.push({image_highlights:'', img_highlights_name:'', title_highlights:'', content_highlight:''});
//         },
//         trashLine: function (topic_props,index) {
//             if(topic_props.length > 1) {
//                 topic_props.splice(index, 1);
//             }else {
//                 topic_props.splice(index, 1);
//                 return topic_props.push({image_highlights:'', img_highlights_name:'', title_highlights:'', content_highlight:''});
//             }
//         },
//     },
// });
// const banner = new Vue({
//     el: '#banner',
//     data() {
//         return {
//             data: {
//                 val: banner_data != '' ? JSON.parse(banner_data) : [{image_banner:'', img_banner_name:'', title_banner:'', link_banner:''}],
//             },
//             item: [
//                 {value: "", method: "addLine"}
//             ],
//             isShow: true,
//             objDefault: [{image_banner:'', img_banner_name:'', title_banner:'', link_banner:''}]
//         }
//     },
//     mounted(){
//     },
//     methods: {
//         getIMG: function(event, value, item){
//             var input = event.target;
//             if (input.files && input.files[0]) {
//                 item.img_banner_name = input.files[0].name;
//                 var reader = new FileReader();
//                 reader.onload = (e) => {
//                     item.image_banner = e.target.result;
//                 }
//                 reader.readAsDataURL(input.files[0]);
//             }
//         },

//         addLine: function () {
//             this.isShow = true;
//             return this.data.val.push({image_banner:'', img_banner_name:'', title_banner:'', link_banner:''});
//         },
//         trashLine: function (topic_props,index) {
//             if(topic_props.length > 1) {
//                 topic_props.splice(index, 1);
//             }else {
//                 topic_props.splice(index, 1);
//                 return topic_props.push({image_banner:'', img_banner_name:'', title_banner:'', link_banner:''});
//             }
//         },
//     },
// });