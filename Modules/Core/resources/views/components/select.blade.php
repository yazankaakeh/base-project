<div>

    <label for="{{$id}}" class="form-label">{{$placeholder}}</label>
    <select @if(isset($multiple) && $multiple)  multiple @endif
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


    @if(!is_null($value))
        @push('scripts')
            <script>
                (function () {
                    const elId = @json($id);     // مثال: "clinics_id"
                    const value = @json($value);    // يقبل String أو Array

                    console.log(value);
                    const apply = () => {
                        const $el = $('#' + elId);
                        if (!$el.length) return;

                        // إذا Select2 جاهز
                        if ($el.data('select2')) {
                            $el.val(value).trigger('change');
                        } else {
                            // في حال التهيئة تصير لاحقًا
                            $el.val(value);
                            $el.trigger('change');
                        }
                    };

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', apply);
                    } else {
                        apply();
                    }

                    // لو العنصر داخل مودال، أعد التعيين بعد فتحه
                    $('#storeModal').on('shown.bs.modal', apply);
                })();
            </script>
        @endpush
    @endif
</div>
