<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class CompilationWithPhotos extends Component
{
    public $defaultCompilation;

    public function __construct($defaultCompilation= null)
    {
        $this->defaultCompilation= $defaultCompilation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.compilation.compilation-with-photos-container');
    }
}
