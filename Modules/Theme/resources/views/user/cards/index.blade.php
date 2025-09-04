@extends('customer/layouts/layoutMaster')

@section('title', 'Cards Actions- UI elements')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/spinkit/spinkit.scss', 'resources/assets/vendor/libs/notiflix/notiflix.scss'])
  @livewireScripts
  @livewireStyles
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/notiflix/notiflix.js', 'resources/assets/vendor/libs/sortablejs/sortable.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/cards-actions.js'])
@endsection

@section('content')

  @includeIf('_partials.breadcrumbs',['breadcrumbs'=>$breadcrumbs])

  @if($can_create_card)
    <h4 class="">
      <a href="{{route('card.updateOrCreate',['card_id' =>null])}}" class="btn btn-success btn-xl">
        {{trans('customer.card.addProfile')}}
      </a>
    </h4>
  @endif

  <!-- Cards Action -->

  <div class="row g-4">
    @foreach($cards as $card)
      <div class="col-xl-4 col-lg-4 col-sm-12 col-md-6">
        @includeIf('_partials.cards.__card',['card'=>$card])
      </div>
    @endforeach
  </div>

@endsection
@push('scripts')
  <script>
    Livewire.on('disableButton', (className) => {
      console.log(className.className, className.fullLink);
      $('.' + className.className).attr('href', className.fullLink || 'javascript:void(0)');
      if (className.fullLink) {
        $('.' + className.className).removeClass('btn-secondary');
        $('.' + className.className).addClass('btn-primary');
      } else {
        $('.' + className.className).removeClass('btn-primary');
        $('.' + className.className).addClass('btn-secondary');
      }
    });
  </script>
@endpush
