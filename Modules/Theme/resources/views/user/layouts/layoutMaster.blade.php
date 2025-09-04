@isset($pageConfigs)
  {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
  $configData = Helper::appClasses();
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
