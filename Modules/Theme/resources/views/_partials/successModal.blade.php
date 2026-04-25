<div wire:ignore.self class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content modal-margin">
      <div class="modal-body">
        <div class="container mt-2">
          <div class="text-center">
            <img src="{{asset('assets/successIcon.svg')}}" style="height: 100%" alt="">
          </div>
          <div class=" mt-2">
            <div class="text-success-model text-center">
              <h4 id="successMessage">

              </h4>
            </div>
            <div class="text-success-thx text-center">
              <h5 id="successMessageDescription">

              </h5>
            </div>
            <div class="text-center">
              <a href="{{route('customer.home')}}" class="btn btn-primary">
                {{trans('customer.cancel')}}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
