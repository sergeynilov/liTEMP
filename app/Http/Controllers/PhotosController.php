<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Nomination;

use App\Models\PhotoNomination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use DB;
use App\Models\User;
use App\Models\PhotoLike;
use App\Models\PhotoFavorite;


class PhotosController extends Controller
{
    public function one_photo($slug, $photo_source = '')
    {
//        \Log::info(varDump($slug, ' -1 one_photo $slug::'));
//        \Log::info(varDump($photo_source, ' -1 one_photo $photo_source::'));

        $a = pregSplit('/\./', $slug);
//        \Log::info(varDump($a, ' -1 $a::'));
        $photo_id = null;
        if ( ! empty($a[1])) {
            $photo_id = $a[1];
        } else {
            if ( !empty($a[0]) and is_numeric($a[0]) and empty($a[1])) {
                $photo_id = $a[0];
//                \Log::info(  varDump($photo_id, ' -19 $photo_id::') );
            }
        }


        $photo = Photo
            ::getById($photo_id)
            ->getByActive(true)
            ->with('owner')
            ->first();

        if (empty($photo)) {
            return redirect('/')
                ->with('status', 'Страница не найдены');
        }


        // -1 one_photo $photo_source:: : nomination.2
        $a = pregSplit('/\./', $photo_source);
//        \Log::info(varDump($a, ' -101 $a::'));

        $photo_id = null;
        if ( ! empty($a[1])) {
            $photo_id = $a[1];
        }


        return view('frontend.photos.one_photo', [
            'photo'  => $photo,
            'source' => $photo_source,
        ]);
    } // public function one_photo($slug, $photo_source= '')

    // Route::get('/load_one_photo/{photo_id}/{photo_source?}', [FrontendPhotosController::class, 'load_one_photo'])->name('load_one_photo');
    public function load_one_photo($photo_id, $photo_source = '')
    {
//        \Log::info(varDump($photo_id, ' -1 load_one_photo $photo_id::'));
//        \Log::info(varDump($photo_source, ' -1 load_one_photo $photo_source::'));

        $photo = Photo
            ::getById($photo_id)
            ->with('owner')
            ->withCount('photoLikes')
            ->withCount('photoFavorites')
            ->with('photoNominations.nomination')
            ->first();
//        \Log::info(varDump($photo, ' -1 load_one_photo $photo::'));

        $logged_user_photo_likes_count     = 0;
        $logged_user_photo_favorites_count = 0;
        $loggedUser                        = auth()->user();
        if ( ! empty($loggedUser)) {
            $logged_user_photo_likes_count     = PhotoLike
                ::getByPhotoId($photo_id)
                ->getByUserId($loggedUser->id)
                ->count();
            $logged_user_photo_favorites_count = PhotoFavorite
                ::getByPhotoId($photo_id)
                ->getByUserId($loggedUser->id)
                ->count();
        }
//        \Log::info(varDump($logged_user_photo_favorites_count, ' -1 $logged_user_photo_favorites_count::'));

        $this->media_image_url = '';
        foreach ($photo->getMedia('photo') as $mediaImage) {
            $photo->media_image_url = $mediaImage->getUrl();
        }


        if (empty($photo)) {
            return redirect('/')
                ->with('status', 'Страница не найдены');
        }

        $prior_photo_id = null;
        $next_photo_id  = null;

        $a = pregSplit('/\./', $photo_source);
//        \Log::info(varDump($a, ' -1 load_one_photo $a::'));

        if ( ! empty($a[0]) and ! empty($a[1])) {
            $photo_source_type = $a[0];

            if ($photo_source_type == 'nomination') {
                $nomination_id  = $a[1];
                $prior_photo_id = getPriorNextPhotoId($photo_id, $photo_source_type, $nomination_id, false);
//                \Log::info(varDump($prior_photo_id, ' -1 one_photo $prior_photo_id::'));
                $next_photo_id = getPriorNextPhotoId($photo_id, $photo_source_type, $nomination_id, true);
//                \Log::info(varDump($next_photo_id, ' -1 one_photo $next_photo_id::'));
            } // if ($photo_source_type == 'nomination') {

            if ($photo_source_type == 'photos') {
//                $photo_id  = $a[1];
                $prior_photo_id = getPriorNextPhotoId($photo_id, 'photos', '', false);
//                \Log::info(varDump($prior_photo_id, ' -1 one_photo $prior_photo_id::'));
                $next_photo_id = getPriorNextPhotoId($photo_id, 'photos', '', true);
//                \Log::info(varDump($next_photo_id, ' -1 one_photo $next_photo_id::'));
            } // if ($photo_source_type == 'photos') {


            if ($photo_source_type == 'compilations') {
                $compilation_id = $a[1];
                $prior_photo_id = getPriorNextPhotoId($photo_id, $photo_source_type, $compilation_id, false);
//                \Log::info(varDump($prior_photo_id, ' -1 one_photo $prior_photo_id::'));
                $next_photo_id = getPriorNextPhotoId($photo_id, $photo_source_type, $compilation_id, true);
//                \Log::info(varDump($next_photo_id, ' -1 one_photo $next_photo_id::'));
            } // if ($photo_source_type == 'compilations') {
        }


        $html = view('frontend.photos.one_photo_loaded',
            [
                'is_user_logged'                    => ! empty($loggedUser),
                'photo_id'                          => $photo_id,
                'prior_photo_id'                    => $prior_photo_id,
                'next_photo_id'                     => $next_photo_id,
                'photo_source'                      => $photo_source,
                'photo'                             => $photo,
                'logged_user_photo_likes_count'     => $logged_user_photo_likes_count,
                'logged_user_photo_favorites_count' => $logged_user_photo_favorites_count
            ])->render();

        return response()->json(
            [
                'is_user_logged' => ! empty($loggedUser),
                'html'           => $html,
                'photo_id'       => $photo_id,
                'photo_source'   => $photo_source,
                'photo'          => $photo
            ], HTTP_RESPONSE_OK);
    } // public function load_one_photo($photo_id, $photo_source= '')


