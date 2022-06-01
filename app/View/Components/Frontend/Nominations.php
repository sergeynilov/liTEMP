<?php

namespace App\View\Components\Frontend;

use App\Models\Nomination;
use App\Models\Photo;
use App\Models\NominationPhotoCover;
use Illuminate\View\Component;

class Nominations extends Component
{

    public function __construct( )
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $nominations = Nomination
            ::getByActive(true)
            ->orderBy('nominations.ordering', 'asc')
            ->get()
            ->map(function ($nominationItem) {
                $photoNominationIds= NominationPhotoCover
                    ::getByNominationId($nominationItem->id)
                    ->getByPhotoActive(true)
                    ->get()
                    ->pluck('photo_id')
                    ->toArray();
                if(count($photoNominationIds) > 0) {
                    $nominationItem->total_photos_count= count($photoNominationIds);

                    $photo_id= $photoNominationIds[ rand(0, count($photoNominationIds) - 1) ];
                    $randPhoto= Photo
                        ::find($photo_id);

                    if(!empty($randPhoto)) {
                        foreach ($randPhoto->getMedia('photo') as $mediaImage) {
                            $nomination_media_image_url = $mediaImage->getUrl();
                            $nominationItem->nomination_media_image_url= $nomination_media_image_url;
                        }
                    }
//                    $nominationItem->slug_link= $nominationItem->slug . '.' . $nominationItem->id;
                }
                return $nominationItem;
            });


        return view('components.frontend.nominations', [
            'nominations'=> $nominations
        ]);
    }
}
