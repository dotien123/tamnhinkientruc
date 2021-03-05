

jQuery(document).ready(function(){
    // Summernote
    $('#product-description').summernote({
        height: 580,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,                 // set focus to editable area after initializing summernote
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                that = $(this);
                sendFile(files[0], editor, welEditable);
            }
        }
    });

    $('#sort_desc').summernote({
        height: 150,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,                 // set focus to editable area after initializing summernote
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48' , '64'],
        lang: 'vi-VI',
        imageTitle: {
            specificAltField: true,
        },
        blockquoteBreakingLevel: 2,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['paragraph']],
            ['insert', ['link']],
            ['height', ['height']],
            ['undo', ['undo']],
            ['redo', ['redo']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                that = $(this);
                sendFile(files[0], editor, welEditable);
            }
        }
    });

    $('#description').summernote({
        height: 580,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,                 // set focus to editable area after initializing summernote
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                that = $(this);
                sendFile(files[0], editor, welEditable);
            }
        }
    });

    $('#content').summernote({
        height: 100+'%',                 // set editor height
        minHeight: 880,             // set minimum height of editor
        maxHeight: 100+'%',             // set maximum height of editor
        focus: false,                 // set focus to editable area after initializing summernote
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48' , '64'],
        lang: 'vi-VI',
        imageTitle: {
            specificAltField: true,
        },
        blockquoteBreakingLevel: 2,
        popover: {
            image: [
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']],
                ['custom', ['imageTitle']],
            ],
        },
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['height', ['height']],
            ['undo', ['undo']],
            ['redo', ['redo']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                that = $(this);
                sendFile(files[0], editor, welEditable);
            }
        }
    });

    $('#product-content').summernote({
        height: 580,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: 100+'%',             // set maximum height of editor
        focus: false,                 // set focus to editable area after initializing summernote
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                that = $(this);
                sendFile(files[0], editor, welEditable);
            }
        }
    });
    function sendFile(file, editor, welEditable) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: "POST",
            url: ENV.BASE_URL+'ajax/file/upload-file',
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                console.log(url, url.data.image)

                $(that).summernote('insertImage', url.data.image, '')
                // editor.insertImage(welEditable, url.image);
                // alert(url.data.image);
            }
        });
    }

});