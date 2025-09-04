<div class="@if($type == 'password') pass-group @endif">
    <label class="{{ $type != 'checkbox' ? 'form-label' : 'form-check-label' }} "
           for="{{$id}}">{{trans($label)}}</label>
    <input type="{{$type}}" name="{{$name}}" id="{{$id}}"
           class="{{ $type != 'checkbox' ? 'form-control' : '' }} {{isset($class) ? $class:''}}"
           @if($model)
               wire:model="{{ $model }}"
           @endif
           maxlength="{{$maxlength}}"
           {{$disabled}}
           {{$readonly}}
           {{$required}}
           value="{{$value}}">
    @if($type == 'password')
        <span class="fas toggle-password-admin fa-eye-slash"></span>
    @endif
    @if($type != 'password')
        @error($name)
        <small class="text-danger errorInputText">{{ $message }}</small>
        @enderror
    @endif
</div>
