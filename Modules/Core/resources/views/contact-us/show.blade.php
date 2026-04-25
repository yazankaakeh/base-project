@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('core::core.contact_us.details'))

@section('content')
    <div class="page-wrapper">
        <div class="content">

            {{-- Header --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="mb-1 d-flex align-items-center gap-2">
                        <i class="ti tabler-mail-opened text-primary"></i>
                        {{ trans('core::core.contact_us.details') }}
                    </h4>
                    <small class="text-muted">
                        <i class="ti tabler-clock"></i>
                        {{ $contact->created_at?->format('F j, Y · H:i') }}
                        · {{ $contact->created_at?->diffForHumans() }}
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.contact_us.index') }}" class="btn btn-outline-secondary">
                        <i class="ti tabler-arrow-left me-1"></i>{{ trans('core::core.contact_us.back') }}
                    </a>
                    <a href="mailto:{{ $contact->email }}?subject=Re: your message" class="btn btn-primary">
                        <i class="ti tabler-mail-forward me-1"></i>{{ trans('core::core.contact_us.reply') }}
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <span class="avatar avatar-xl mx-auto mb-3 d-inline-block">
                                <span class="avatar-initial rounded-circle bg-label-primary h3 mb-0">
                                    {{ strtoupper(mb_substr($contact->fullName, 0, 1)) }}
                                </span>
                            </span>
                            <h5 class="mb-1">{{ $contact->fullName }}</h5>
                            <a href="mailto:{{ $contact->email }}" class="text-muted">
                                {{ $contact->email }}
                            </a>

                            <hr class="my-4">

                            <dl class="row text-start small mb-0">
                                <dt class="col-5 text-muted">
                                    <i class="ti tabler-id me-1"></i>{{ __('ID') }}
                                </dt>
                                <dd class="col-7">#{{ $contact->id }}</dd>

                                <dt class="col-5 text-muted">
                                    <i class="ti tabler-calendar me-1"></i>{{ trans('core::core.contact_us.received') }}
                                </dt>
                                <dd class="col-7">{{ $contact->created_at?->format('Y-m-d') }}</dd>

                                <dt class="col-5 text-muted">
                                    <i class="ti tabler-clock me-1"></i>{{ __('Time') }}
                                </dt>
                                <dd class="col-7">{{ $contact->created_at?->format('H:i') }}</dd>
                            </dl>
                        </div>
                        <div class="card-footer bg-transparent border-top">
                            <form action="{{ route('admin.contact_us.destroy', $contact) }}" method="POST"
                                  onsubmit="return confirm('{{ trans('core::core.contact_us.delete_confirm') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="ti tabler-trash me-1"></i>{{ trans('core::core.contact_us.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h6 class="mb-0 d-flex align-items-center gap-2">
                                <i class="ti tabler-message-2 text-primary"></i>
                                {{ trans('core::core.contact_us.message') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-0" style="white-space: pre-wrap; line-height: 1.75;">{{ $contact->message }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
