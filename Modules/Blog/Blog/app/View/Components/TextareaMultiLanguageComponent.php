<?php

namespace Modules\Blog\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Blog\Enum\Languages;

class TextareaMultiLanguageComponent extends Component
{
  /**
   * Create a new component instance.
   */
  public function __construct(public string  $name,
                              public string  $divClass,
                              public string  $label,
                              public string  $id,
                              public array   $langs = [],
                              public ?string $language = null,
                              public ?object $item = null)
  {
    //
  }

  /**
   * Get the view/contents that represent the component.
   */
  public function render(): View|string
  {
    if (!empty($this->lang))
      $this->langs = Languages::cases();
    return view('blog::components.textareaMultiLanguageComponent');
  }
}
