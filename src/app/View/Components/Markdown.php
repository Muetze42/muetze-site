<?php

namespace NormanHuth\Muetze\app\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Markdown extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.markdown');
    }
}
