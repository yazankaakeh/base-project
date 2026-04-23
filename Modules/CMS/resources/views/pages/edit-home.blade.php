@php
use Modules\Core\App\Enums\LanguageEnum;
$pageVar = 'cms-pages';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.pages.edit_home_page'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'], 'build/modules/theme')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js'], 'build/modules/theme')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card-header px-0 pt-0 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="ti tabler-home me-2"></i>
                                {{ trans('cms::cms.pages.edit_home_page') }}
                            </h4>
                            <a href="{{ route('cms.index') }}" class="btn btn-secondary">
                                <i class="ti tabler-arrow-left me-1"></i>
                                {{ trans('cms::cms.common.back') }}
                            </a>
                        </div>
                    </div>

                    <div class="nav-align-top mb-3">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach(LanguageEnum::values() as $lang)
                                <li class="nav-item" role="presentation">
                                    <button type="button"
                                            class="nav-link waves-effect {{$lang == app()->getLocale() ? 'active': ''}}"
                                            role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-tab-{{$lang}}"
                                            aria-controls="navs-tab-{{$lang}}"
                                            aria-selected="{{$lang == app()->getLocale() ? 'true' : 'false'}}">
                                        {{ strtoupper($lang) }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <form action="{{ route('cms.home.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="tab-content m-0 p-0">
                            @foreach(LanguageEnum::values() as $lang)
                                <div class="tab-pane fade {{$lang == app()->getLocale() ? 'active show': ''}}"
                                     id="navs-tab-{{$lang}}" role="tabpanel">

                                    {{-- Hero Section --}}
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="ti tabler-rocket me-2"></i>
                                                Hero Section ({{ strtoupper($lang) }})
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="hero_title_{{$lang}}" class="form-label">Title *</label>
                                                    <input type="text" class="form-control @error('hero_title.'.$lang) is-invalid @enderror"
                                                           name="hero_title[{{$lang}}]" id="hero_title_{{$lang}}"
                                                           value="{{ old('hero_title.'.$lang, $page->meta_data['hero']['title'][$lang] ?? '') }}" required>
                                                    @error('hero_title.'.$lang)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hero_subtitle_{{$lang}}" class="form-label">Subtitle</label>
                                                    <input type="text" class="form-control"
                                                           name="hero_subtitle[{{$lang}}]" id="hero_subtitle_{{$lang}}"
                                                           value="{{ old('hero_subtitle.'.$lang, $page->meta_data['hero']['subtitle'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="hero_description_{{$lang}}" class="form-label">Description</label>
                                                    <textarea class="form-control" name="hero_description[{{$lang}}]"
                                                              id="hero_description_{{$lang}}" rows="3">{{ old('hero_description.'.$lang, $page->meta_data['hero']['description'][$lang] ?? '') }}</textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="hero_cta_text_{{$lang}}" class="form-label">Button Text</label>
                                                    <input type="text" class="form-control"
                                                           name="hero_cta_text[{{$lang}}]" id="hero_cta_text_{{$lang}}"
                                                           value="{{ old('hero_cta_text.'.$lang, $page->meta_data['hero']['cta_text'][$lang] ?? '') }}">
                                                </div>
                                                @if($lang == 'en')
                                                    <div class="col-md-6 mb-3">
                                                        <label for="hero_cta_url" class="form-label">Button URL</label>
                                                        <input type="text" class="form-control"
                                                               name="hero_cta_url" id="hero_cta_url"
                                                               value="{{ old('hero_cta_url', $page->meta_data['hero']['cta_url'] ?? '') }}">
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="hero_image" class="form-label">Hero Image</label>
                                                        @if(!empty($page->meta_data['hero']['image']))
                                                            <div class="mb-2">
                                                                <img src="{{ asset($page->meta_data['hero']['image']) }}"
                                                                     alt="Hero" class="img-fluid rounded" style="max-height: 200px;">
                                                            </div>
                                                        @endif
                                                        <input type="file" class="form-control" name="hero_image"
                                                               id="hero_image" accept="image/*">
                                                        <small class="text-muted">Or enter path:</small>
                                                        <input type="text" class="form-control mt-2" name="hero_image_path"
                                                               placeholder="assets/img/..."
                                                               value="{{ old('hero_image_path', $page->meta_data['hero']['image'] ?? '') }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Features Section --}}
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="ti tabler-stars me-2"></i>
                                                Features Section ({{ strtoupper($lang) }})
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="features_badge_{{$lang}}" class="form-label">Badge</label>
                                                    <input type="text" class="form-control"
                                                           name="features_badge[{{$lang}}]" id="features_badge_{{$lang}}"
                                                           value="{{ old('features_badge.'.$lang, $page->meta_data['features']['badge'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                    <label for="features_title_{{$lang}}" class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                           name="features_title[{{$lang}}]" id="features_title_{{$lang}}"
                                                           value="{{ old('features_title.'.$lang, $page->meta_data['features']['title'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="features_description_{{$lang}}" class="form-label">Description</label>
                                                    <textarea class="form-control" name="features_description[{{$lang}}]"
                                                              id="features_description_{{$lang}}" rows="2">{{ old('features_description.'.$lang, $page->meta_data['features']['description'][$lang] ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- CTA Section --}}
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="ti tabler-click me-2"></i>
                                                Call to Action ({{ strtoupper($lang) }})
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="cta_title_{{$lang}}" class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                           name="cta_title[{{$lang}}]" id="cta_title_{{$lang}}"
                                                           value="{{ old('cta_title.'.$lang, $page->meta_data['cta']['title'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="cta_subtitle_{{$lang}}" class="form-label">Subtitle</label>
                                                    <input type="text" class="form-control"
                                                           name="cta_subtitle[{{$lang}}]" id="cta_subtitle_{{$lang}}"
                                                           value="{{ old('cta_subtitle.'.$lang, $page->meta_data['cta']['subtitle'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="cta_button_text_{{$lang}}" class="form-label">Button Text</label>
                                                    <input type="text" class="form-control"
                                                           name="cta_button_text[{{$lang}}]" id="cta_button_text_{{$lang}}"
                                                           value="{{ old('cta_button_text.'.$lang, $page->meta_data['cta']['button_text'][$lang] ?? '') }}">
                                                </div>
                                                @if($lang == 'en')
                                                    <div class="col-md-6 mb-3">
                                                        <label for="cta_button_url" class="form-label">Button URL</label>
                                                        <input type="text" class="form-control"
                                                               name="cta_button_url" id="cta_button_url"
                                                               value="{{ old('cta_button_url', $page->meta_data['cta']['button_url'] ?? '') }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Contact Section --}}
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <i class="ti tabler-mail me-2"></i>
                                                Contact Section ({{ strtoupper($lang) }})
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="contact_badge_{{$lang}}" class="form-label">Badge</label>
                                                    <input type="text" class="form-control"
                                                           name="contact_badge[{{$lang}}]" id="contact_badge_{{$lang}}"
                                                           value="{{ old('contact_badge.'.$lang, $page->meta_data['contact']['badge'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-md-8 mb-3">
                                                    <label for="contact_title_{{$lang}}" class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                           name="contact_title[{{$lang}}]" id="contact_title_{{$lang}}"
                                                           value="{{ old('contact_title.'.$lang, $page->meta_data['contact']['title'][$lang] ?? '') }}">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="contact_description_{{$lang}}" class="form-label">Description</label>
                                                    <textarea class="form-control" name="contact_description[{{$lang}}]"
                                                              id="contact_description_{{$lang}}" rows="2">{{ old('contact_description.'.$lang, $page->meta_data['contact']['description'][$lang] ?? '') }}</textarea>
                                                </div>
                                                @if($lang == 'en')
                                                    <div class="col-md-6 mb-3">
                                                        <label for="contact_email" class="form-label">Email</label>
                                                        <input type="email" class="form-control"
                                                               name="contact_email" id="contact_email"
                                                               value="{{ old('contact_email', $page->meta_data['contact']['email'] ?? '') }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="contact_phone" class="form-label">Phone</label>
                                                        <input type="text" class="form-control"
                                                               name="contact_phone" id="contact_phone"
                                                               value="{{ old('contact_phone', $page->meta_data['contact']['phone'] ?? '') }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('cms.index') }}" class="btn btn-secondary">
                                        <i class="ti tabler-x me-1"></i>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti tabler-device-floppy me-1"></i>
                                        {{ trans('cms::cms.pages.update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection