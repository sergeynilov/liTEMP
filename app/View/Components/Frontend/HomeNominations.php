<?php

namespace App\View\Components\Frontend;

use App\Models\Nomination;
use App\Models\NominationPhotoCover;
use App\Models\Photo;
use Illuminate\View\Component;

class HomeNominations extends Component
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

        $homeNominations = Nomination
            ::getByActive(true)
            ->orderBy('nominations.ordering', 'asc')
            ->limit(9)
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
//        \Log::info(  varDump($homeNominations, ' -1 HomeNominations $homeNominations::') );

        return view('components.frontend.home-nominations', [
            'homeNominations'=> $homeNominations
        ]);

        return view('components.frontend.home-nominations');
    }
}
