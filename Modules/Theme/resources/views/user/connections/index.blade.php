@extends('customer/layouts/layoutMaster')

@section('title', 'Cards Actions- UI elements')

@section('vendor-style')
  @livewireStyles
@endsection

@section('vendor-script')
  @livewireScripts

@endsection

@section('page-script')
@endsection

@section('content')

  @includeIf('_partials.breadcrumbs',['breadcrumbs'=>$breadcrumbs])

  <!-- Cards Action -->

  <div class="row g-4">
    <div class="card">

      @livewire('connections-livewire')
    </div>
  </div>

@endsection
