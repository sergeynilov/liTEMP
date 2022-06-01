<?php

namespace App\Http\Controllers\Profile;

use App\Models\Photo;
use App\Models\PhotoTag;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UploadPhotoRequest;

use DB;
use App\Config;
use Auth;

class ProfilePhotoController extends Controller
{

    public function get_photos($active = null)
    {
        $loggedUser = auth()->user();
//        \Log::info(varDump($active, ' -12 loggedUser ProfilePhotoController $active::'));
        $sort_by_field = 'photos.id';
        $sort_ordering = 'desc';

        $page          = $this->requestData['page'] ?? 1;
        $rows_per_page = $this->requestData['rows_per_page'] ?? 10;
        $start         = ($page - 1) * $rows_per_page;

        $total_photos_count = Photo
            ::getByOwnerId($loggedUser->id)
            ->getByActive($active)
            ->count();
        $photos             = Photo
            ::getByOwnerId($loggedUser->id)
            ->getByActive($active)
            ->orderBy($sort_by_field, $sort_ordering)
//            ->offset($start)->limit($rows_per_page)
            ->withCount('photoLikes')
            ->with('photoNominations.nomination')
            ->get();
        foreach ($photos as $nextPhoto) {
            $nextPhoto->created_at_formatted   = getFormattedDateTime($nextPhoto->created_at);
            $nextPhoto->published_at_formatted = getFormattedDateTime($nextPhoto->published_at);
            $nextPhoto->active_label           = Photo::getPhotoStatusLabel($nextPhoto->active);
            $this->media_image_url             = '';
            $this->file_name                   = '';
            foreach ($nextPhoto->getMedia('photo') as $mediaImage) {
                $nextPhoto->media_image_url = $mediaImage->getUrl();
                $nextPhoto->file_name       = $mediaImage->file_name;
            }
        }

//        \Log::info(  varDump($total_photos_count, ' -1 ProfilePhotoController $total_photos_count::') );
//        \Log::info(  varDump($photos, ' -1 ProfilePhotoController $photos::') );
        return response()->json([
            'photos'             => $photos,
            'total_photos_count' => $total_photos_count,
        ], HTTP_RESPONSE_OK);
    } // public function get_photos()


    public function get_nominated_photos()
    {
        $loggedUser = auth()->user();

//        \Log::info(  varDump( $loggedUser, ' -13 loggedUser ProfilePhotoController get_nominated_photos::') );
        $sort_by_field = 'photo_nominations_count';
        $sort_ordering = 'desc';

        $page          = $this->requestData['page'] ?? 1;
        $rows_per_page = $this->requestData['rows_per_page'] ?? 10;
        $start         = ($page - 1) * $rows_per_page;

        $nominatedPhotos = Photo
            ::getByOwnerId($loggedUser->id)
            ->orderBy($sort_by_field, $sort_ordering)
            ->offset($start)->limit($rows_per_page)
            ->withCount('photoLikes')
            ->withCount('photoNominations')
            ->with('photoNominations.nomination')
            ->havingRaw('photo_nominations_count > 0')
            ->get();
        foreach ($nominatedPhotos as $nextPhoto) {
            $nextPhoto->created_at_formatted   = getFormattedDateTime($nextPhoto->created_at);
            $nextPhoto->published_at_formatted = getFormattedDateTime($nextPhoto->published_at);
            $nextPhoto->active_label           = Photo::getPhotoStatusLabel($nextPhoto->active);
            $this->media_image_url             = '';
            $this->file_name                   = '';
            foreach ($nextPhoto->getMedia('photo') as $mediaImage) {
                $nextPhoto->media_image_url = $mediaImage->getUrl();
                $nextPhoto->file_name       = $mediaImage->file_name;
            }
        }

        $total_photo_nominations_count = count($nominatedPhotos);
//        \Log::info(  varDump($nominatedPhotos, ' -1 ProfilePhotoController $nominatedPhotos::') );
//        \Log::info(  varDump($total_photo_nominations_count, ' -1 ProfilePhotoController $total_photo_nominations_count::') );
        return response()->json([
            'nominatedPhotos'               => $nominatedPhotos,
            'total_photo_nominations_count' => $total_photo_nominations_count,
        ], HTTP_RESPONSE_OK);
    } // public function get_nominated_photos()


    public function upload_photo(UploadPhotoRequest $request)
    {
        $photoImageUploadedFile = $request->file('image');
        \Log::info(  varDump($photoImageUploadedFile, ' -1 $photoImageUploadedFile::') );

        $tags        = $request['tags'] ?? '';
        $loggedUser  = auth()->user();

        if ( !empty($photoImageUploadedFile) ) {
            $photo_file_path = $photoImageUploadedFile->getPathName();
        }

        $newPhoto                    = new Photo();
        $newPhoto->owner_id          = $loggedUser->id;
        $newPhoto->name              = '';
        $newPhoto->slug              = '';
        $newPhoto->active            = false;
        $newPhoto->shown_on_homepage = false;
        try {
            DB::beginTransaction();
            $newPhoto->save();
            \Log::info(varDump($newPhoto->id, ' -1 $newPhoto->id::'));
            if ( ! empty($newPhoto) and ! empty($photo_file_path)) {
                \Log::info(varDump($photo_file_path, ' -1 INSIDE $photo_file_path::'));
                $newPhoto->addMedia($photo_file_path)->toMediaCollection('photo');
            }

            $tagsList = pregSplit('/,/', $tags);
            foreach ($tagsList as $tag_id) {
                $photoTag           = new PhotoTag();
                $photoTag->photo_id = $newPhoto->id;
                $photoTag->tag_id   = $tag_id;
                $photoTag->save();

            }
            DB::commit();

            return response()->json(['message' => 'Photo uploaded successfully'], HTTP_RESPONSE_OK);
        } catch (QueryException $e) {
            \Log::info('-15 ProfilePhotoController upload_photo $e->getMessage() ::' . print_r($e->getMessage(), true));
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()],
                HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function upload_photo(Request $request)

     public function get_free_photos_upload_for_week(Request $request){
         $loggedUser = auth()->user();
         $now = Carbon::now(config('app.timezone'));
         $week_ago = $now->subDays(7);
//         \Log::info(  varDump($week_ago, ' -1 $week_ago::') );
//         \Log::info(  varDump($week_ago->format('Y-m-d H:i:s'), ' -12 $week_ago::') );
         $uploaded_this_week = Photo
             ::getByOwnerId($loggedUser->id)
             ->getByCreatedAt($week_ago->format('Y-m-d H:i:s'), '>')
             ->count();

//         \Log::info(  varDump($uploaded_this_week, ' -1 $uploaded_this_week::') );
         $user_allowed_to_upload_photos_this_week = (int)(config('app.user_allowed_to_upload_photos_this_week', 5));
         return response()->json(
             ['max_photos_to_upload_this_week' => $user_allowed_to_upload_photos_this_week - $uploaded_this_week], HTTP_RESPONSE_OK);
     }


}

