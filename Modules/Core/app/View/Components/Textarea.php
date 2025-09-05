<?php

namespace Modules\Core\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Textarea extends Component
{
  /**
   * Create a new component instance.
   */
  public function __construct(
    public string $label,
    public string $id,
    public string $name,
    public string $model,
    public string $required = 'required',
    public string $value = '',
    public string $class = '',
  )
  {
    //
  }

  /**
   * Get the view/contents that represent the component.
   */
  public function render(): View|string
  {
    return view('core::components.textarea');
  }
}
