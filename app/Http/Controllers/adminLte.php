<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminLte extends Controller
{
  public function adminLte()
  {
    return view('adminview');
  }
}
