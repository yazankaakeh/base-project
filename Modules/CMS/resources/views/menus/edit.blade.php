@php
use Modules\Core\App\Enums\LanguageEnum;
$pageVar = 'cms-menus';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.menus.edit'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card-header px-0 pt-0">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach(LanguageEnum::values() as $lang)
                                    <li class="nav-item" role="presentation">
                                        <button type="button"
                                                class="nav-link waves-effect {{$lang == app()->getLocale() ? 'active': ''}}"
                                                role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-tab-{{$lang}}"
                                                aria-controls="navs-tab-{{$lang}}" aria-selected="{{$lang == app()->getLocale() ? 'true' : 'false'}}">
                                            {{ strtoupper($lang) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <form action="{{ route('menus.update', $menu->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-9">
                                <div class="tab-content m-0 p-0">
                                    @foreach(LanguageEnum::values() as $lang)
                                        <div class="tab-pane fade {{$lang == app()->getLocale() ? 'active show': ''}}"
                                             id="navs-tab-{{$lang}}" role="tabpanel">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-1">{{ strtoupper($lang) }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <x-core::input
                                                        label="cms::cms.menus.name"
                                                        type="text"
                                                        name="name[{{$lang}}]"
                                                        id="name-{{$lang}}"
                                                        value="{{ old('name.'.$lang, $menu->getTranslation('name', $lang)) }}"
                                                        required="required" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="mb-1">{{ trans('cms::cms.menus.menu_items') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="menu-items-container">
                                            @foreach($menu->items as $index => $item)
                                                <div class="card mb-3 menu-item" data-index="{{ $index }}">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h6 class="mb-0">{{ trans('cms::cms.menus.items') }} #{{ $index + 1 }}</h6>
                                                            <button type="button" class="btn btn-sm btn-danger remove-item">
                                                                <i class="ti tabler-trash icon-base"></i>
                                                            </button>
                                                        </div>

                                                        <ul class="nav nav-tabs mb-3" role="tablist">
                                                            @foreach(LanguageEnum::values() as $langIndex => $lang)
                                                                <li class="nav-item" role="presentation">
                                                                    <button type="button" class="nav-link {{$langIndex === 0 ? 'active' : ''}}"
                                                                            role="tab" data-bs-toggle="tab"
                                                                            data-bs-target="#item-{{ $index }}-{{ $lang }}">
                                                                        {{ strtoupper($lang) }}
                                                                    </button>
                                                                </li>
                                                            @endforeach
                                                        </ul>

                                                        <div class="tab-content mb-3">
                                                            @foreach(LanguageEnum::values() as $langIndex => $lang)
                                                                <div class="tab-pane fade {{$langIndex === 0 ? 'active show' : ''}}"
                                                                     id="item-{{ $index }}-{{ $lang }}" role="tabpanel">
                                                                    <label class="form-label">{{ trans('cms::cms.menus.item_title') }} *</label>
                                                                    <input type="text" class="form-control"
                                                                           name="items[{{ $index }}][title][{{ $lang }}]"
                                                                           value="{{ old('items.'.$index.'.title.'.$lang, $item->getTranslation('title', $lang)) }}" required>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">{{ trans('cms::cms.menus.link_to_page') }}</label>
                                                                <select class="form-select" name="items[{{ $index }}][page_id]">
                                                                    <option value="">{{ trans('cms::cms.menus.none') }}</option>
                                                                    @foreach($pages as $id => $title)
                                                                        <option value="{{ $id }}" {{ old('items.'.$index.'.page_id', $item->page_id) == $id ? 'selected' : '' }}>
                                                                            {{ $title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">{{ trans('cms::cms.menus.item_url') }}</label>
                                                                <input type="text" class="form-control" name="items[{{ $index }}][url]"
                                                                       value="{{ old('items.'.$index.'.url', $item->url) }}">
                                                                <small class="text-muted">{{ trans('cms::cms.menus.item_url_help') }}</small>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">{{ trans('cms::cms.menus.target') }}</label>
                                                                <select class="form-select" name="items[{{ $index }}][target]">
                                                                    <option value="_self" {{ old('items.'.$index.'.target', $item->target) == '_self' ? 'selected' : '' }}>
                                                                        {{ trans('cms::cms.menus.target_self') }}
                                                                    </option>
                                                                    <option value="_blank" {{ old('items.'.$index.'.target', $item->target) == '_blank' ? 'selected' : '' }}>
                                                                        {{ trans('cms::cms.menus.target_blank') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">{{ trans('cms::cms.pages.order') }}</label>
                                                                <input type="number" class="form-control" name="items[{{ $index }}][order]"
                                                                       value="{{ old('items.'.$index.'.order', $item->order) }}" min="0">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">{{ trans('cms::cms.menus.icon') }}</label>
                                                                <input type="text" class="form-control" name="items[{{ $index }}][icon]"
                                                                       value="{{ old('items.'.$index.'.icon', $item->icon) }}">
                                                                <small class="text-muted">{{ trans('cms::cms.menus.icon_help') }}</small>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">{{ trans('cms::cms.menus.css_class') }}</label>
                                                                <input type="text" class="form-control" name="items[{{ $index }}][css_class]"
                                                                       value="{{ old('items.'.$index.'.css_class', $item->css_class) }}">
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           name="items[{{ $index }}][is_active]" value="1"
                                                                           {{ old('items.'.$index.'.is_active', $item->is_active) ? 'checked' : '' }}>
                                                                    <label class="form-check-label">
                                                                        {{ trans('cms::cms.menus.active') }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-secondary" id="add-menu-item">
                                            <i class="ti tabler-plus icon-base me-1"></i>
                                            {{ trans('cms::cms.menus.add_item') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="card my-3">
                                    <div class="card-header">
                                        <h5 class="mb-1">{{ trans('cms::cms.menus.settings') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <x-core::input
                                                label="cms::cms.menus.slug"
                                                type="text"
                                                name="slug"
                                                id="slug"
                                                value="{{ old('slug', $menu->slug) }}"
                                                required="required" />
                                            <small class="text-muted">{{ trans('cms::cms.menus.slug_help') }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::input
                                                label="cms::cms.menus.location"
                                                type="text"
                                                name="location"
                                                id="location"
                                                value="{{ old('location', $menu->location) }}" />
                                            <small class="text-muted">{{ trans('cms::cms.menus.location_help') }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    {{ trans('cms::cms.menus.active') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">{{ trans('cms::cms.menus.update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
<script>
let itemIndex = {{ $menu->items->count() }};

document.getElementById('add-menu-item').addEventListener('click', function() {
    const container = document.getElementById('menu-items-container');
    const languages = @json(LanguageEnum::values());

    const itemHtml = `
        <div class="card mb-3 menu-item" data-index="${itemIndex}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">{{ trans('cms::cms.menus.items') }} #${itemIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-item">
                        <i class="ti tabler-trash icon-base"></i>
                    </button>
                </div>

                <ul class="nav nav-tabs mb-3" role="tablist">
                    ${languages.map((lang, idx) => `
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link ${idx === 0 ? 'active' : ''}"
                                    role="tab" data-bs-toggle="tab"
                                    data-bs-target="#item-${itemIndex}-${lang}">
                                ${lang.toUpperCase()}
                            </button>
                        </li>
                    `).join('')}
                </ul>

                <div class="tab-content mb-3">
                    ${languages.map((lang, idx) => `
                        <div class="tab-pane fade ${idx === 0 ? 'active show' : ''}"
                             id="item-${itemIndex}-${lang}" role="tabpanel">
                            <label class="form-label">{{ trans('cms::cms.menus.item_title') }} *</label>
                            <input type="text" class="form-control"
                                   name="items[${itemIndex}][title][${lang}]" required>
                        </div>
                    `).join('')}
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ trans('cms::cms.menus.link_to_page') }}</label>
                        <select class="form-select" name="items[${itemIndex}][page_id]">
                            <option value="">{{ trans('cms::cms.menus.none') }}</option>
                            @foreach($pages as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ trans('cms::cms.menus.item_url') }}</label>
                        <input type="text" class="form-control" name="items[${itemIndex}][url]">
                        <small class="text-muted">{{ trans('cms::cms.menus.item_url_help') }}</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ trans('cms::cms.menus.target') }}</label>
                        <select class="form-select" name="items[${itemIndex}][target]">
                            <option value="_self">{{ trans('cms::cms.menus.target_self') }}</option>
                            <option value="_blank">{{ trans('cms::cms.menus.target_blank') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ trans('cms::cms.pages.order') }}</label>
                        <input type="number" class="form-control" name="items[${itemIndex}][order]" value="0" min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ trans('cms::cms.menus.icon') }}</label>
                        <input type="text" class="form-control" name="items[${itemIndex}][icon]">
                        <small class="text-muted">{{ trans('cms::cms.menus.icon_help') }}</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ trans('cms::cms.menus.css_class') }}</label>
                        <input type="text" class="form-control" name="items[${itemIndex}][css_class]">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="items[${itemIndex}][is_active]" value="1" checked>
                            <label class="form-check-label">
                                {{ trans('cms::cms.menus.active') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', itemHtml);
    itemIndex++;
});

document.getElementById('menu-items-container').addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {
        e.target.closest('.menu-item').remove();
    }
});
</script>
@endsection
