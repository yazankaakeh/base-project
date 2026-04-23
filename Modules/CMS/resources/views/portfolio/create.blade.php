@php
    use Modules\Core\App\Enums\LanguageEnum;
    $page = 'cms-portfolios';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', 'Create Portfolio')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="ti tabler-briefcase me-2"></i>
                                Create New Portfolio
                            </h5>
                            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-outline-secondary">
                                <i class="ti tabler-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.portfolios.store') }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @include('cms::portfolio.partials.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
