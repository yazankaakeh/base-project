<style>
  img.img-rounded {
    width: 150px !important;
    height: 150px !important;
    object-fit: cover;
    border-radius: 50%; /* optional */
  }

</style>
<div class="card">
  <div class="card-body text-center">
    <div class="dropdown btn-pinned">
      <div class="d-flex mx-4">
        <a class="mx-2 text-primary" onclick="copyLink('{{$card->full_link}}')">
          <i class="ti tabler-share icon-base"></i>
        </a>
        <a class="mx-2 text-primary"
           href="{{route('card.updateOrCreate',$card->id)}}">
          <i class="ti tabler-pencil icon-base"></i>
        </a>
        @livewire('update-card-status',['card_id' => $card->id, 'is_active' => $card->is_active])
      </div>
      {{-- <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"
               aria-expanded="false">
         <i class="ti icon-base tabler-dots-vertical text-muted"></i></button>
       <ul class="dropdown-menu dropdown-menu-end">
         <li>
           <a class="dropdown-item" onclick="copyLink('{{$card->full_link}}')">{{trans('customer.card.share')}}</a>
         </li>
         <li>
           <a class="dropdown-item"
              href="{{route('card.updateOrCreate',$card->id)}}">{{trans('customer.card.edit')}}</a></li>
         <li>
           <hr class="dropdown-divider">
         </li>
         <li>
           @livewire('update-card-status',['card_id' => $card->id, 'is_active' => $card->is_active])
         </li>
       </ul>--}}
    </div>
    <div class="mx-auto my-3">
      <img src="{{$card->img}}"
           alt="Avatar Image" class="img-rounded w-px-100">
    </div>
    <h4 class="mb-1 card-title">{{$card->full_name}}</h4>
    <div class="d-flex align-items-center justify-content-center my-3 gap-2">
      @foreach($card->card_badges as $card_badge)
        @includeIf('_partials.cards.__card_badge',['card_badge'=>$card_badge])
      @endforeach
    </div>

    <div class="d-flex align-items-center justify-content-around my-3 py-1">
      <div>
        <h4 class="mb-0">{{$card->all_contacts_count}}</h4>
        <span>{{trans('customer.card.connection')}}</span>
      </div>

      <div>
        <h4 class="mb-0">{{$card->downloaded_csv}}</h4>
        <span>{{trans('customer.card.savedContact')}}</span>
      </div>
    </div>

    <div class="d-flex align-items-center justify-content-center">
      <a @if($card->is_active->value)
           href="{{route('customer.previewCard',['cardLink'=>$card->link])}}"
         @else
           href="javascript:void(0)"
         @endif
         class="btn
          @if($card->is_active->value)
           btn-primary
      @else
          btn-secondary
        @endif cardPreview-{{$card->id}} d-flex align-items-center me-3 waves-effect waves-light">
        <i class="ti-xs me-1 ti tabler-user-check me-1"></i>
        {{trans('customer.card.view')}}
      </a>
    </div>

  </div>
</div>

<script>


  function copyLink(link) {
// Create a temporary input
    const tempInput = document.createElement('input');
    tempInput.value = link;
    document.body.appendChild(tempInput);

    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // for mobile

    document.execCommand('copy');
    document.body.removeChild(tempInput);
  }
</script>
