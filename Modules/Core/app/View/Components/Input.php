<?php

namespace Modules\Core\app\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
        public ?string $model,
        public ?string $modelSearch,
        public ?string $label,
        public ?string $placeholder,
        public ?string $tooltip,
        public string $required = 'required',
        public string $value = '',
        public string $class = '',
        public string $lang = '',
    ) {
        //
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('core::components.input');
    }
}
