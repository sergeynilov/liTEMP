<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Config;
use Auth;
use Carbon\Carbon;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

use App\Mail\UserRegistered;

class RegisterController extends Controller
{

    public function auth_register(Request $request)
    {
        try {
            $requestData = $request->all();

            DB::beginTransaction();
            $confirmation_code = Str::random(8);
            $newUser              = app(CreateNewUser::class)->create([
                'name'              => Str::random(20),
                'email'             => $requestData['email'],
                'password'          => $requestData['password'],
                'status'            => 'C',
                'confirmation_code' => $confirmation_code,
            ], true, []);

//            \Log::info(  varDump($newUser, ' -1 $newUser::') );

            if (empty($newUser) or $newUser::class == 'Illuminate\Support\MessageBag') {
                DB::rollBack();
                foreach ($newUser->getMessages() as $next_field_name => $nextErrorMessage) {
                    if ( ! empty($nextErrorMessage[0])) {
                        return response()->json([
                            'message'    => 'such_user_already_exists',
                        ], HTTP_RESPONSE_UNPROCESSABLE_ENTITY);
                    }
                }
                return;
            }
            DB::commit();

            $site_mame = config('app.name');
            \Mail::to($requestData['email'])->send(new UserRegistered(
                $site_mame,
                $newUser,
                $confirmation_code));

            return response()->json([
                'loggedUser' => $newUser,
                'confirmation_code' => $confirmation_code,
                'message'    => 'Вы успешно зарегистрировались. Проверьте почту с кодом подтверждения.',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function auth_register(Request $request)

    public function auth_confirm_code(Request $request)
    {
        try {
            $requestData = $request->all();
            $email             = $requestData['email'] ?? '';
            $confirmation_code = $requestData['confirmation_code'] ?? '';

            $user = User::getByEmail($email)->first();
//            \Log::info(  varDump($user, ' -1 $user::') );
            if ( ! $user) {
                return response()->json(['message' => 'User not found '], HTTP_RESPONSE_BAD_REQUEST);
            }
//            \Log::info(  varDump($confirmation_code, ' -2 $confirmation_code::') );
            if ($user->confirmation_code != $confirmation_code) {
//                \Log::info(  varDump(-3, ' -3 $::') );
                return response()->json(['message' => 'Invalid confirmation code'], HTTP_RESPONSE_BAD_REQUEST);
            }


            return response()->json([
                'user'                 => $user,
                'citiesSelectionArray' => City::getCitiesSelectionArray(true),
                'message'              => 'Вы успешно ввели код подтверждения. Завершите свою регистрацию !',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function auth_confirm_code(Request $request)

    public function auth_completion_registration(Request $request)
    {
        try {
            $requestData = $request->all();
//            \Log::info(  varDump($requestData, ' -1 auth_completion_registration $requestData::') );
            $email             = $requestData['email'] ?? '';

            $user = User::getByEmail($email)->first();
//            \Log::info(  varDump($user, ' -1 auth_completion_registration $user::') );
            if ( ! $user) {
                return response()->json(['message' => 'User not found '], HTTP_RESPONSE_BAD_REQUEST);
            }
            DB::beginTransaction();
            $user->name= $requestData['name'] ?? '';
            $user->status= 'A';
            $user->confirmation_code= '';
            $user->save();

            $userProfile= UserProfile
                ::getByUserId($user->id)
                ->first();
            if( empty($userProfile) ) {
                $userProfile = new UserProfile();
                $userProfile->user_id = $user->id;
            }
            $userProfile->hour_rate = $requestData['hour_rate'] ?? null;
            $userProfile->started_year = $requestData['started_year'] ?? null;
            $userProfile->website = $requestData['website'] ?? '';
            $userProfile->phone = $requestData['phone'] ?? '';
            $userProfile->city_id = $requestData['city_id'] ?? '';
            $userProfile->save();

            DB::commit();

            return response()->json([
                'user'    => $user,
                'message' => 'Вы успешно завершили свою регистрацию ! Может зайти в систему',
            ], HTTP_RESPONSE_OK);

        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function auth_completion_registration(Request $request)

    public function auth_restore_password(Request $request)
    {
        $email             = $requestData['email'] ?? '';
//        \Log::info(  varDump($email, ' -1 auth_restore_password $email::') );
        /*
        try {
            $requestData = $request->all();
                       $user = User::getByEmail($email)->first();
                        if ( ! $user) {
                            return response()->json(['message' => 'User not found '], HTTP_RESPONSE_BAD_REQUEST);
                        }
                        DB::beginTransaction();
                        $user->name= $requestData['name'] ?? '';
                        $user->status= 'A';
                        $user->confirmation_code= '';
                        $user->save();

                        $userProfile= UserProfile
                            ::getByUserId($user->id)
                            ->first();
                        if( empty($userProfile) ) {
                            $userProfile = new UserProfile();
                            $userProfile->user_id = $user->id;
                        }
                        $userProfile->hour_rate = $requestData['hour_rate'] ?? null;
                        $userProfile->started_year = $requestData['started_year'] ?? null;
                        $userProfile->website = $requestData['website'] ?? '';
                        $userProfile->city_id = $requestData['city_id'] ?? '';
                        $userProfile->save();

                        DB::commit();

                        return response()->json([
                            'user'    => $user,
                            'message' => 'Вы успешно завершили свою регистрацию ! Может зайти в систему',
                        ], HTTP_RESPONSE_OK);

                    } catch (QueryException $e) {
                        DB::rollBack();

                        return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
                    }*/
    } // public function auth_completion_registration(Request $request)

}
