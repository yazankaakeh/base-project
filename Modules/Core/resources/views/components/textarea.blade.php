<div>
    <label class="form-label" for="{{$id}}">{{trans($label)}}</label>
    <textarea id="{{$id}}" class="form-control"
              name="{{$name}}"
              placeholder="{{trans($label)}}"
              @if($model)
                  wire:model="{{ $model }}"
         @endif
            {{$required}}>{{$value}}</textarea>
    @error($name) <span class="error">{{ $message }}</span> @enderror
</div>
