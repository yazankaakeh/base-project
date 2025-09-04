<div>
    <label class="form-label" for="{{$id}}">{{trans($label)}}</label>
    <textarea style="resize: vertical; max-height: 300px;" id="{{$id}}" class="form-control"
              name="{{$name}}"
              placeholder="Hi, Do you have a moment to talk Joe?"
              @if($model)
                  wire:model="{{ $model }}"
         @endif
            {{$required}}  {{$disabled}}>
        {{$value}}

  </textarea>
    @error($name) <span class="error">{{ $message }}</span> @enderror
</div>
