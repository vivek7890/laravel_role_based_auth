<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use GoogleMaps;
use Mapper;

class IndexController extends Controller
{
  public function index()
  {
      // trying to locate origin
      $origin = json_decode(
          GoogleMaps::load('placeautocomplete')
              ->setParam(['input' =>'bangalore'])
              ->get()
      );

      // trying to locate destination
      $destination = json_decode(
          GoogleMaps::load('placeautocomplete')
              ->setParam(['input' =>'hyderabad'])
              ->get()
      );

      // trying to gecode origin
      $place = json_decode(
          GoogleMaps::load('geocoding')
          ->setParamByKey('place_id', $origin->predictions[0]->place_id)
          ->get()
      );

      Mapper::map($place->results[0]->geometry->location->lat, $place->results[0]->geometry->location->lng, ['eventBeforeLoad' => 'addRoute(map_0);']);

      // trying to calculate route
      $route = GoogleMaps::load('directions')
          ->setParam([
              'origin' => $origin->predictions[0]->description,
              'destination' => $destination->predictions[0]->description,
              'travelmode' => 'DRIVING'
          ])
          ->get();

      return view('map')
          ->with('origin', $origin->predictions[0]->description)
          ->with('destination', $destination->predictions[0]->description)
          ->with('route', $route);
  }
}
