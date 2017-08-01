<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messages;
use App\User;

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

         //return redirect()->route('/home');
     }
    public function index(Request $request)
    {
        if($request->user()->hasRole('user')){
          return view('home',['image' => $request->user()->image]);
        }

    }
    public function chatindex(Request $request)
    {
          $messages=Messages::all();
          $image=$request->user()->image;
          return view('chat.index',['messages'=>$messages,'image'=>$image]);

    }
    public function sendmessage(Request $request)
    {
          $message=new Messages();
          $message->from_name=$request->from_name;
          $message->from_email=$request->from_email;
          $message->message=$request->message;
          $message->save();
          return response()->json($message);

    }
    public function getmessage()
    {
          $message=Messages::all();
          return response()->json($message);

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
