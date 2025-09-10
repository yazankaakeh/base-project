<?php

namespace Modules\Blog\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class InputComponent extends Component
{
  /**
   * Create a new component instance.
   */
  public function __construct(public string  $name,
                              public string  $divClass,
                              public string  $type,
                              public string  $id,
                              public ?string $required = 'required',
                              public ?string $value = null)
  {
    //
  }

  /**
   * Get the view/contents that represent the component.
   */
  public function render(): View|string
  {
    return view('blog::components.inputComponent');
  }
}
