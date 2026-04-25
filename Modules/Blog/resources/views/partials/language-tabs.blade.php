@php use Modules\Core\App\Enums\LanguageEnum; @endphp

<div class="card-header px-0 pt-0">
    <div class="nav-align-top">
        <ul class="nav nav-tabs" role="tablist">
            @foreach(LanguageEnum::values() as $lang)
                <li class="nav-item" role="presentation">
                    <button type="button"
                            class="nav-link waves-effect {{$lang == app()->getLocale() ? 'active': ''}}"
                            role="tab"
                            data-bs-toggle="tab" data-bs-target="#navs-tab-{{$lang}}"
                            aria-controls="navs-tab-home" aria-selected="true">{{$lang}}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