    public function add_photo_like()
    {
        $request     = request();
        $requestData = $request->all();
//        \Log::info('-1 add_photo_like $requestData ::' . print_r(json_encode($requestData), true));

        if ( ! isUserLogged()) {
            return response()->json([
                'message'           => 'Вы должны войти в систему для голосования ',
                'photo'             => null,
                'photoLike'         => null,
                'photo_likes_count' => 0
            ],
                HTTP_RESPONSE_BAD_REQUEST);
        }
        $loggedUser = auth()->user();

        $photo = Photo::find($requestData['photo_id'] ?? null);
        if (empty($photo)) {
            return response()->json([
                'message'           => 'Photo # "' . $requestData['photo_id'] . '" not found !',
                'photo'             => null,
                'photoLike'         => null,
                'photo_likes_count' => 0
            ],
                HTTP_RESPONSE_BAD_REQUEST);
        }

        $logged_user_photo_likes_count = PhotoLike
            ::getByPhotoId($requestData['photo_id'])
            ->getByUserId($loggedUser->id)
            ->count();

        if ($logged_user_photo_likes_count === 0) {
            $photoLike           = new PhotoLike();
            $photoLike->photo_id = $requestData['photo_id'];
            $photoLike->user_id  = $loggedUser->id;
            $photoLike->save();
        }

        $photo_likes_count = PhotoLike
            ::getByPhotoId($requestData['photo_id'])
            ->count();

        return response()->json(
            [
                'photo'             => $photo,
                'photoLike'         => $photoLike ?? null,
                'photo_likes_count' => $photo_likes_count
            ], HTTP_RESPONSE_OK);

    } // public function add_photo_like()


