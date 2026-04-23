@php use Modules\Theme\Helpers\Helpers; @endphp
@isset($pageConfigs)
    {!! Helpers::updatePageConfig($pageConfigs) !!}
@endisset
@php
    $configData = Helpers::appClasses();
@endphp

@isset($configData['layout'])
    @include(
        $configData['layout'] === 'horizontal'
            ? 'customer.layouts.horizontalLayout'
            : ($configData['layout'] === 'blank'
                ? 'customer.layouts.blankLayout'
                : ($configData['layout'] === 'front'
                    ? 'customer.layouts.layoutFront'
                    : 'customer.layouts.contentNavbarLayout')))
@endisset
