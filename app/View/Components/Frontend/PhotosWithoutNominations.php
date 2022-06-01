<?php

namespace App\View\Components\Frontend;

use App\Models\Photo;
use Illuminate\View\Component;

class PhotosWithoutNominations extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.photos_without_nominations_container');
    }
}
