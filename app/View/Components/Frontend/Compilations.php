<?php

namespace App\View\Components\Frontend;

use App\Models\Compilation;
use App\Models\PhotoCompilation;
use App\Models\Photo;
use Illuminate\View\Component;

class Compilations extends Component
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

    public function render()
    {
        $compilations = Compilation
            ::getByActive(true)
            ->orderBy('compilations.ordering', 'asc')
            ->get()
            ->map(function ($compilationItem) {
                $photoCompilationIds= PhotoCompilation
                    ::getByCompilationId($compilationItem->id)
                    ->getByPhotoActive(true)
                    ->get()
                    ->pluck('photo_id')
                    ->toArray();

                if(count($photoCompilationIds) > 0) {
                    $compilationItem->total_photos_count= count($photoCompilationIds);

                    $photo_id= $photoCompilationIds[ rand(0, count($photoCompilationIds) - 1) ];
                    $randPhoto= Photo
                        ::find($photo_id);

                    if(!empty($randPhoto)) {
                        foreach ($randPhoto->getMedia('photo') as $mediaImage) {
                            $compilation_media_image_url = $mediaImage->getUrl();
                            $compilationItem->compilation_media_image_url= $compilation_media_image_url;
                        }

                    }

                }
                return $compilationItem;
            });

//        \Log::info(  varDump($compilations, ' -1 $compilations::') );
        return view('components.frontend.compilations', [
            'compilations'=> $compilations
        ]);
    }
}
