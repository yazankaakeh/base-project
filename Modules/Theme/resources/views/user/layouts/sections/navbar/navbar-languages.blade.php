<!-- Language -->
<li class="nav-item dropdown-language dropdown me-2 me-xl-0">
  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
    <i class="icon-base ti tabler-language icon-22px text-heading"></i>
  </a>
  <ul class="dropdown-menu dropdown-menu-end">
    <li>
      <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
         href="{{route('locale',['locale'=> 'en'])}}"
         data-language="en" data-text-direction="ltr">
                      <span class="align-middle">
                        {{trans('customer.languages.english')}}
                      </span>
      </a>
    </li>
    <li>
      <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
         href="{{route('locale',['locale'=> 'ar'])}}"
         data-language="ar" data-text-direction="rtl">
                      <span class="align-middle">
                        {{trans('customer.languages.arabic')}}</span>
      </a>
    </li>
    <li>
      <a class="dropdown-item {{ app()->getLocale() == 'tr' ? 'active' : '' }}"
         href="{{route('locale',['locale'=> 'tr'])}}"
         data-language="ar" data-text-direction="rtl">
                      <span class="align-middle">
                        {{trans('customer.languages.turkish')}}</span>
      </a>
    </li>
  </ul>
</li>
<!--/ Language -->
