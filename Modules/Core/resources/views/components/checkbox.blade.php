{{--<div>
    <!-- 
  <options=bold>“ When there is no desire, all things are at peace. ”</>
  <fg=gray>— Laozi</>
 -->
</div>--}}
<div class="form-check">
    @if($canReject)
        <input type="hidden" value="0" name="{{$name}}">
    @endif
    <input {{$disabled}} {{$required}}
           class="form-check-input" wire:model="{{$model}}" name="{{$name}}" type="checkbox" value="1"
           id="{{$id}}" {{$value ? 'checked' : ''}}>
    <label class="form-check-label" for="{{$id}}">
        {{$label}}
    </label>
    @error($name)
    <small class="text-danger errorInputText">{{ $message }}</small>
    @enderror
</div>