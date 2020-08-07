<?php 
  $RegNo = $_GET['RegNo'];
  $Date = $_GET['Date'];
?>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Travel History</title>
    <style>
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
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {
        var myLatLng = {lat: 7.493056, lng: 80.744677};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: myLatLng
        });
        var marker;
<?php
		include('../comman/db_functions.php');
		$locations = getLocationHistoryPlaces($RegNo,$Date);
		$count = count($locations);
		for($i = 0; $i < $count; $i++){
	        echo 'marker = new google.maps.Marker({
	          position: {lat:'.$locations[$i]->latitude.' , lng: '.$locations[$i]->longitude.'},
	          map: map,
	          title: "'.$locations[$i]->time.'"
	        });';
    	}
?>
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLLTh4BjjRbNHN9-rTyJlBIjRt1R4CQoQ&callback=initMap">
    </script>
  </body>
</html>