    public function add_photo_favorite()
    {
        $request     = request();
        $requestData = $request->all();
//        \Log::info('-1 add_photo_favorite $requestData ::' . print_r(json_encode($requestData), true));

        if ( ! isUserLogged()) {
            return response()->json([
                'message'               => 'Вы должны войти в систему для голосования ',
                'photo'                 => null,
                'photoFavorite'         => null,
                'photo_favorites_count' => 0
            ],
                HTTP_RESPONSE_BAD_REQUEST);
        }
        $loggedUser = auth()->user();

        $photo = Photo::find($requestData['photo_id'] ?? null);
        if (empty($photo)) {
            return response()->json([
                'message'               => 'Photo # "' . $requestData['photo_id'] . '" not found !',
                'photo'                 => null,
                'photoFavorite'         => null,
                'photo_favorites_count' => 0
            ],
                HTTP_RESPONSE_BAD_REQUEST);
        }

        $logged_user_photo_favorites_count = PhotoFavorite
            ::getByPhotoId($requestData['photo_id'])
            ->getByUserId($loggedUser->id)
            ->count();

        if ($logged_user_photo_favorites_count === 0) {
            $photoFavorite           = new PhotoFavorite();
            $photoFavorite->photo_id = $requestData['photo_id'];
            $photoFavorite->user_id  = $loggedUser->id;
            $photoFavorite->save();
        }

        $photo_favorites_count = PhotoFavorite
            ::getByPhotoId($requestData['photo_id'])
            ->count();

        return response()->json(
            [
                'photo'                 => $photo,
                'photoFavorite'         => $photoFavorite ?? null,
                'photo_favorites_count' => $photo_favorites_count
            ], HTTP_RESPONSE_OK);

    } // public function add_photo_favorite()


    public function photos_without_nominations()
    {
        if ( ! isUserLogged()) {
            Auth::logout();

            return redirect('/')
                ->with('status', 'У вас нет доступа к этой странице');
        }

        return view('frontend.photos.index', []);
    }

    public function get_photos_without_nominations($current_page = 1)
    {
        $photos_without_nominations_per_page = (int)(config('app.photos_without_nominations_per_page', 15));
        if ( ! isUserLogged()) {
            Auth::logout();

            return redirect('/')
                ->with('status', 'У вас нет доступа к этой странице');
        }

        $start               = ($current_page - 1) * $photos_without_nominations_per_page;
        $rows_uploaded_count = $current_page * $photos_without_nominations_per_page;

        $photos_without_nominations_total_count = Photo
            ::getByActive(true)
            ->withCount('photoNominations')
            ->getByPhotoNominationsCount(0)
            ->count();

        $photosWithoutNominations = Photo
            ::getByActive(true)
            ->withCount('photoNominations')
            ->getByPhotoNominationsCount(0)
            ->offset($start)->limit($photos_without_nominations_per_page)
            ->with('owner')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($photoItem) {
                $photoItem->photo_likes_count = PhotoLike
                    ::getByPhotoId($photoItem->id)
                    ->count();

                $media_image_url = '';
                $file_name       = '';
                foreach ($photoItem->getMedia('photo') as $mediaImage) {
                    $media_image_url = $mediaImage->getUrl();
                    $file_name       = $mediaImage->file_name;
                }
                $photoItem->media_image_url = $media_image_url;
                $photoItem->file_name       = $file_name;

                $avatar_media_image_url = '';
                $avatar_file_name       = '';
                foreach ($photoItem->owner->getMedia('avatar') as $mediaImage) {
                    $avatar_media_image_url = $mediaImage->getUrl();
                    $avatar_file_name       = $mediaImage->avatar_file_name;
                }
                $photoItem->avatar_media_image_url = $avatar_media_image_url;
                $photoItem->avatar_file_name       = $avatar_file_name;

                return $photoItem;
            });

        $html = view('frontend.photos.photos_without_nominations_rows',
            [
                'photos_without_nominations_total_count' => $photos_without_nominations_total_count,
                'rows_uploaded_count'                    => $rows_uploaded_count,
                'photosWithoutNominations'               => $photosWithoutNominations
            ])->render();

        return response()->json(
            [
                'html'                                   => $html,
                'photos_without_nominations_total_count' => $photos_without_nominations_total_count,
                'rows_uploaded_count'                    => $rows_uploaded_count,
            ], HTTP_RESPONSE_OK);
    } // photos_without_nominations

}

