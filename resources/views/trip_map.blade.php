<!DOCTYPE html>
<html>

  <head>
    <style>
        /* Styles go here */

    html, body, #map_canvas {
              height: 100% ;
              margin: 0;
              padding: 0;
          }

          #panel {
              position: absolute;
              top: 5px;
              left: 50%;
              margin-left: -180px;
              z-index: -5;
              background-color: #fff;
              padding: 5px;
              border: 1px solid #999;
          }

          /*
          Provide the following styles for both ID and class,
          where ID represents an actual existing "panel" with
          JS bound to its name, and the class is just non-map
          content that may already have a different ID with
          JS bound to its name.
          */

          #panel, .panel {
              font-family: 'Roboto','sans-serif';
              line-height: 30px;
              padding-left: 10px;
          }

              #panel select, #panel input, .panel select, .panel input {
                  font-size: 15px;
              }

              #panel select, .panel select {
                  width: 100%;
              }

              #panel i, .panel i {
                  font-size: 12px;
              }

               ul.messages_layout li.left {
                  padding-left: 7px !important;
              }

              .gmnoprint img {
                  max-width: none;
              }

              .LeftFloat {
                  float: left;
              }

              .RightFloat {
                  float: right;
              }

              .FieldContainer {
                  border: 1px solid black;
                  width: 400px;
                  height: 300px;
                  overflow-y: auto;
                  font-family: tahoma;
              }

              .OrderingField {
                  margin: 3px;
                  border: 1px dashed #0da3fd;
                  background-color: #e8efff;
                  height: 50px;
              }

                  .OrderingField div.Commands {
                      width: 60px;
                  }

              /*button {
              width: 60px;
          }*/

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTNTDQNG28NJ4Bj578DF1quOGnSUyyLiM&libraries=places,geometry"></script>
  </head>

  <body>
  <input id="maptype" type="hidden" value="roadmap" />
    <input type="button" onclick="calcRoute()" value="View on Google Map" />

    <br /><br />
    <label>Source</label>
    <input type="text" value="" name="source" id="source">
    <br /><br />
    <label>Destination</label>
    <input type="text" value="" name="destination" id="destination">
    <br /><br />
    <button onclick="GenerateSourceDestinationPoint()" class="btn btn-primary" type="button" >Add Points</button>
    <div style="border: 1px solid -moz-nativehyperlinktext;"></div>
    <div id="FieldContainer">
    </div>

    <br /><br />
    <input type="button" disabled="disabled" value="Save Trip" />
    <div style="height:400px;width:1000px">
        <div id="map_canvas">

        </div>
    </div>
    <script>
          // Code goes here

      //Source and destination auto complete textbox binding
      var marker = [];
      google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('source'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                sourceLat = place.geometry.location.lat();
                sourcelng = place.geometry.location.lng();
            });
            var places1 = new google.maps.places.Autocomplete(document.getElementById('destination'));
            google.maps.event.addListener(places1, 'place_changed', function () {
                var place1 = places1.getPlace();
            });
        });

      var cnt = 1; var v = [];var autocomplete = [];
       var map = null;var usedIds = [];
        var insertControls = [];
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
         var map;
        var sourceLat, sourcelng; var maxNumberOfTextboxAllowed = 5;
        var autocompleteOptions = {
            componentRestrictions: { country: "in" }
        };

      function setupAutocomplete(autocomplete, inputs, i,txtboxId) {
                insertControls.push(txtboxId)
            autocomplete.push(new google.maps.places.Autocomplete(inputs[i], autocompleteOptions));
            var idx = autocomplete.length - 1;
                google.maps.event.addListener(autocomplete[idx], 'place_changed', function () {
                    if (marker[idx] && marker[idx].setMap) {
                        marker[idx].setMap(null);
                        marker[idx] = null;
                    }
                    marker[idx] = new google.maps.Marker({
                        map: map,
                        icon: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=' + '|FF776B|000000'

                    });
                    marker[idx].setVisible(true);
                    var place = autocomplete[idx].getPlace();
                    if (!place.geometry) {
                        return;
                    }
                    marker[idx].setPosition(place.geometry.location);
                    marker[idx].setVisible(false);
                     var auto = document.getElementById(insertControls[idx]).value;
                     v.push(auto);
                     calcRoute();
                });
            }


      function initialize() {

            directionsDisplay = new google.maps.DirectionsRenderer();
            var mapCenter
              mapCenter = new google.maps.LatLng(sourceLat, sourcelng); //to center google map location on my source points.

            var mapOptions = {
                zoom: 10,
                center: mapCenter
            }
              map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

            directionsDisplay.setMap(map);
        }

        google.maps.event.addDomListener(window, 'load', initialize);


      //My method to dynamically generate textbox

      function GenerateSourceDestinationPoint() {
                if (cnt <= maxNumberOfTextboxAllowed) {
                    var id = findAvailableId();
                    var OrderingField = $("<div class='OrderingField' id='OrderingField" + id + "'/>");
                    var LeftFloat = $("<div class='LeftFloat' id='LeftFloat" + id + "'/>");
                    var RightFloatCommands = $("<div class='RightFloat Commands' id='RightFloat Commands" + id + "'/>");
                    var upButton = $("<button id='navigate' value='up'>Up</button>");
                    var downButton = $("<button id='navigate' value='down'>Down</button>");
                    var fName = $("<input type='text' class='fieldname' id='Txtopt" + id + "'  name='TxtoptNm" + id + "'/>");
                    var removeButton = $("<img class='remove' width='20' height='15' src='' />");
                    LeftFloat.append(fName);
                    LeftFloat.append(removeButton);
                    RightFloatCommands.append(upButton);
                    RightFloatCommands.append(downButton);
                    OrderingField.append(LeftFloat);
                    OrderingField.append(RightFloatCommands);
                    $("#FieldContainer").append(OrderingField);
                     var newInput = [];
                var newEl = document.getElementById('Txtopt' + id);
                var txtboxId = 'Txtopt' + id;
                newInput.push(newEl);
                setupAutocomplete(autocomplete, newInput, 0, txtboxId);
                    cnt = cnt + 1;
                }
                else
                    alert("Cant create more than 5 points")
            }

      //when generating new textbox i will use this function to find already removed textbox id.For eg if i have remove textbox 3 then i will assign Txtopt3 to this newly generated textbox.
      function findAvailableId() {
            var i = 1;
            while (usedIds[i]) i++;
            usedIds[i] = true;
            return i;
        }

        function removeId(idToRemove) {
            usedIds[idToRemove] = false;
        }
        //method to remove textbox from Dom
        $(document).on('click', "img.remove", function () {
                $(this).parent().parent().fadeOut(1000, function () {
                    if (cnt > maxNumberOfTextboxAllowed)
                        cnt = cnt - 2;
                    else if (cnt == 1)
                        cnt = 1;
                    else
                        cnt = cnt - 1;
                    var id = $(this).attr("id").substr(13);
                    DeleteMarkers(id)
                    removeId(id);
                    $(this).remove();

                });
            });

      //This function will be call when i will remove any route point from dynamic textbox and here i will remove that point from my v array and again i will re-draw my map from source and destination.
      function DeleteMarkers(id) {
            var removeMarker = id - 1;
            for (var i = 0; i < v.length; i++) {
                if (i == removeMarker) {
                    v.splice(i, 1);
                }
            }
            calcRoute();
        }

           function calcRoute() {
            var start = document.getElementById('source').value;
            var end = document.getElementById('destination').value;
            var waypts = [];
            var request = null;

            if (v.length != 0) {
                for (var i = 0; i < v.length; i++) {
                    waypts.push({
                        location: v[i],
                        stopover: true
                    });
                }
                request = {
                    origin: start,
                    destination: end,
                    optimizeWaypoints: true,
                    waypoints: waypts,
                    travelMode: google.maps.TravelMode.DRIVING
                };
            }
            else if(start!=='' && end!==''){
                request = {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.TravelMode.DRIVING
                };
            }
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    var route = response.routes[0];
                }
            });
        }

    </script>
  </body>

</html>
