<div>
    <label for="select2Basic" class="form-label">{{$placeholder}}</label>
    <select @if(isset($multiple) && $multiple) multiple="multiple" @endif
    {{$required ?? ''}}  {{$onChange ?? ''}} name="{{$name}}"
            class="select2 form-select form-select-md @error($name) inputError @enderror  {{$class ?? ''}}" id="{{$id}}"
            @if(isset($onChangeEvent) && $onChangeEvent)
                data-change="{{$onChangeEvent}}"
            @endif

            @if(isset($property) && $property)
                data-property="{{$model}}"
            @endif
            wire:model.change="{{$model}}">
        <option value="">{{$placeholder}}</option>
        @foreach ($options as $key => $val)
            <option value="{{ $key }}" {{$value == $key ? 'selected' : ''}}>{{ $val }}</option>
        @endforeach
    </select>
    @error($name)
    <small class="text-danger errorInputText">{{ $message }}</small>
    @enderror
</div>
