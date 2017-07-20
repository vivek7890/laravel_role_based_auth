<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function redirectPath()
     {
         // Logic that determines where to send the user
         if (\Auth::user()->hasRole('admin')) {
             return redirect()->route('/admin/home');
         }

         return redirect()->route('/home');
     }
    public function index(Request $request)
    {
        if($request->user()->hasRole('user')){
          return view('home',['image' => $request->user()->image]);
        }

    }
    public function indexAdmin(Request $request)
    {
      if($request->user()->hasRole('admin')){
        return view('homeadmin',['image' => $request->user()->image]);
      }
    }
      /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');
        return view(‘some.view’);
      }
    */
}
