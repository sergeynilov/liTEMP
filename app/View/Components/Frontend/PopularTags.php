<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

use App\Models\PhotoTag;
use DB;
use App\Config;

class PopularTags extends Component
{
    public $rowsLimit;
    public function __construct($rowsLimit= -1)
    {
        $this->rowsLimit= $rowsLimit;
    }

    public function render()
    {
        $popularTags = PhotoTag
            ::orderBy('total_tags_count', 'desc')
            ->limit($this->rowsLimit)
            ->select('tag_id', DB::raw('count(*) as total_tags_count'))
            ->groupBy('tag_id')
            ->havingRaw('count(*) >= 1')
            ->with('tag')
            ->get();

        return view('components.frontend.popular-tags',
            ['popularTags' => $popularTags]
        );
    }
}
