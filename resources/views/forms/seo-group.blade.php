<div class="col-md-12">
    <div class="form-group">
        <label for="image_seo">Ảnh seo</label>
        <input type="file" class="dropify" data-default-file="{{ isset($obj) ? $obj->getImageSeoUrl('image_seo', $key, 'original') : '' }}" name="image_seo"  />
    </div>
</div>
<div class="col-md-12">
    @include('forms/input-group-text',[
        'placeholder'=>'Tiêu đề seo','field'=>[
            'label'=>'Tiêu đề seo','name'=>'title_seo', 'key'=>'title_seo', 'class' => 'placement',
            'attr' => [
               ['key' => 'maxlength', 'value' => '160'],
            ]
        ],
    ])

</div>
<div class="col-md-12">
    @include('forms/input-group-textarea',[
        'field'=>[
            'label'=>'Từ khóa','name'=>'keywords', 'key'=>'keywords', 'class' => 'seo' ,'note' => 'Mỗi từ khóa cách nhau bởi dấu phẩy', 'classNote' => 'text-warning d-block',
        ],
    ])

</div>
<div class="col-md-12">
    @include('forms/input-group-textarea',[
        'placeholder'=>'Mô tả seo ở đây','field'=>[
            'label'=>'Mô tả seo','name'=>'description_seo', 'key'=>'description_seo', 'class' => 'seo' ,'id' => 'textarea',
            'attr' => [
               ['key' => 'maxlength', 'value' => '160'],
            ]
        ],
    ])
</div>
<div class="col-md-12">
    @include('forms/input-group-select',[
    'data' => (@$obj->robots) ? @$obj->robots : 4,
    'field'=>[
        'label'=>'Robots','name'=>'robots', 'key'=>'robots', 'id' => 'robots', 'note' => '*', 'classNote' => 'text-warning',
        'options'=> \Lib::robotSEO(),
    ]])
</div>
