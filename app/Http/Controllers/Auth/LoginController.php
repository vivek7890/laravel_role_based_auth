<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Facebook;
use App\Github;
use App\Google;
use App\Twitter;
use App\Role;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($service=null)
    {
        try{
          $userSocial = Socialite::driver($service)->user();
        }
        catch (\Exception $e) {
          die($e);
              //return redirect('/login')->with('status', 'Something went wrong or You have rejected the app!');
          }

        $findUser = User::where('email',$userSocial->email)->first();
        if ($findUser) {
          Auth::login($findUser);
          return redirect('/user/home');
        }
        else {
          $user = new User;
          $user->name = $userSocial->getName();
          $user->email = $userSocial->getEmail();
          $user->image = $userSocial->getAvatar();
          $user->password = bcrypt(123456);
          $user->save();
          $user
         ->roles()
         ->attach(Role::where('name', 'user')->first());
         $user_id=$userSocial->getId();
         $nick_name=$userSocial->getNickname();
         $user_name=$userSocial->getName();
         $user_email=$userSocial->getEmail();
         $user_avatar=$userSocial->getAvatar();
         $user_token=$userSocial->token;
         $refresh_token=$userSocial->refreshToken;
         $expires_in=$userSocial->expiresIn;
         $secret_token=$userSocial->tokenSecret?$userSocial->tokenSecret:'';
          if ($service=="google") {
            $google = new Google;
            $google->user_id = $user_id;
            $google->nick_name = $nick_name;
            $google->name = $user_name;
            $google->email = $user_email;
            $google->avatar = $user_avatar;
            $google->token = $user_token;
            $google->refresh_token = $refresh_token;
            $google->expires_in = $expires_in;
            $google->save();
          }
          if ($service=="facebook") {
            $facebook = new Facebook;
            $facebook->user_id = $user_id;
            $facebook->nick_name = $nick_name;
            $facebook->name = $user_name;
            $facebook->email = $user_email;
            $facebook->avatar = $user_avatar;
            $facebook->token = $user_token;
            $facebook->refresh_token = $refresh_token;
            $facebook->expires_in = $expires_in;
            $facebook->save();
          }
          if ($service=="twitter") {
            $twitter = new Twitter;
            $twitter->user_id = $user_id;
            $twitter->nick_name = $nick_name;
            $twitter->name = $user_name;
            $twitter->email = $user_email;
            $twitter->avatar = $user_avatar;
            $twitter->token = $user_token;
            $twitter->token_secret = $secret_token;
            $twitter->save();
          }
          if ($service=="github") {
            $github = new Github;
            $github->user_id = $user_id;
            $github->nick_name = $nick_name;
            $github->name = $user_name;
            $github->email = $user_email;
            $github->avatar = $user_avatar;
            $github->token = $user_token;
            $github->refresh_token = $refresh_token;
            $github->expires_in = $expires_in;
            $github->save();
          }
          Auth::login($user);
          return redirect('/user/home');
        }
    }
    public function authenticated(Request $request)
    {
        // Logic that determines where to send the user
        if($request->user()->hasRole('user')){
            return redirect('/user/home');
        }
        if($request->user()->hasRole('admin')){
            return redirect('/admin/home');
        }
    }
}
