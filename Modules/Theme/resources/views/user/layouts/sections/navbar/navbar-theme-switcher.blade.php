<li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
  <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
     data-bs-toggle="dropdown">
    <i class="icon-base ti tabler-sun icon-lg theme-icon-active"></i>
    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
  </a>
  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
    <li>
      <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="light"
              aria-pressed="false">
                  <span><i class="icon-base ti tabler-sun icon-md me-3" data-icon="sun"></i>
                    {{trans('newLandingPage.themeOptions.light')}}
                  </span>
      </button>
    </li>
    <li>
      <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
              aria-pressed="true">
                  <span><i class="icon-base ti tabler-moon-stars icon-md me-3" data-icon="moon-stars"></i>
                    {{trans('newLandingPage.themeOptions.dark')}}
                  </span>
      </button>
    </li>
    <li>
      <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
              aria-pressed="false">
                <span><i class="icon-base ti tabler-device-desktop-analytics icon-md me-3"
                         data-icon="device-desktop-analytics"></i>
                  {{trans('newLandingPage.themeOptions.system')}}
                </span>
      </button>
    </li>
  </ul>
</li>
