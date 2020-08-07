<?php include('../comman/connection.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
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
  padding: 5px;
}
.column.side {
  width: 40%;
  height: 90%;
}
/* Middle column */
.column.middle {
  width: 55%;
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
		include ('search-formStart_end.php');
		include ('search-start_end.php');
		$id = 0;
		$location = 0;
		$distance = "";
		$waypoint = 0;
		$Sub_Route_ID = "";

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			include('../connection.php');
			$stmt = $conn->prepare("SELECT * FROM sub_route_location WHERE ID='".$id."';");
	    	$stmt->execute();
			$result = $stmt->get_result();
			$row = mysqli_fetch_assoc($result); 
			$location = $row['Location_ID'];
			$distance = $row['Distance'];
			$waypoint = $row['Way_Point'];
			$Sub_Route_ID = $row['Sub_Route_ID'];
		}
	?>
	<br><br>

		<div class="row">

		<div class="column side" >
		<table>
		<form action="submit.php" method="get">

		
			<tr>
				<td><span> Type </span></td>
				<td><input type="text" name="Type" value="sub_route_location" readonly></td>
			</tr>

			<tr>
				<td><span> ID </span></td>
				<td><input type="text" name = "id" value=<?php echo '"'.$id.'"'; ?> readonly ></td>
			</tr>

			<tr>
				<td><span>Sub Route ID  </span></td>
				<td>
					<input type="text" name = "Sub_Route_ID" id="Sub_Route_ID" value=<?php echo '"'.$Sub_Route_ID.'"'; ?>>
					<input type="button" value="Set ID" id="getStartLoc">
				</td>
			</tr>

			<tr>
				<td><span>Location  </span></td>
				<td>


					<div class="search-box">
		      			    <input type="text"  autocomplete="off" placeholder="Start" id="start" readonly/>
		        			<div class="result"></div>
		  			</div>

		  			<div class="search-box">
		      			    <input type="text"  autocomplete="off" placeholder="End" id="End" name="Location" />
		        			<div class="result"></div>
		  			</div>

				</td>
			</tr>

			<tr>
				<td><span>Distance in KM s: </span></td>
				<td><input type="text" name = "Distance" id="Distance">
					<input type="button" value="Get Distance" id="get_distence"></td>
				
			</tr>

			<tr>
				<td><span>Set As a Way Point</span></td>
				<td>
					<select name="WayPoint">
			<?php
				$val = array('No','Yes');
				for($i = 0; $i < 2; $i++)
					echo '<option value="'.$i.'" '.($i == $waypoint ? "selected" : "").'>'.$val[$i].'</option>';
			?>
			</select>

				</td>
			</tr>
			

	</form>
	</table>	
	 </div>
	  <div class="column middle">
	  		 <div id="map" style="width: 800px; height: 320px;">
	  </div>
 	</div>  

<input type="submit" name="">
<a href="sub_route_location.php">Reset</a> <br>

	<div>
		<table>
			<tr>
				<th>ID</th>
				<th>Sub Route ID</th>
				<th>Location ID</th>
				<th>Location </th>
				<th>Distance</th>
				<th>Is A Way Point</th>
			</tr>
<?php
	$sql1 = "SELECT sub_route_location.ID,Sub_Route_ID,Location_ID,Distance,Name,Latitude,Longitude,Type,Way_Point FROM sub_route_location inner join location on Location_ID = location.ID order by sub_route_location.ID DESC";
    $result = mysqli_query($conn,$sql1);
    
    while($row=mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo '<td><a href="sub_route_location.php?id='.$row['ID'].'">'.$row['ID']."</a></td>";
		echo '<td><a href="test_sub_route.php?Sub_Route_ID='.$row['Sub_Route_ID'].'">'.$row['Sub_Route_ID']."</a></td>";
		echo "<td>".$row['Location_ID']."</td>";
		echo "<td>".$row['Name']."</td>";
		echo "<td>".$row['Distance']."</td>";
		echo "<td>".$row['Way_Point']."</td>";
		echo "<tr>";
	}
?>
		</table>
	</div>

	<script>
		var map;

			// $(document).ready(function(){
			// 	$("#getStartLoc").click(function(){
			// 		// $("#start").load("sample.txt");
			// 		$.get("../comman/getLocation_Start.php?subrouteid=3",function(data,status){
						
			// 			var id=JSON.parse(data);
			// 			document.getElementById('start').value=id.Name;
			// 			//alert("last location name  :"+id.Name);

			// 		});
			// 	});
			// });


		document.getElementById('getStartLoc').addEventListener('click',getStartLocation);
		 function getStartLocation()
		 {
			var xhr = new XMLHttpRequest(); //create a http request ogject
			var subrouteid=document.getElementById('Sub_Route_ID').value;

			xhr.open("GET" , "../comman/getLocation_Start.php?subrouteid="+subrouteid,true);
			xhr.send();
			  xhr.onreadystatechange = function() 
			  {
				    if (this.readyState == 4 && this.status == 200) 
				    {
						var data=JSON.parse(this.responseText);
						document.getElementById('start').value= data.Name;
				    }
			  };			
		}

		document.getElementById('get_distence').addEventListener('click',getDistence);
		function getDistence()
		{

			var Start=document.getElementById('start').value;
			var End=document.getElementById('End').value;

			var xhr=new XMLHttpRequest();
			xhr.open("GET","../comman/GetLat_Lng.php?Start="+Start+"&End="+End,true);
			xhr.send();

			xhr.onreadystatechange=function()
			{
				if(this.readyState==4 && this.status==200)
				{
					var data =JSON.parse(this.responseText);
					getDistenceOnmap(data.StartLat,data.StartLng,data.EndLat,data.EndLng);
				}
			}
		}


		function getDistenceOnmap(startlat,startLng,Endlat,EndLng)
		{

					
				var directionsService = new google.maps.DirectionsService();
				var directionsRenderer = new google.maps.DirectionsRenderer();
				directionsRenderer.setMap(map);

							
					        directionsService.route({	
					        	origin: startlat + "," + startLng,
					        	destination: Endlat + "," + EndLng,
					        	travelMode:'DRIVING'
					        },function(response,status){
					        	
					        	if(status=='OK'){
					        		directionsRenderer.setDirections(response);
					        		var route=response.routes[0];

					        		document.getElementById('Distance').value=route.legs[0].distance.text;
									
					        	}
								else if (status === "REQUEST_DENIED") 
								{
		              				window.alert("Request denied: " + response.statusMessage);
								}
					        	else
					        	{
					        		window.alert('ditections request failed dou to '+status);
					        	}
					        });	

			//get Direction -->https://developers.google.com/maps/documentation/javascript/examples/distance-matrix
		}

      function initMap() 
      {
		        var myLatlng = {lat:7.351613, lng: 80.950205};
		          map = new google.maps.Map(
		            document.getElementById('map'), {zoom: 8, center: myLatlng});

		        var marker=new google.maps.Marker({
		          position:myLatlng,
		          map:map,
		          draggable: true,
		          animation: google.maps.Animation.BOUNCE,
		          title:'CodeMart Lanka ..'
		        });

				
      }



	//   $(document).ready(function(){
	// 	  $("input").focus(function(){
	// 		  $(this).css("background-color", "yellow");
	// 	  });

	// 	  $("input").blur(function(){
   	// 		 $(this).css("background-color", "green");
 	// 	 });
	//   });


    </script>


	 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLLTh4BjjRbNHN9-rTyJlBIjRt1R4CQoQ &callback=initMap">
    </script>
</body>
</html>