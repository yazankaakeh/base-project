@php
    use Modules\Core\App\Enums\LanguageEnum;
    $page = 'cms-portfolios';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', 'Edit Portfolio')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="ti tabler-briefcase me-2"></i>
                                Edit Portfolio: {{ $portfolio->getTranslation('title', app()->getLocale()) }}
                            </h5>
                            <div class="d-flex gap-2">
                                <a href="{{ route('portfolio.show', $portfolio->slug) }}"
                                   target="_blank"
                                   class="btn btn-outline-info">
                                    <i class="ti tabler-external-link me-1"></i> View on Website
                                </a>
                                <a href="{{ route('admin.portfolios.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti tabler-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.portfolios.update', $portfolio->id) }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('cms::portfolio.partials.form', ['portfolio' => $portfolio])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
