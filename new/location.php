<?php include('../comman/connection.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Location</title>
	<style>
/*
	 #map {
        height: 50%;
        position: fixed;
        overflow: visible;
      }*/

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
/* Style the header */
.header {
  background-color: #f1f1f1;
  padding: 5px;
 /* text-align: center;*/
}

.column {
  float: left;
  padding: 10px;
}
.column.side {
  width: 30%;
  height: 90%;
}
/* Middle column */
.column.middle {
  width: 65%;
  height: 90%;
}

.row:after{
	 content: "";
 	 display: table;
  	clear: both;
  	height: 90%;
}
</style>
</head>
<body>
	 
 
	<?php 
		include('index.php');
		include ('search-form.php');
		include ('backend-search.php');

		$loc = new stdClass();
		$loc->name = "";
		$loc->type = 0;
		$loc->latitude = "";
		$loc->longitude = "";
		$loc->id = 0;
		$types = array('Town','Bus Stand','Bus Halt','Village','Place');
		$n = count($types);
		if(isset($_GET['id'])){
			include('../comman/db_functions.php');
			$loc = get_LocationDetails($_GET['id']);
		}
	?>

	<div class="row">
		
		 <div class="column side">
	  
				<a href="view_locations.php">View All Locations</a><br>
				<form action="submit.php" method="get">

		<table>
			<tr>
				<td><span>Type : </span></td>
				<td><input type="text" name="Type" value="Location" readonly></td>
			</tr>

			<tr>
				<td><span>Location ID : </span></td>
				<td><input type="text" name = "id" value=<?php echo '"'.$loc->id.'"'; ?> readonly ></td>
			</tr>

			<tr>
				<td><span>Name : </span></td>
				<td><input type="text" name="Name" value=<?php echo '"'.$loc->name.'"'; ?>></td>
			</tr>

			<tr>
				<td><span>Location Type : </span></td>
				<td>
					<select id="country" name="LocationType">


		<?php
			for($i = 0; $i < $n ; $i++){
				echo '<option value="'.$i.'" '.($i == $loc->type ? "selected" : "").'>'.$types[$i].'</option>';
			}
		?>
					</select>
					</td>
			</tr>

			<tr>
				<td><span>Latitude : </span></td>
				<td><input type="text" name = "Latitude"  id="Latitude"></td>
			</tr>

			<tr>
				<td><span>Longitude  </span></td>
				<td><input type="text" name = "Longitude" id="Longitude"></td>
				<!-- <td><input type="text" name = "Longitude" value=<?php// echo '"'.$loc->longitude.'"'; ?>></td> -->
			</tr>
			<tr><td></td><td></td></tr>

			
			</table>	
	    	</form>
        </div>

	 	 <div class="column middle"> 
	 	 	<div>
			       

			        <input id="seach_location" class="controls" type="text"
			            placeholder="Enter a Location " >
			          <button id="btn_search">click</button>

			</div>

	 	 	<div id="map" style="width: 800px; height: 320px;"></div> 


	 	 </div>

	</div>

</script>
<script type="text/javascript">

    
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>


			<br>

		<input type="submit" name="">
		<a href="location.php">Reset</a>

		<!-- <div id="Latitude"></div>
		<div id="Longitude"></div> -->
	</form>
		
	<div>
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th>Location Type</th>
			</tr>
<?php
	$sql1 = "SELECT * FROM location  order by ID DESC";
    $result = mysqli_query($conn,$sql1);
    
    while($row=mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo '<td><a href="location.php?id='.$row['ID'].'">'.$row['ID']."</a></td>";
		echo "<td>".$row['Name']."</td>";
		echo "<td>".$row['Latitude']."</td>";
		echo "<td>".$row['Longitude']."</td>";
		echo "<td>".$row['Type']."</td>";
		echo "<tr>";
	}
?>
		</table>
	</div>

  <script>
      function initMap() 
      {
	        var myLatlng = {lat:7.351613, lng: 80.950205};
	          var map = new google.maps.Map(
	            document.getElementById('map'), {zoom: 8, center: myLatlng});

	        var marker=new google.maps.Marker({
	          position:myLatlng,
	          map:map,
	          draggable: true,
	          animation: google.maps.Animation.BOUNCE,
	          title:'CodeMart Lanka ..'
	        });

	        google.maps.event.addListener(map, 'click', function (event) {
	          PlaceMaker(event.latLng);      
	       }); 




	       
        function PlaceMaker(location)
        {
            var marker=new google.maps.Marker({
              position:location,
              map:map,
               // animation: google.maps.Animation.BOUNCE,
            });
              var lat=marker.getPosition().lat();
              var lng=marker.getPosition().lng();

              setLatLng(lat,lng);
            
        }

        function setLatLng(lat,lng)
        {
          document.getElementById("Latitude").value= lat;
          document.getElementById("Longitude").value=lng;

        }
        marker.setMap(map);
    
           
	 }













	        // document.getElementById('btn_search').addListener('click',function()
	        // {




					    //  var input = document.getElementById('seach_location');
				     //    var searchBox = new google.maps.places.SearchBox(input);
				     //    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

				     //    // Bias the SearchBox results towards current map's viewport.
				     //    map.addListener('bounds_changed', function() {
				     //      searchBox.setBounds(map.getBounds());
				     //    });

				     //    var markers = [];
				     //    // Listen for the event fired when the user selects a prediction and retrieve
				     //    // more details for that place.
				     //    searchBox.addListener('places_changed', function() {
				     //      var places = searchBox.getPlaces();

				     //      if (places.length == 0) {
				     //        return;
				     //      }

				     //      // Clear out the old markers.
				     //      markers.forEach(function(marker) {
				     //        marker.setMap(null);
				     //      });
				     //      markers = [];

				     //      // For each place, get the icon, name and location.
				     //      var bounds = new google.maps.LatLngBounds();
				     //      places.forEach(function(place) {
				     //        if (!place.geometry) {
				     //          console.log("Returned place contains no geometry");
				     //          return;
				     //        }
				     //        var icon = {
				     //          url: place.icon,
				     //          size: new google.maps.Size(71, 71),
				     //          origin: new google.maps.Point(0, 0),
				     //          anchor: new google.maps.Point(17, 34),
				     //          scaledSize: new google.maps.Size(25, 25)
				     //        };

				     //        // Create a marker for each place.
				     //        markers.push(new google.maps.Marker({
				     //          map: map,
				     //          icon: icon,
				     //          title: place.name,
				     //          position: place.geometry.location
				     //        }));

				     //        if (place.geometry.viewport) {
				     //          // Only geocodes have viewport.
				     //          bounds.union(place.geometry.viewport);
				     //        } else {
				     //          bounds.extend(place.geometry.location);
				     //        }
				     //      });
				     //      map.fitBounds(bounds);
				     //    });




	        // });







    </script>


	 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLLTh4BjjRbNHN9-rTyJlBIjRt1R4CQoQ &callback=initMap">
    </script>
</body>
</html>