@extends('admin/layouts/layoutMaster')

@section('title', 'Cards Actions- UI elements')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/block-ui/block-ui.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sortablejs/sortable.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/cards-actions.js')}}"></script>
@endsection

@section('content')

  <h4 class="py-3 mb-4"><span class="text-muted fw-light">UI Elements /</span> Cards Actions
  </h4>

  <div class="row mb-5">
    <div class="col-md">
      <div class="card card-action mb-4">
        <div class="card-header">
          <div class="card-action-title">Collapsible Card</div>
          <div class="card-action-element">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <a href="javascript:void(0);" class="card-collapsible"><i
                    class="tf-icons ti ti-chevron-right scaleX-n1-rtl ti-sm"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="collapse show">
          <div class="card-body">
            <p class="card-text">To create a collapsible card, use <code>.card-collapsible</code> class with action
              item. To show the collapsible content default use <code>.show</code> class with <code>.collapse</code>.
            </p>
            <p class="card-text d-flex align-items-center gap-1">Click on <i
                class="tf-icons ti ti-chevron-right scaleX-n1-rtl"></i> to see card collapse in action.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card card-action mb-4">
        <div class="card-alert"></div>
        <div class="card-header">
          <div class="card-action-title">Refresh Content</div>
          <div class="card-action-element">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <a href="javascript:void(0);" class="card-reload"><i
                    class="tf-icons ti ti-rotate-clockwise-2 scaleX-n1-rtl ti-sm"></i></a>
              </li>
            </ul>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">To create a card with refresh action, use <code>.card-reload</code> class with action
            item. Use <code>.card-alert</code> class to show custom response message.</p>
          <p class="card-text d-flex align-items-center gap-1">Click on <i
              class="tf-icons ti ti-rotate-clockwise-2 scaleX-n1-rtl"></i> icon to see refresh card content in action.
          </p>
        </div>
      </div>
    </div>
    <div class="w-100"></div>
    <div class="col-md">
      <div class="card card-action mb-4">
        <div class="card-header">
          <div class="card-action-title">Expand Card</div>
          <div class="card-action-element">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <a href="javascript:void(0);" class="card-expand"><i
                    class="tf-icons ti ti-arrows-maximize ti-sm"></i></a>
              </li>
            </ul>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">To create a card with expand(fullscreen) action, use <code>.card-expand</code> class with
            action item. Use <kbd>ESC</kbd> key to exit from the fullscreen mode.</p>
          <p class="card-text d-flex align-items-center gap-1">Click on <i class="tf-icons ti ti-arrows-maximize"></i>
            icon to see expand card in action.</p>
        </div>
      </div>
    </div>
    <div class="col-md">
      <div class="card card-action mb-4">
        <div class="card-alert"></div>
        <div class="card-header">
          <div class="card-action-title">Remove Card</div>
          <div class="card-action-element">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                <a href="javascript:void(0);" class="card-close"><i class="tf-icons ti ti-x ti-sm"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card-body">
          <p class="card-text">Remove card action hide the card, use <code>.card-close</code> class with action item.
          </p>
          <br />
          <p class="card-text d-flex align-items-center gap-1">Click on <i class="tf-icons ti ti-x"></i> icon to see
            remove card in action.</p>
        </div>
      </div>
    </div>
  </div>

@endsection
