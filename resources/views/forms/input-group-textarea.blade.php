<div class="form-group {{@$group['class']}}">
<label @if(@$field['id']) for="{{ @$field['id'] }}"  @else for="obj-{{@$field['key']}}"  @endif>{{$field['label']}} <span class="{{@$field['classNote']}}">{{ @$field['note'] }}</span></label>
    @if(!$preview)
        <textarea style="min-height: {{value_show(@$field['height'],68)}}px"
                  @if(!@$field['name'])
                  name="obj[{{$field['key']}}]"
                  @else
                          name="{{$field['name']}}"
                  @endif
                  
                    @if(@$field['attr'])
                        @foreach($field['attr'] as $at)
                            {{ $at['key'] }} = {{ $at['value'] }}
                        @endforeach
                    @endif
    @if(@$field['id']) id="{{ @$field['id'] }}"  @else id="obj-{{@$field['id_prefix']}}{{@$field['key']}}"  @endif
                  class="form-control {{@$field['class']}}"
                  placeholder="{{@$placeholder}}">
                  @if(isset($field['value']))
                    {{ old($field['name'], @$field['value']) }}
                  @else
                    {{ old($field['name'], @$obj[$field['key']]) }}
                  @endif</textarea>
        @if(@$field['intro'])
            <small class="form-text text-muted">{{$field['intro']}}</small>
        @endif
    @else
        <div class="text-primary" style="white-space: pre-line;">{!! isset($field['value'])?value_show(\StringLib::joinAreaContent(trim($field['value']),'<br/>'),'Chưa cập nhật nội dung'):value_show(@$obj[$field['key']],'Chưa cập nhật') !!}</div>
    @endif
</div>