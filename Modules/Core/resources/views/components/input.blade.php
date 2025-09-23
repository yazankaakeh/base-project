<div>
    @if(isset($label))
        <label class="form-label" for="{{$id}}">
            @if(!empty($labelValue))
                {{trans($label,$labelValue )}}
            @else
                {{trans($label)}}
            @endif

        </label>
    @endif
    
    <input type="{{$type}}" name="{{$name}}" id="{{$id}}" {{$multiple}}
    class="form-control {{$class ?? ''}}"
           @if($model)
               wire:model="{{ $model }}"
           @endif

           @if($modelSearch)
               wire:model.live.debounce.1000ms="{{ $modelSearch }}"
           @endif
           {{$required}}
           placeholder="{{trans($placeholder ?? $label)}}"
           value="{{$value}}">
    @error($name) <span class="error">{{ $message }}</span> @enderror
</div>
