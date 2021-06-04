<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use App\Notifications\UpdatepassNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\Updatepass;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;

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
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('updatePassword');

        $email=$user->email;
        $pass=$input['password'];
        $agent = new Agent();
        $platform=$agent->platform();
        $bowser=$agent->browser();
        $ip=\Request::ip();
        $details=[
            'title'=>'Password Update',
            'body'=> 'your password is updated',
            'pass'=> $pass,
            'pl'=>'your device is:',
            'platform'=>$platform,
            'br'=>'your browser is:',
            'browser'=>$bowser,
            'ip'=>'your Ip address is:',
            'ipadd'=>$ip
        ];

        Mail::to($email)->send(new Updatepass($details));

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
