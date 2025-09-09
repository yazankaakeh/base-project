@if($language)

  <div class="{{$divClass}}">
    @php
      $name = "langs[$language][$name]";
    @endphp
    <label class="form-label" for="{{$id.'_'.$language}}">{{"$label $language"}}</label>
    <x-blog::InputComponent
      name="{{$name}}" divClass="form-control" type="{{$type}}" id="{{$id.'_'.$language}}" required='required'>
    </x-blog::InputComponent>
  </div>
@endif

@foreach($langs as $lang)
  <div class="{{$divClass}}">
    @php
      $newName= '';
      $newName = "langs[$lang->value][$name]";
    @endphp
    <label class="form-label" for="{{$id.'_'.$lang->value}}">{{"$label $lang->value"}}</label>
    <x-blog::InputComponent type="{{$type}}" name="{{$newName}}" divClass="form-control"
                            id="{{$id.'_'.$lang->value}}" required='required'>
    </x-blog::InputComponent>
  </div>
@endforeach


