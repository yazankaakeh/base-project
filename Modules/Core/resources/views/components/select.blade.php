<div>
    <label for="{{$id}}" class="form-label">{{$placeholder}}</label>
    <select @if(isset($multiple) && $multiple) multiple="multiple" @endif
    {{$required ?? ''}}  {{$onChange ?? ''}} name="{{$name}}"
            class="form-select select2 form-select-md @error($name) inputError @enderror  {{$class ?? ''}}" id="{{$id}}"
            @if(isset($onChangeEvent) && $onChangeEvent)
                data-change="{{$onChangeEvent}}"
            @endif

            @if(isset($property) && $property)
                data-property="{{$model}}"
            @endif
            wire:model.change="{{$model}}">
        <option>{{$placeholder}}</option>
        @foreach ($options as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
</div>
