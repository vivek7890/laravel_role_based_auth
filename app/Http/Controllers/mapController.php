<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class mapController extends Controller
{
    public function index()
    {
      $ip= \Request::ip();
      //$data = \Location::get($ip);
      //Mapper::map(0, 0, ['locate' => true]);
      //Mapper::map(12.9716,77.5946,['zoom' => 4, 'marker' => false, 'eventBeforeLoad' => 'addMapEventListener(map);']);
      //Mapper::map(12.9716, 77.5946, ['zoom' => 11, 'marker' => true, 'cluster' => false, 'center' => true, 'eventBeforeLoad' => 'addMapEventListener(map);']);
      //$location = Mapper::location('bangalore');
      //$location->map(['zoom' => '10', 'center' => true, 'marker' => true, 'overlay' => 'ROADMAP'])
    //->informationWindow($location->getLatitude(), $location->getLongitude(), '<a href="https://www.google.co.in/maps/dir/Current%20Location/' . $location->getLatitude() . ',' . $location->getLongitude() . '/?dirflg=w|location" title="Directions">Directions</a>');
      //Mapper::informationWindow(12.9716, 77.5946, 'Bangalore' );
      //Mapper::location('Sheffield')->map(['zoom' => 15, 'center' => false, 'marker' => false, 'type' => 'HYBRID', 'overlay' => 'TRAFFIC']);
      Mapper::location('bangalore')->map(['zoom' => 15, 'center' => false, 'marker' => true, 'type' => 'HYBRID', 'overlay' => 'TRAFFIC','eventBeforeLoad' => 'addMapEventListener(map);']);
      /*$lines = [
                  [
                      ['latitude' => 13.0827, 'longitude' => 80.2707],
                      ['latitude' => 17.3850, 'longitude' => 78.4867]
                  ],
                  [
                      ['latitude' => 17.6868, 'longitude' => 83.2185],
                      ['latitude' => 22.5726, 'longitude' => 88.3639]
                  ]
              ];
          Mapper::informationWindow(22.5726, 88.3639, 'Kolkata',['marker' => true] );
      foreach ($lines as $line) {
              Mapper::polyline($line);
      }*/
      return view('map');
    }
}
