<div class="form-group {{@$group['class']}}">
    <label @if(@$field['id']) for="{{ @$field['id'] }}"  @else for="obj-{{@$field['key']}}"  @endif>{{@$field['label']}} <span class="{{@$field['classNote']}}">{{ @$field['note'] }}</span></label>
    @if(!$preview)
        <div class="controls">
        @if(is_array(@$obj[$field['key']]))
            <input
                    @if(@$field['name'])
                    name="{{@$field['name']}}"
                    @else name="obj[{{$field['key']}}]" @endif

                    {{ @$field['disabled'] }}
                    type="{{ @$field['type']?@$field['type']:'text' }}"
                    class="form-control {{ @$field['class'] }}"


                    value="{{isset($field['value']) ?$field['value']:@$obj[$field['key']]}}"
                    placeholder="{{@$placeholder}}">
        @else
            <input  @if(@$field['name'])
                     name="{{@$field['name']}}"
                     @else name="obj[{{$field['key']}}]" @endif
                     type="{{@$field['type']?@$field['type']:'text'}}"
                     @if(@$field['id']) id="{{ @$field['id'] }}"  @else id="obj-{{@$field['key']}}"  @endif
                    @if(@$field['attr'])
                        @foreach($field['attr'] as $at)
                            {{ $at['key'] }} = '{{ @$at['value'] }}'
                        @endforeach
                    @endif
                    @if(@$field['formatDate'])
                        value="{{ \Lib::dateFormat(isset($field['value']) ?$field['value']:@$obj[$field['key']], isset($field['formatDate']) ?$field['formatDate']:'d/m/Y') }}"
                    @else
                        @php($value = isset($field['value']) ? $field['value'] : @$obj[$field['key']])
                        value="{!! old(@$field['name']?:'obj['.$field['key'].']', $value) !!}"
                    @endif
                     {{@$field['disabled']}}
                     class="form-control {{@$field['class']}}"
                     placeholder="{{@$placeholder}}">
        @endif
        </div>
    @else
        <div class="text-primary"  @if(@$field['name'])
        name="{{@$field['name']}}"
             @else name="obj[{{$field['key']}}]" @endif>
            @if(isset($field['value_preview']))
                {!! $field['value_preview'] !!}
            @else
                @if(@$field['formatDate'])
                    {{ \Lib::dateFormat(isset($field['value']) ?$field['value']:@$obj[$field['key']], isset($field['formatDate']) ?$field['formatDate']:'d/m/Y') }}
                @else
                    {{isset($field['value'])?value_show($field['value'],'Chưa cập nhật'):value_show(@$obj[$field['key']],'Chưa cập nhật')}}
                @endif
            @endif
        </div>

    @endif
</div>