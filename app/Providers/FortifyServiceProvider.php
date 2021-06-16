<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Mail\Qrsend;

use Session;
use App\Models\User;
use App\Models\UserIp;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        
        RateLimiter::for('login', function (Request $request) {
            //echo $user=User::where('email',$email)->first();
            //dd($request->user());
            //echo $request->user()->twoFactorQrCodeSvg();
            //exit();
            //49.34.10.250
            $ip = file_get_contents('https://api.ipify.org');
            $user = User::where('email', $request->email)->first();
            $user_id = $user->id;
            $user_role = $user->role;
            if ($user &&
                Hash::check($request->password, $user->password)) {
                if($user_role == 1){
                    return Limit::perMinute(5)->by($request->email.$request->ip());
                }
                else{ 
                    if(!empty(UserIp::where('ipaddress',$ip)->where('user_id',$user_id)->first())){
                        return Limit::perMinute(5)->by($request->email.$request->ip());
                    }
                    else{
                        Session::flash('message', "you are no able to login with this IpAddress");
                        return Redirect::back();
                    }
                }
            } 
        });

        RateLimiter::for('two-factor', function (Request $request) {
            
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}