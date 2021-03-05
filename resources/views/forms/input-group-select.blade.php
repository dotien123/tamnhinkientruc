<div class="form-group {{@$group['class']}}">
    <label @if(@$field['label-title']) title="{{@$field['label-title']}}" @endif>{{$field['label']}}</label>
    @if(!$preview)
        <select @if(@$field['attr'])
                    @foreach($field['attr'] as $at)
                        {{ $at['key'] }} = {{ $at['value'] }}
                    @endforeach
                @endif
                @if(@$field['data-toggle'])
                {{@$field['data-toggle']}}
                @else
                data-toggle="select2"
                @endif
                {{@$field['multiple']}}
                @if(@$field['name'])
                @if(@$field['multiple'])
                name="{{@$field['name'].'[id][]'}}"
                @else
                name="{{@$field['name']}}"
                @endif
                @else name="obj[{{$field['key']}}][id]" @endif
                @if(@$field['disabled'])
                {{@$field['disabled']}}
                @endif
                class="form-control">

            @if(isset($field['options']) && is_array($field['options']))
                @if(!isset($field['value']))
                    @php($field['value']= @$obj[$field['key']])
                @endif
                @if(isset($placeholder))
                    <option value="0">{{ $placeholder }}</option>
                @endif
                @if(@$field['attr'])
                    @foreach($field['attr'] as $at)
                        {{ $at['key'] }} = '{{ @$at['value'] }}'
                    @endforeach
                @endif
                @foreach($field['options'] as $item)
                    <option
                            @if(@$item['id'] == @$data)
                            selected
                            @endif
                            value="{{@$item['id']}}">{{@$item['title']}}</option>
                @endforeach
            @endif
        </select>
    @else
        <div class="text-primary">
            @if(isset($field['options']) && is_array($field['options']))
                @if(!isset($field['value']))
                    @php($field['value']= @$obj[$field['key']])
                @endif
                @foreach($field['options'] as $item)
                    <span> @if(@$item['value'] == @$data || @$item['id'] == @$data) {{@$item['title']?:'Chưa lựa chọn'}} @break @endif </span>
                @endforeach
            @endif
            {{--@if(isset($field['value_preview']))
                {!! $field['value_preview'] !!}
            @else
                {{isset($field['value'])?value_show($field['value'],'Chưa cập nhật'):value_show(@$obj[$field['key']],'Chưa cập nhật')}}
            @endif--}}
        </div>

    @endif
</div>