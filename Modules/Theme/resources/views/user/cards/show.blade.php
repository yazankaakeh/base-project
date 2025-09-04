@extends('customer.layouts.showCardLayout.layout')

@section('title', 'Cards Actions- UI elements')





@section('content')

  <style>
    .img-container {
      height: 30vh;
      width: 100%;
      overflow: hidden; /* Hides the overflow to keep only the top */
    }

    .img-container img {
      width: 100%;
      height: auto;
      object-fit: cover;
      object-position: top; /* Keeps the top part visible */
    }
  </style>
  <!-- Header -->
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="user-profile-header-banner img-container ">
          <img src="{{ asset($card->bg_img) }}" alt="Banner image" class="rounded-top">
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img style="max-width: 95px;" src="{{  asset($card->img) }}" alt="user image"
                 class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div
              class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4 class="mb-0 pb-0">{{$card->full_name}}</h4>
                <p class="mb-0 pb-0">
                  {{$card->cardCompanyInfo->position}}
                </p>
                <p>
                  {{$card->cardCompanyInfo->bio}}
                </p>
              </div>
              <div class="">

              </div>
              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exchangeContactModal"
                 class="btn btn-primary">
                <i class='ti icon-base tabler-bookmark me-1'></i>{{trans('customer.card.save_contact')}}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Header -->

  <!-- User Profile Content -->
  <div class="row">
    <div class="col-xl-4 col-lg-4 order-2 order-lg-1 col-md-5 col-sm-12">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">{{trans('customer.card.contacts')}}</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-phone-call text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.phone')}}
              </span>
              <span>
                {{$card->phone}}
              </span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-mail text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.email')}}
              </span>
              <span>
                {{$card->email}}
              </span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-mail text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.address')}}
              </span>
              <span>
                {{$card->cardAddress->full_address}}
              </span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-world text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.website')}}
              </span>
              <span>
                {!!  trans('customer.card.link',['link'=>$card->cardCompanyInfo->website]) !!}
              </span>
            </li>
          </ul>


          <small class="card-text text-uppercase">{{trans('customer.card.about')}}</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-user text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.full_name')}}
              </span>
              <span>
                {{$card->full_name}}
              </span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-user text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.company')}}
              </span>
              <span>
                {{$card->cardCompanyInfo->business_name}}
              </span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-user text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.job_title')}}
              </span>
              <span>
                {{$card->cardCompanyInfo->position}}
              </span>
            </li>
            <li class="d-flex align-items-center mb-3">
              <i class="ti icon-base tabler-user text-heading"></i>
              <span class="fw-medium mx-2 text-heading">
               {{trans('customer.card.nationality')}}
              </span>
              <span>
                {{$card->nationality->name}}
              </span>
            </li>
          </ul>

        </div>
      </div>
      <!--/ About User -->
    </div>
    <div class="col-xl-4 col-lg-4 order-1 order-lg-2 order-lg-2 col-md-5 col-sm-12">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">{{trans('customer.card.social_media')}}</small>
          <div class="row">
            @foreach($socialLinks as $socialLink)
              <div class="col-auto mx-0 px-0">
                @php
                  $function = 'onClick="socialLinkClicked(\'' . $socialLink->pivot->id . '\', \'' . addslashes($socialLink->full_link) . '\')"';
                @endphp
                <span class="text-black socialLink-{{$socialLink->id}}">
                    <x-social-link-component :socialLink="$socialLink" :function='$function'>
                    </x-social-link-component>
                  </span>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <!--/ About User -->
    </div>
    <div class="col-xl-4 col-lg-4 order-3 order-lg-3 order-lg-3 col-md-5 col-sm-12">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">{{trans('customer.card.files')}}</small>
          <div class="row">
            @foreach($card->cardFiles as $cardFile)
              <a class="text-body" href="{{$cardFile->full_url}}">
                <i class="ti icon-base tabler-file-analytics"></i>
                {{$cardFile->name}}
              </a>
            @endforeach
          </div>
        </div>
      </div>
      <!--/ About User -->
    </div>
    <div class="col-xl-4 col-lg-4 order-4 order-lg-4 order-lg-4 col-md-5 col-sm-12">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">{{trans('customer.card.qr_code')}}</small>
          <div class="row text-center">
            <div id="qr"
                 data-url="{{ $card->full_link }}"
                 data-logo="{{ asset('landing/assets/img/tagiy.png') }}">
            </div>
          </div>
        </div>
      </div>
      {{--<div class="text-center">
        <button class="btn btn-primary">
          <i class="ti icon-base tabler-share mx-2"> </i>
          {{trans('customer.card.share_my_contact')}}
        </button>
      </div>--}}
      <!--/ About User -->
    </div>
  </div>
  @livewire('exchange-contact',['cardId' => $card->id])
@endsection

@push('scripts')
  @vite('resources/assets/vendor/js/qr-init.js')
  <script>
    function socialLinkClicked(id, link) {
      if (!link.startsWith('http://') && !link.startsWith('https://')) {
        link = 'https://' + link;
      }
      $.ajax({
        url: '{{route('customer.socialLinkClicked')}}',  // change this to your server URL
        type: 'POST',
        data: {
          id: id,
          _token: '{{ csrf_token() }}' // if you're using Laravel or need CSRF protection
        },
        success: function(response) {
          // After successful request, redirect
          window.location.href = link;
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
          // optionally handle error
          window.location.href = link; // optionally still redirect even on error
        }
      });
    }
  </script>
  <script>


    function copyLink(link) {
// Create a temporary input
      const tempInput = document.createElement('input');
      tempInput.value = link;
      document.body.appendChild(tempInput);

      tempInput.select();
      tempInput.setSelectionRange(0, 99999); // for mobile

      document.execCommand('copy');
      document.body.removeChild(tempInput);
    }
  </script>
@endpush
