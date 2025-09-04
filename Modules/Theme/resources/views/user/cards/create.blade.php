@extends('customer/layouts/layoutMaster')

@section('title', 'Cards Actions- UI elements')

<!-- Vendor Styles -->
@section('vendor-style')
  @livewireStyles
  @livewireScripts
  @vite(['resources/assets/vendor/libs/dropzone/dropzone.scss'])
  @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'])
  @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
  <script src="{{asset('livewire-select2/livewire-select2.js')}}"></script>
  @vite(['resources/assets/js/forms-file-upload.js'])
  {{--
    @vite(['resources/assets/js/form-wizard-numbered.js', 'resources/assets/js/form-wizard-validation.js'])
  --}}
@endsection

@section('content')

  @includeIf('_partials.breadcrumbs',['breadcrumbs'=>$breadcrumbs])

  <!-- Cards Action -->
  <div class="row g-4">
    <div class="col-12 mb-4">
      @livewire('create-card',['card'=>$card,'socialLinksCategories' => $socialLinksCategories])
    </div>
  </div>

@endsection

