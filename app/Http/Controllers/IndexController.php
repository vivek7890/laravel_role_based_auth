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

      Mapper::map($place->results[0]->geometry->location->lat, $place->results[0]->geometry->location->lng, ['draggable' => true,'eventBeforeLoad' => 'addMapEventListener(map_0);']);
      //Mapper::marker(53.381128999999990000, -1.470085000000040000, ['draggable' => true, 'eventDragEnd' => 'console.log(event.latLng.lat()); console.log(event.latLng.lng());']);
      //Mapper::informationWindow($place->results[0]->geometry->location->lat, $place->results[0]->geometry->location->lng,'<a href="https://www.google.co.uk/maps/dir/Current%20Location/' . $place->results[0]->geometry->location->lat . ',' . $place->results[0]->geometry->location->lat . '/?dirflg=w|location" title="Directions">Directions</a>');
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
