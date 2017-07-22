<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class mapController extends Controller
{
    public function index()
    {
      $ip= \Request::ip();
      $data = \Location::get($ip);
      //Mapper::map(0, 0, ['locate' => true]);
      //return view('map');
    }
}
