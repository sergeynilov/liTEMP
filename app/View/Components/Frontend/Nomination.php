<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;
use App\Models\PhotoNomination;
use App\Models\PhotoLike;

class Nomination extends Component
{
    public $defaultNomination;
    public $nominatedPhotos;
    public $nominatedPhotosPagination;

    public function __construct($defaultNomination, $nominatedPhotos, $nominatedPhotosPagination)
    {
        $this->defaultNomination= $defaultNomination;
        $this->nominatedPhotos= $nominatedPhotos;
        $this->nominatedPhotosPagination= $nominatedPhotosPagination;
    }

    public function render()
    {
        $nominations = \App\Models\Nomination
            ::orderBy('ordering', 'asc')
            ->get();

        $currentNomination= $this->defaultNomination;
        $current_nomination_id= $this->defaultNomination->id;

        foreach( $nominations as $next => $nextNomination ) {
            if($nextNomination->id == $current_nomination_id) {
                $currentNomination= $nextNomination;
                break;
            }
        }
        return view('components.frontend.nomination.nomination', [
            'nominations'=> $nominations,
            'current_nomination'=> $current_nomination_id,
            'currentNomination'=> $currentNomination,
//            'nominatedPhotos'=> $nominatedPhotos,
        ]);
    }

    public function get_nominated_photos($nomination_id, $current_page= 1)
    {
    }
}
