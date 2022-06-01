<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Compilation;
use App\Models\PhotoLike;
use App\Models\PhotoCompilation;
//use App\Models\CompilationPhotoCover;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;


class CompilationsController extends Controller
{

    public function compilation_with_photos($slug = '')
    {
        \Log::info(  varDump(12, ' -12 CompilationsController compilation_with_photos::') );
        // View [frontend.compilation.compilation_with_photos] not found.
        $a = pregSplit('/\./', $slug);
        $compilation_id = null;
        if ( ! empty($a[1])) {
            $compilation_id = $a[1];
        }

        \Log::info(  varDump($compilation_id, ' -1 $compilation_id::') );
        $defaultCompilation = Compilation
            ::getById($compilation_id)
            ->first();

        if (empty($defaultCompilation)) {
            $defaultCompilation = Compilation
                ::orderBy('ordering', 'asc')
                ->first();
        }
//        \Log::info(  varDump($defaultCompilation, ' -1 compilation_with_photos $defaultCompilation::') );

        // resources/views/components/frontend/compilation/compilation-with-photos-container.blade.php
        return view('frontend.compilation.compilation_with_photos',
            [
                'defaultCompilation' => $defaultCompilation
            ]
        );
    }

/*    public function index($slug = '')
    {
        $a = pregSplit('/\./', $slug);
        $compilation_id = null;
        if ( ! empty($a[1])) {
            $compilation_id = $a[1];
        }

        $defaultCompilation = Compilation
            ::getById($compilation_id)
            ->first();

        if (empty($defaultCompilation)) {
            $defaultCompilation = Compilation
                ::orderBy('ordering', 'asc')
                ->first();
        }

        return view('frontend.compilation.index', [
            'defaultCompilation' => $defaultCompilation
        ]);
    }*/

    public function get_compilation_with_photos_rows($compilation_id, $current_page = 1)
    {
        \Log::info(varDump($compilation_id, ' -1 get_compilation_with_photos_rows  $compilation_id::'));
        \Log::info(varDump($current_page, ' -2 get_compilation_with_photos_rows  $current_page::'));

        $nominated_photos_per_page = (int)(config('app.nominated_photos_per_page', 15));
        $start                     = ($current_page - 1) * $nominated_photos_per_page;
        $rows_uploaded_count       = $current_page * $nominated_photos_per_page;

        \Log::info(varDump($start, ' -2 get_compilation_with_photos_rows  $start::'));
        \Log::info(varDump($rows_uploaded_count, ' -2 get_compilation_with_photos_rows  $rows_uploaded_count::'));

        $compilation_with_photos_total_count = PhotoCompilation
            ::getByCompilationId( $compilation_id )
            ->getByPhotoActive(true)
            ->count();

        $photosOfCompilation = PhotoCompilation
            ::getByCompilationId( $compilation_id )
            ->getByPhotoActive(true)
//            ->getById(35) // DEBUGGING
            ->offset($start)->limit($nominated_photos_per_page)
            ->with('compilation')
            ->with('photo')
            ->with('photo.owner')
            ->with('photo.photoNominations') //
            ->with('photo.photoNominations.nomination') //
            ->orderBy('photo_id', 'desc')
            ->get()
            ->map(function ($photoCompilationItem) {
                $photoItem = $photoCompilationItem->photo;

                $photoCompilationItem->photo_likes_count = PhotoLike
                    ::getByPhotoId($photoItem->id)
                    ->count();

                $media_image_url = '';
                $file_name       = '';
                foreach ($photoItem->getMedia('photo') as $mediaImage) {
                    $media_image_url = $mediaImage->getUrl();
                    $file_name       = $mediaImage->file_name;
                }
                $photoCompilationItem->media_image_url = $media_image_url;
                $photoCompilationItem->file_name       = $file_name;

                $avatar_media_image_url = '';
                $avatar_file_name       = '';
                foreach ($photoItem->owner->getMedia('avatar') as $mediaImage) {
                    $avatar_media_image_url = $mediaImage->getUrl();
                    $avatar_file_name       = $mediaImage->avatar_file_name;
                }
                $photoCompilationItem->avatar_media_image_url = $avatar_media_image_url;
                $photoCompilationItem->avatar_file_name       = $avatar_file_name;

                return $photoCompilationItem;
            });
        \Log::info(  varDump($photosOfCompilation, ' -1 $photosOfCompilation::') );

        // -1 $photosOfCompilation::
        $html = view('frontend.compilation.compilation-with-photos-rows',
            [
                'compilation_id'                => $compilation_id,
                'compilation_with_photos_total_count' => $compilation_with_photos_total_count,
                'rows_uploaded_count'          => $rows_uploaded_count,
                'photosOfCompilation'              => $photosOfCompilation
            ])->render();

        return response()->json(
            [
                'html'                         => $html,
                'compilation_with_photos_total_count' => $compilation_with_photos_total_count,
                'rows_uploaded_count'          => $rows_uploaded_count,
            ], HTTP_RESPONSE_OK);
    } // public function get_compilation_with_photos_rows($compilation_id, $current_page = 1)

    public function get_compilations_more_rows($current_page = 1)
    {
//        \Log::info(varDump($current_page, ' -2 get_compilations_more_rows  $current_page::'));

        $nominates_per_page  = (int)(config('app.nominates_per_page', 15));
        $start               = ($current_page - 1) * $nominates_per_page;
        $rows_uploaded_count = $current_page * $nominates_per_page;

//        \Log::info(varDump($start, ' -2 get_compilations_more_rows  $start::'));
//        \Log::info(varDump($rows_uploaded_count, ' -2 get_compilations_more_rows  $rows_uploaded_count::'));

        $active_compilations_total_count = Compilation
            ::getByActive(true)
            ->count();

        $activeCompilations = Compilation
            ::getByActive(true)
//            ->getById(1) // DEGUGGING
            ->offset($start)->limit($nominates_per_page)
            ->orderBy('ordering', 'asc')
            ->get()
            ->map(function ($compilationItem) {

/*                $photoCompilationIds= CompilationPhotoCover
                    ::getByCompilationId($compilationItem->id)
                    ->getByPhotoActive(true)
                    ->get()
                    ->pluck('photo_id')
                    ->toArray();*/
//                \Log::info(  varDump($photoCompilationIds, ' -1 $photoCompilationIds::') );

                if(count($photoCompilationIds) > 0) {
                    $compilationItem->total_photos_count= count($photoCompilationIds);


                    $photo_id= $photoCompilationIds[ rand(0, count($photoCompilationIds) - 1) ];
                    $randPhoto= Photo
                        ::find($photo_id);

                    \Log::info(  varDump($randPhoto, ' -1 $randPhoto::') );
                    if(!empty($randPhoto)) {
                        foreach ($randPhoto->getMedia('photo') as $mediaImage) {
                            $compilation_media_image_url = $mediaImage->getUrl();
                            $compilationItem->compilation_media_image_url= $compilation_media_image_url;
                        }
                    }
                }

                return $compilationItem;
            });
//        \Log::info(varDump($activeCompilations, ' -1 $activeCompilations::'));

        $html = view('frontend.compilation.nominates_more_rows',
            [
                'active_compilations_total_count' => $active_compilations_total_count,
                'rows_uploaded_count'            => $rows_uploaded_count,
                'activeCompilations'              => $activeCompilations
            ])->render();

        return response()->json(
            [
                'html'                            => $html,
                'active_compilations_total_count' => $active_compilations_total_count,
                'rows_uploaded_count'             => $rows_uploaded_count,
            ], HTTP_RESPONSE_OK);
    } // get_compilations_more_rows


}
