<div>
    <p class="demo-inline-spacing" wire:ignore>
        <a wire:click="toggle" class="btn btn-primary me-1" data-bs-toggle="collapse" href="#collapseExample"
           role="button">
            <i class="me-2 ti icon-base tabler-switch-vertical"></i>
            {{trans('doctor::doctor.medicalExaminations.vitalSignsInfo')}}
        </a>
    </p>
    <div class="collapse {{ $isOpen ? 'show' : '' }}" id="collapseExample">
        <div class="row mb-5">
            @foreach($vitalSigns as $vitalSign)
                <div class="col-2 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-content">
                                <x-core::input
                                        :label="$vitalSign->name"
                                        :id="'vital-'.$vitalSign->id"
                                        :name="'values['.$vitalSign->id.']'"
                                        type="text"
                                        model="values.{{ $vitalSign->id }}"
                                />
                                <div class="text-end mt-3">
                                    <button
                                            class="btn btn-sm btn-primary"
                                            wire:click="saveOne({{ $vitalSign->id }})"
                                            type="button"
                                    >
                                        {{ trans('doctor::doctor.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="text-end">
                <button class="btn btn-primary" wire:click="saveAll" type="button">
                    {{ trans('doctor::doctor.saveAll') }}
                </button>
            </div>
        </div>

    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            window.addEventListener('toast', (e) => {
                const {type = 'success', message = ''} = e.detail || {};
                // SweetAlert2 toast
                if (window.Swal) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: type,
                        title: message,
                        showConfirmButton: false,
                        timer: 0,
                        timerProgressBar: true,
                    });
                } else {
                    // Fallback
                    console.log(`[${type}] ${message}`);
                }
            });
        });
    </script>
@endpush