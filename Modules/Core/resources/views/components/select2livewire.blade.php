<div>
  <!--
<options=bold>“ Waste no more time arguing what a good man should be, be one. ”</>
<fg=gray>— Marcus Aurelius</>
-->

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
    <option>{{$placeholder}}</option>
    @foreach ($options as $key => $val)
      <option value="{{ $key }}">{{ $val }}</option>
    @endforeach
  </select>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        initializeSelect2('#{{$id}}', '{{$placeholder}}', '{{$modelBootstrap ?? null}}');
      });

      // Listen for Livewire's update event to reinitialize Select2
      Livewire.hook('element.updated', (el) => {
        initializeSelect2('#{{$id}}', '{{$placeholder}}', '{{$modelBootstrap ?? null}}');
      });
    </script>
  @endpush
  @error($model)
  <small class="text-danger errorInputText">{{ $message }}</small>
  @enderror
</div>

{{--

$(selector).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    tags: false,
                });

--}}
