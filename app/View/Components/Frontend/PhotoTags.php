<?php

namespace App\View\Components\Frontend;

use App\Models\PhotoTag;
use Illuminate\View\Component;

class PhotoTags extends Component
{
    public $photo_id;
    public $photoTags;
    public $source;

    public function __construct($id, $source = null)
    {
        $this->photo_id  = $id;
        $this->photoTags = PhotoTag
            ::getByPhotoId($this->photo_id)
            ->with('tag')
            ->get();
        $this->source    = $source;

    }

    public function render()
    {
        return view('components.frontend.photo-tags');
    }
}
