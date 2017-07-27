<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dynamic Map</title>
    <style media="screen">
            /* Always set the map height explicitly to define the size of the div
        * element that contains the map. */
        #map {
        height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        }
        .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #origin-input,
        #destination-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
        }

        #origin-input:focus,
        #destination-input:focus {
        border-color: #4d90fe;
        }

        #mode-selector {
        color: #fff;
        background-color: #4d90fe;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
        }

        #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
        }
    </style>
  </head>
  <body>
    <div id="map" style="height: 354px; width:713px;"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTNTDQNG28NJ4Bj578DF1quOGnSUyyLiM&libraries=places&callback=initMap"
            async defer></script>
    <script type="text/javascript">

      var directionsService ='';
      var _mapPoints = new Array();
      var directionsRenderer = '';

      function initMap() {

          //DirectionsRenderer() is a used to render the direction
          _directionsRenderer = new google.maps.DirectionsRenderer();
          directionsRenderer = new google.maps.DirectionsService();

          //Set the your own options for map.
          var myOptions = {
              zoom: 6,
              center: new google.maps.LatLng(21.7679, 78.8718),
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          //Define the map.
          var map = new google.maps.Map(document.getElementById("map"), myOptions);

          //Set the map for directionsRenderer
          _directionsRenderer.setMap(map);

          //Set different options for DirectionsRenderer mehtods.
          //draggable option will used to drag the route.
          _directionsRenderer.setOptions({
              draggable: true
          });

          //Add the doubel click event to map.
          google.maps.event.addListener(map, "dblclick", function (event) {
              //Check if Avg Speed value is enter.
              if ($("#txtAvgSpeed").val() == '') {
                  alert("Please enter the Average Speed (km/hr).");
                  $("#txtAvgSpeed").focus();
                  return false;
              }

              var _currentPoints = event.latLng;
              _mapPoints.push(_currentPoints);
              getRoutePointsAndWaypoints();
          });

          //Add an event to route direction. This will fire when the direction is changed.
          google.maps.event.addListener(_directionsRenderer, 'directions_changed', function () {
              computeTotalDistanceforRoute(_directionsRenderer.directions);
          });

        }

        function getRoutePointsAndWaypoints() {
            //Define a variable for waypoints.
            var _waypoints = new Array();

            if (_mapPoints.length > 2) //Waypoints will be come.
            {
                for (var j = 1; j < _mapPoints.length - 1; j++) {
                    var address = _mapPoints[j];
                    if (address !== "") {
                        _waypoints.push({
                            location: address,
                            stopover: true  //stopover is used to show marker on map for waypoints
                        });
                    }
                }
                //Call a drawRoute() function
                drawRoute(_mapPoints[0], _mapPoints[_mapPoints.length - 1], _waypoints);
            } else if (_mapPoints.length > 1) {
                //Call a drawRoute() function only for start and end locations
                drawRoute(_mapPoints[_mapPoints.length - 2], _mapPoints[_mapPoints.length - 1], _waypoints);
            } else {
                //Call a drawRoute() function only for one point as start and end locations.
                drawRoute(_mapPoints[_mapPoints.length - 1], _mapPoints[_mapPoints.length - 1], _waypoints);
            }
        }

        //drawRoute() will help actual draw the route on map.
      function drawRoute(originAddress, destinationAddress, _waypoints) {
          //Define a request variable for route .
          var _request = '';

          //This is for more then two locatins
          if (_waypoints.length > 0) {
              _request = {
                  origin: originAddress,
                  destination: destinationAddress,
                  waypoints: _waypoints, //an array of waypoints
                  optimizeWaypoints: true, //set to true if you want google to determine the shortest route or false to use the order specified.
                  travelMode: google.maps.DirectionsTravelMode.DRIVING
              };
          } else {
              //This is for one or two locations. Here noway point is used.
              _request = {
                  origin: originAddress,
                  destination: destinationAddress,
                  travelMode: google.maps.DirectionsTravelMode.DRIVING
              };
          }

          //This will take the request and draw the route and return response and status as output
          directionsService.route(_request, function (_response, _status) {
              if (_status == google.maps.DirectionsStatus.OK) {
                  _directionsRenderer.setDirections(_response);
              }
          });
      }
    </script>
  </body>
</html>
