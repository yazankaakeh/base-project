@extends('customer/layouts/layoutMaster')

@section('title', 'Cards Actions- UI elements')


@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss'])
  @livewireStyles
  @livewireScripts

@endsection

@section('vendor-script')

  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js'])

  <script>
    $(document).ready(function() {
      $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10
      });
    });
  </script>
@endsection

@section('page-script')

  @vite(['resources/assets/js/tables-datatables-advanced.js'])

@endsection

@section('content')
  @includeIf('_partials.breadcrumbs',['breadcrumbs'=>$breadcrumbs])

  <!-- Cards Action -->
  <div class="row">
    <!-- Customer-detail Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
      <!-- Customer-detail Card -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="customer-avatar-section">
            <div class="d-flex align-items-center flex-column">
              <img class="img-fluid image rounded my-3" src="{{ asset($user->img ??'assets/img/avatars/15.png' )}}"
                   height="110"
                   width="110"
                   alt="User avatar" />
              <div class="customer-info text-center">
                <h4 class="mb-1">{{$user->name}}</h4>
                <small>{{trans('customer.account.customerID')}}  {{$user->id}}</small>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-around flex-wrap my-4">
            <div class="d-flex align-items-center gap-2">
              <div class="avatar">
                <div class="avatar-initial rounded bg-label-primary">
                  <i class='ti ti-bookmarks ti-lg'></i>
                </div>
              </div>
              <div class="mx-2 gap-0 d-flex flex-column">
                <small>{{$contactCount}}</small>
                <p class="mb-0 fw-medium">{{trans('customer.account.connections')}}</p>
              </div>
            </div>
          </div>

          <div class="info-container">
            <small class="d-block pt-4 border-top fw-normal text-uppercase text-muted my-3">DETAILS</small>
            <ul class="list-unstyled">
              <li class="mb-3">
                <span class="fw-medium me-2">{{trans('customer.account.username')}}:</span>
                <span>{{$user->name}}</span>
              </li>
              <li class="mb-3">
                <span class="fw-medium me-2">{{trans('customer.account.email')}}:</span>
                <span>{{$user->email}}</span>
              </li>
              <li class="mb-3">
                <span class="fw-medium me-2">{{trans('customer.account.status')}}:</span>
                <span class="badge bg-label-success">{{$user->is_active->label()}}</span>
              </li>
              <li class="mb-3">
                <span class="fw-medium me-2">{{trans('customer.account.contactPhone')}}:</span>
                <span>{{$user->phone}}</span>
              </li>

              {{--<li class="mb-3">
                <span class="fw-medium me-2">Country:</span>
                <span>USA</span>
              </li>--}}
            </ul>
            {{--<div class="d-flex justify-content-center">
              <a href="javascript:" class="btn btn-primary me-3" data-bs-target="#editUser" data-bs-toggle="modal">Edit
                Details</a>

            </div>--}}
          </div>
        </div>
      </div>
      <!-- /Customer-detail Card -->
      <!-- Plan Card -->

      {{--<div class="card mb-4 bg-gradient-primary">
        <div class="card-body">
          <div class="row justify-content-between mb-3">
            <div
              class="col-md-12 col-lg-7 col-xl-12 col-xxl-7 text-center text-lg-start text-xl-center text-xxl-start order-1 order-lg-0 order-xl-1 order-xxl-0">
              <h4 class="card-title text-white text-nowrap">Upgrade to premium</h4>
              <p class="card-text text-white">Upgrade customer to premium membership to access pro features.</p>
            </div>
            <span class="col-md-12 col-lg-5 col-xl-12 col-xxl-5 text-center mx-auto mx-md-0 mb-2"><img
                src="{{ asset('assets/img/illustrations/rocket.png')}}" class="w-px-75 m-2" alt="3dRocket"></span>
          </div>
          <button class="btn btn-white text-primary w-100 fw-medium shadow-md" data-bs-target="#upgradePlanModal"
                  data-bs-toggle="modal">Upgrade to premium
          </button>
        </div>
      </div>
--}}
      <!-- /Plan Card -->
    </div>
    <!--/ Customer Sidebar -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
      <ul class="nav nav-tabs bg-transparent border-0" id="myTab" role="tablist">
        <li class="nav-item " role="presentation">
          <button class="nav-link border-0 box-shadow-0 active" id="home-tab" data-bs-toggle="tab"
                  data-bs-target="#home"
                  type="button" role="tab" aria-controls="home" aria-selected="true">
            {{trans('customer.account.securityTitle')}}
          </button>
        </li>
        <li class="nav-item border-0 box-shadow-0" role="presentation">
          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                  type="button" role="tab" aria-controls="profile" aria-selected="false">
            {{trans('customer.account.cards')}}
          </button>
        </li>
        <li class="nav-item border-0 box-shadow-0" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                  type="button" role="tab" aria-controls="contact" aria-selected="false">
            {{trans('customer.account.accountDetails')}}
          </button>
        </li>
      </ul>

      <div class="tab-content px-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <div class="card-body">
              <h3>{{trans('customer.account.security.changePassword')}}</h3>
              <div class="alert alert-warning" role="alert">
                {!! trans('customer.account.changePasswordValidationMsg') !!}
              </div>

              <form action="{{route('customer.account.updatePassword')}}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-6">

                    <x-core::input label="customer.account.security.newPassword" id="new_password" name="password"
                                   type="text" model="new_password" value="">
                    </x-core::input>
                  </div>
                  <div class="col-6">

                    <x-core::input label="customer.account.security.confirmed_password" id="confirmed_password"
                                   name="confirmed_password"
                                   type="text" model="firstname" value="">
                    </x-core::input>
                  </div>

                </div>
                <button class="mt-3 btn btn-primary" type="submit">
                  {{trans('customer.account.security.changePassword')}}
                </button>
              </form>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="card">
            <div class="card-body">
              <div class="row">
                @foreach($cards as $card)
                  <div class="col-xl-4 col-lg-4 col-sm-12 col-md-6">
                    @includeIf('_partials.cards.__card',['card'=>$card])
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class=" fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="card">
            <div class="card-body">
              <h3>{{trans('customer.account.contact.accountDetails')}}</h3>
              <div class="row">
                <div class="col-12">
                  @livewire('card-upload-photo', [
                      'model'=>$user,
                      'imgPath'=>$user->img,
                      'id'=>'img',
                  ])
                </div>
                <form action="{{route('customer.account.updateProfile')}}" method="POST">
                  @csrf
                  <div class="col-12">
                    <x-core::input label="customer.account.contact.name" id="name" name="name"
                                   type="text" :value="$user->name">
                    </x-core::input>
                  </div>
                  <div class="col-12">
                    <x-core::input label="customer.account.contact.phone" id="phone"
                                   name="phone"
                                   type="text" :value="$user->phone ?? ''">
                    </x-core::input>
                  </div>
                  <div class="col-12">
                    <x-core::input label="customer.account.contact.email" id="email"
                                   name="email"
                                   disabled="disabled"
                                   type="email" :value="$user->email">
                    </x-core::input>
                  </div>
                  <button class="mt-3 btn btn-primary" type="submit">
                    {{trans('customer.account.contact.save')}}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!--/ Customer Content -->

@endsection
@push('scripts')
  <script>
    Livewire.on('photoUpdated', (payload) => {
      console.log(payload); // payload is the object: { img: '...' }
      document.querySelector('.image').src = payload.img; // ✅
    });
  </script>
@endpush
