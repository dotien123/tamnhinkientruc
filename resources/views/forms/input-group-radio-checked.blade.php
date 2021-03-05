<div class="form-group">
    <label for="obj-description">{{$field['label']}} <span class="{{@$field['classNote']}}">{{ @$field['note'] }}</span></label>
    @if(!$preview)
        <br/>
        @if(@$field['obj'] && is_array($field['obj']))
            @foreach($field['obj'] as $item)
                <div class="{{ @$type }} {{@$item['class']?:'form-check-inline '}}">
                    <input type="{{ @$type }}" id="obj-{{ @$item['id']?:$item['key'] }}" value="{{ @$item['value']?:@$item['id'] }}"
                           name="{{ @$field['name']?:@$field['key'] }}"
                           @if(isset($data))
                               @if(@$type == 'checkbox')
                                   @if(is_array($data) && !empty($data))
                                        @foreach($data as $ck)
                                           @if(@$item['id'] == $ck)
                                           checked
                                           @endif
                                        @endforeach
                                   @endif
                                @else
                                    {{ (@$item['value'] == @$data) ? 'checked' : ''}}
                                @endif

                            @endif

                    >
                    <label for="obj-{{ @$item['id']?:$item['key'] }}"> {{ @$item['label']?:$item['title'] }} </label>
                </div>
            @endforeach
        @endif
    @else
        <div class="text-primary">
            @foreach($field['obj'] as $item)
                @if(isset($data) && !empty($data))
                    @if(@$item['value'] == @$data)
                        {{ $item['label'] }}
                        @break
                    @endif
                @endif
            @endforeach
        </div>
    @endif
</div>