<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
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
    public function handleProviderCallback($service)
    {
        $userSocial = Socialite::driver($service)->user();
        $findUser = User::where('email',$userSocial->email)->first();
        if ($findUser) {
          Auth::login($findUser);
          return redirect('/home');
        }
        else {
          $user = new User;
          $user->name = $userSocial->name;
          $user->email = $userSocial->email;
          $user->password = bcrypt(123456);
          $user->save();
          $user
         ->roles()
         ->attach(Role::where('name', 'user')->first());
          Auth::login($user);
          return redirect('/home');
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
