<div class="my-2">
    @if(isset($label))
        <label class="form-label" for="{{$id}}">{{trans($label)}} {{ $lang ?? '' }}</label>

        @if($tooltip)
            <button type="button" class="btn" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="{{$tooltip}}" style="--bs-btn-padding-y: 0px;--bs-btn-padding-x: 5px;">
                <i class="ti icon-base tabler-info-square-rounded"></i>
            </button>
        @endif
    @endif
    <input type="{{$type}}" name="{{$name}}" id="{{$id}}"
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
