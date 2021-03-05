@if (isset($project_cate) && !empty($project_cate))
    @foreach ($project_cate as $key => $item)
        <div class="description">
            <div class="year">{{ $item->year ? $item->year :  \Carbon\Carbon::now()->format('Y') }}</div>
            <div class="title"><a href="{{ route('project.detail', ['alias' => $v->alias, 'id' => $v->id]  ) }}">{{ $item->title }}</a></div>
            <div class="location">{{ $item->location }}</div>
            <div class="category">{{ $item->category->title ?? 'Đang cập nhật' }}</div>
        </div>
    @endforeach
@endif