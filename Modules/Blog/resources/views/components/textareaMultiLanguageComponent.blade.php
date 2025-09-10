@if($language)
  <div class="{{$divClass}}">
    @php
      $name = "langs[$language][$name]";
    @endphp
    <label class="form-label" for="{{$id.'_'.$language}}">{{"$label $language"}}</label>
    <x-blog::textareaComponent name="{{$name}}" required="required"
                               id="{{$id.'_'.$language}}" divClass="form-control bootstrap-maxlength-example" rows="3"
                               maxlength="255">
    </x-blog::textareaComponent>
  </div>
@endif
@foreach($langs as $lang)
  @php
    $name = "langs[$lang->value][$name]";
  @endphp
  <div class="{{$divClass}}">
    <label class="form-label" for="{{$id.'_'.$lang->value}}">{{"$label $lang->value"}}</label>
    <x-blog::textareaComponent name="{{$name}}"
                               id="{{$id.'_'.$lang->value}}" divClass="form-control bootstrap-maxlength-example"
                               rows="3" required="required"
                               maxlength="255">
    </x-blog::textareaComponent>


  </div>
@endforeach
