<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
//        \Log::info(  varDump($input, ' -1 UpdateUserPassword $input::') );
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'new_password'   => 'required|min:8|max:15',
            'confirm_new_password' => 'required|min:8|max:15|same:' . 'new_password',
        ])->after(function ($validator) use ($user, $input) {

//            \Log::info(  varDump(-2, ' -2 UpdateUserPassword ::') );
//            \Log::info(  varDump(-21, ' -21 UpdateUserPassword $this->passwordRules() ::') );

            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
//                \Log::info(  varDump(-3, ' -3 UpdateUserPassword ::') );
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('updatePassword');

//        \Log::info(  varDump(-4, ' -4 UpdateUserPassword ::') );
        $user->forceFill([
            'password' => Hash::make($input['new_password']),
        ])->save();
    }
}
