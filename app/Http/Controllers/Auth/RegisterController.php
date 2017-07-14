<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $filename='null';
        if (Input::file('userimg')->isValid()) {
          $destinationPath = public_path('uploads/files');
          $extension = Input::file('userimg')->getClientOriginalExtension();
          $filename = uniqid().'.'.$extension;
          Input::file('userimg')->move($destinationPath, $filename);

      }

        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'image' => $filename,
            'password' => bcrypt($data['password']),
        ]);
        $user
       ->roles()
       ->attach(Role::where('name', 'user')->first());

        return $user;
    }
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return Redirect::route('login');
    }
}
