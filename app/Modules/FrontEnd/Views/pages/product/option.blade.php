@if(!empty($data))
    @foreach ($data as $k => $v)
        <div class="col-4 project2">
            <a href="{{ route('project.detail', ['alias' => $v->alias, 'id' => $v->id]  ) }}">
            <img src="{{ \ImageURL::getImageUrl((@$v['image']), 'product', 'original') }}" alt="">
            </a>
        </div>
    @endforeach
@endif