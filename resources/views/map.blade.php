<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Map Integration</title>
    {!! Mapper::renderJavascript() !!}
  </head>
  <body>
        <div style="width: 100%;">

           <div id="map" style="width: 40%; height: 400px; float: left;">{!!  Mapper::render() !!}</div>
           <div id="panel" style="width: 59%; float: right;"></div>

       </div>
    <script type="text/javascript">

            function addMapEventListener(map)
            {
                google.maps.event.addListener(map, 'click', function (e) {
                    var marker = new google.maps.Marker({
                        position: e.latLng,
                        map: map,
                        draggable: true
                    });
                    map.panTo(e.latLng);
                });
            }
            function addRoute(map) {

                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();

                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('panel'));

                var request = {
                    origin: '{{ $origin }}',
                    destination: '{{ $destination }}',
                    waypoints: [
                      {
                        location: 'delhi',
                        stopover: false
                      },{
                        location: 'kolkata',
                        stopover: true
                      },
                      {
                        location: 'mumbai',
                        stopover: true
                      }
                    ],
                    provideRouteAlternatives: true,
                    unitSystem: google.maps.UnitSystem.IMPERIAL,
                    travelMode: 'DRIVING',
                    drivingOptions: {
                      departureTime: new Date("July 25, 2017 21:13:00"),
                      trafficModel: 'pessimistic'
                    }
                };

                {{--var route = {!! $route !!};--}}
                {{--route.request = request;--}}
                {{--directionsDisplay.setDirections(route);--}}

                directionsService.route(
                    request,
                    function(response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        }
                    }
                );
            }

        </script>
  </body>
</html>
