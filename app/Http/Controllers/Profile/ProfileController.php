<?php

namespace App\Http\Controllers\Profile;

use App\Models\Post;
use App\Models\User;
use App\Models\Photo;
use App\Models\City;
use App\Models\UserProfile;
use App\Models\PhotoNomination;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Actions\Fortify\UpdateUserPassword;

use DB;
use App\Config;
use Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{

    public function index()
    {
        $loggedUser  = auth()->user();
        $userProfile = UserProfile
            ::getByUserId($loggedUser->id)
            ->with('city')
            ->first();

        $sort_by_field = 'photo_nominations_count';
        $sort_ordering = 'desc';

        $max_most_nominated_photos = 4;
        $mostNominatedPhotos       = PhotoNomination
            ::getByOwnerId($loggedUser->id)
            ->select('nomination_id', DB::raw('count(*) as photo_nominations_count'))
            ->limit($max_most_nominated_photos)
            ->with('nomination')
            ->orderBy($sort_by_field, $sort_ordering)
            ->havingRaw('photo_nominations_count > 0')
            ->groupBy('nomination_id')
            ->get();

        return Inertia::render('profile/index', [
            'loggedUser'          => $loggedUser,
            'userProfile'         => $userProfile,
            'mostNominatedPhotos' => $mostNominatedPhotos,
        ]);
    }


    public function edit() // Route name('profile.edit.personal')
    {
        $citiesSelectionArray = City::getCitiesSelectionArray(true);

        $loggedUser  = auth()->user();
        $userProfile = UserProfile
            ::getByUserId($loggedUser->id)
            ->with('city')
            ->first();
        $city_title  = '';
        if ($userProfile->city->address) {
            $city_title = $userProfile->city->address;
        }

        return Inertia::render('profile/edit_personal', [
            'loggedUser'           => $loggedUser,
            'userProfile'          => $userProfile,
            'citiesSelectionArray' => $citiesSelectionArray,
            'city_title'           => $city_title,
        ]);

    } // public function edit() // Route name('profile.edit.personal')

    public function update(Request $request) // Route ->name('profile.update.personal')
    {
        $requestData            = $request->all();
        $loggedUser             = auth()->user();
        $loggedUser->name       = $requestData['name'];
        $loggedUser->updated_at = Carbon::now(config('app.timezone'));
        try {
            DB::beginTransaction();
            $loggedUser->save();

            $userProfile = UserProfile
                ::getByUserId($loggedUser->id)
                ->first();
            if (empty($userProfile)) {
                $userProfile          = new UserProfile();
                $userProfile->user_id = $loggedUser->id;
            }
            $userProfile->hour_rate = $requestData['hour_rate'];
            $userProfile->website   = $requestData['website'];
            $userProfile->city_id   = $requestData['city_id'];
            $userProfile->save();

            DB::commit();

            return response()->json([
                'loggedUser'  => $loggedUser,
                'userProfile' => $userProfile,
                'message'     => 'Настройки публичных данных профайла успешно сохранены !',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function update(Request $request) // Route ->name('profile.update.personal')


    public function edit_contacts() // Route name('profile.edit.contacts')
    {
        $loggedUser  = auth()->user();
        $userProfile = UserProfile
            ::getByUserId($loggedUser->id)
            ->first();

        return Inertia::render('profile/edit_contacts', [
            'loggedUser'  => $loggedUser,
            'userProfile' => $userProfile
        ]);

    } // public function edit() // Route name('profile.edit.contacts')

    public function update_contacts(Request $request) // Route ->name('profile.update.contacts')
    {
        $requestData = $request->all();
        $loggedUser  = auth()->user();
        try {
            DB::beginTransaction();

            $userProfile = UserProfile
                ::getByUserId($loggedUser->id)
                ->first();
            if (empty($userProfile)) {
                $userProfile          = new UserProfile();
                $userProfile->user_id = $loggedUser->id;
            }
            $userProfile->phone              = $requestData['phone'];
            $userProfile->instagram          = $requestData['instagram'];
            $userProfile->facebook           = $requestData['facebook'];
            $userProfile->twitter            = $requestData['twitter'];
            $userProfile->px500              = $requestData['px500'];
            $userProfile->linkendin          = $requestData['linkendin'];
            $userProfile->unslplash          = $requestData['unslplash'];
            $userProfile->telegram           = $requestData['telegram'];
            $userProfile->facebook_messenger = $requestData['facebook_messenger'];
            $userProfile->viber              = $requestData['viber'];
            $userProfile->vk                 = $requestData['vk'];
            $userProfile->whatsapp           = $requestData['whatsapp'];
            $userProfile->save();

            DB::commit();

            return response()->json([
                'loggedUser'  => $loggedUser,
                'userProfile' => $userProfile,
                'message'     => 'Настройки контактов профайла успешно сохранены !',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function update_contacts(Request $request) // Route ->name('profile.update.contacts')


    public function edit_password() // Route name('profile.edit.password')
    {
        $loggedUser = auth()->user();

        return Inertia::render('profile/edit_password', [
            'loggedUser' => $loggedUser
        ]);

    } // public function edit() // Route name('profile.edit.password')

    public function update_password(Request $request) // Route ->name('profile.update.password')
    {
        $requestData = $request->all();

        $loggedUser = auth()->user();
        try {
            DB::beginTransaction();
            app(UpdateUserPassword::class)->update($loggedUser, [
                'current_password'     => $requestData['current_password'],
                'new_password'         => $requestData['new_password'],
                'confirm_new_password' => $requestData['confirm_new_password'],
            ]);

            DB::commit();

            return response()->json([
                'loggedUser' => $loggedUser,
                'message'    => 'Личный пароль сохранен и отправлен!',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function update_password(Request $request) // Route ->name('profile.update.password')


    public function edit_mailing() // Route name('profile.edit.mailing')
    {
        $loggedUser  = auth()->user();
        $userProfile = UserProfile
            ::getByUserId($loggedUser->id)
            ->first();

        return Inertia::render('profile/edit_mailing', [
            'userProfile' => $userProfile
        ]);

    } // public function edit_mailing() // Route name('profile.edit.edit_mailing')

    public function update_mailing(Request $request) // Route ->name('profile.update.mailing')
    {
        $requestData = $request->all();
        $loggedUser  = auth()->user();
        try {
            DB::beginTransaction();

            $userProfile = UserProfile
                ::getByUserId($loggedUser->id)
                ->first();
            if (empty($userProfile)) {
                $userProfile          = new UserProfile();
                $userProfile->user_id = $loggedUser->id;
            }
            $userProfile->send_message_copy_from_administration            = $requestData['send_message_copy_from_administration'];
            $userProfile->notify_about_messages_from_other_users           = $requestData['notify_about_messages_from_other_users'];
            $userProfile->getting_nomination                               = $requestData['getting_nomination'];
            $userProfile->new_comments_below_photo                         = $requestData['new_comments_below_photo'];
            $userProfile->new_comments_on_thread_on_forum                  = $requestData['new_comments_on_thread_on_forum'];
            $userProfile->new_comments_on_tracked_topic_in_forum           = $requestData['new_comments_on_tracked_topic_in_forum'];
            $userProfile->new_photos_on_tracked_photographer_page          = $requestData['new_photos_on_tracked_photographer_page'];
            $userProfile->selection_of_photos_from_editorial_board_in_week = $requestData['selection_of_photos_from_editorial_board_in_week'];
            $userProfile->receive_emails_about_new_events_and_offers       = $requestData['receive_emails_about_new_events_and_offers'];
            $userProfile->notify_me_of_new_messages_by_email               = $requestData['notify_me_of_new_messages_by_email'];
            $userProfile->save();

            DB::commit();

            return response()->json([
                'userProfile' => $userProfile,
                'message'     => 'Настройки уведомлений профайла успешно сохранены !',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function update_mailing(Request $request) // Route ->name('profile.update.mailing')


    public function update_avatar(Request $request)
    {

        $avatarImageUploadedFile = $request->file('image');
//             \Log::info( '-1 ProfileController update_avatar $request ::' . print_r(  json_encode($request), true  ) );
//             \Log::info( '-1 ProfileController update_avatar avatarImageUploadedFile ::' . print_r(  json_encode($avatarImageUploadedFile), true  ) );

        $avatar_image = $request['image_filename'] ?? '';
        $loggedUser   = auth()->user();
        try {
            DB::beginTransaction();
            if ( ! empty($avatarImageUploadedFile) and ! empty($avatar_image)) {
                $avatar_file_path = $avatarImageUploadedFile->getPathName();
//                     \Log::info( '-1 ProfileController update_avatar avatar_file_path ::' . print_r(  json_encode($avatar_file_path), true  ) );
//                     \Log::info( '-1 ProfileController update_avatar $loggedUser->avatar ::' . print_r(  json_encode($loggedUser->avatar), true  ) );
            }
            foreach ($loggedUser->getMedia('avatar') as $avatarMediaImage) {
//                     \Log::info( '-15 ProfileController update_avatar avatarMediaImage ::' . print_r(  json_encode($avatarMediaImage), true  ) );
                $avatarMediaImage->delete();
            }

            $ret = $loggedUser->addMedia($avatar_file_path)->toMediaCollection('avatar');
//                 \Log::info( '-18 ProfileController update_avatar ret ::' . print_r(  json_encode($ret), true  ) );

            DB::commit();
//                 \Log::info( '-1 ProfileController update_avatar COMMITTED ::'  );

            $uploaded_media_image_url = $ret->original_url;
            $uploaded_file_name       = $ret->file_name;

            return response()->json([
                'loggedUser'               => $loggedUser,
                'uploaded_media_image_url' => $uploaded_media_image_url,
                'uploaded_file_name'       => $uploaded_file_name,
                'message'                  => 'Настройки уведомлений профайла успешно сохранены !',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function update_avatar(Request $request)


    public function delete_avatar(Request $request)
    {
        $loggedUser = auth()->user();
        try {
            DB::beginTransaction();
            foreach ($loggedUser->getMedia('avatar') as $avatarMediaImage) {
                $avatarMediaImage->delete();
            }

            DB::commit();

            return response()->json([
                'loggedUser' => $loggedUser,
                'message'    => 'Настройки уведомлений профайла успешно сохранены !',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function delete_avatar(Request $request)


}

