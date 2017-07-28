<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Map Integration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    {!! Mapper::renderJavascript() !!}
  </head>
  <body>
        <div style="width: 100%;">
           <div id="panel" style="width: 30%; height: 400px;overflow:scroll; float: left;">
             <p>Total Distance: <span id="total"></span></p>
           </div>
           <div id="map" style="width: 30%; height: 400px; float: left;">{!!  Mapper::render() !!}</div>
           <button id="submit" class=".btn-success">Submit</button>

       </div>
    <script type="text/javascript">
            dynamicallyCreatedMarkers=[];
            function addMapEventListener(map)
            {
                google.maps.event.addListener(map, 'click', function (e) {
                  //console.log(e.latLng.lat());
                  //console.log(e.latLng.lng());
                    var marker = new google.maps.Marker({
                        position: e.latLng,
                        map: map,
                        draggable: true
                    });
                    map.panTo(e.latLng);
                    dynamicallyCreatedMarkers.push({
                        position: e.latLng,
                    });
                    //console.log(dynamicallyCreatedMarkers[0].position.lat());
                    addRoute(map);
                });
            }
            function addRoute(map) {

                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer({
                  draggable: true
                });
                directionsDisplay.setPanel(document.getElementById('panel'));
                directionsDisplay.setMap(map);
                directionsDisplay.addListener('directions_changed', function() {
                  computeTotalDistance(directionsDisplay.getDirections());
                });

                var request = {
                    origin: '{{ $origin }}',
                    destination: '{{ $destination }}',
                    waypoints: [{location: 'chennai, india'}, {location: 'tirupati'}],
                    provideRouteAlternatives: true,
                    unitSystem: google.maps.UnitSystem.IMPERIAL,
                    travelMode: 'DRIVING',
                    drivingOptions: {
                      departureTime: new Date("July 28, 2017 21:13:00"),
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
            $('#submit').click(function() {
                $.ajax({
                        type: "POST",
                        url: '/',
                        data: dynamicallyCreatedMarkers.serialize(),
                        success: function(response)
                        {
                             console.log('success')
                        }
                    });
             });
             function computeTotalDistance(result) {
                var total = 0;
                var myroute = result.routes[0];
                for (var i = 0; i < myroute.legs.length; i++) {
                  total += myroute.legs[i].distance.value;
                }
                total = total / 1000;
                document.getElementById('total').innerHTML = total + ' km';
              }
        </script>
  </body>
</html>
