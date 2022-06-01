<?php

namespace App\View\Components\Frontend;

use App\Models\Photo;
use Illuminate\View\Component;

class HomeHeader extends Component
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
        $homepagePhotoIds           = Photo
            ::getByShownOnHomepage(true)
            ->getByActive(true)
            ->get()
            ->pluck('id')
            ->toArray();
//        \Log::info(  varDump($homepagePhotoIds, ' -1 $homepagePhotoIds::') );
        $homepagePhoto= null;
        if(count($homepagePhotoIds) ) {

            $photo_id= $homepagePhotoIds[ rand(0, count($homepagePhotoIds) - 1) ];
//            \Log::info(  varDump($photo_id, ' -1 $photo_id::') );
            $homepagePhoto= Photo
                ::getById($photo_id)
                ->with('photoNominations')
                ->with('photoNominations.nomination')
                ->first();

            if(!empty($homepagePhoto)) {
                foreach ($homepagePhoto->getMedia('photo') as $mediaImage) {
//                    \Log::info(  varDump($mediaImage, ' -1 $mediaImage::') );
                    $homepage_media_image_url = $mediaImage->getUrl();
                    $homepagePhoto->homepage_media_image_url= $homepage_media_image_url;
                }
            }
        }
        return view('components.frontend.home-header', [
            'homepagePhoto'=> $homepagePhoto
        ]);
    }
}
