<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php 
	include('comman/connection.php');
	include('comman/db_functions.php');
	//include('comman/functions.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Location a Travel Category Flat Bootstarp Responsive Website Template | contact :: w3layouts</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Location Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.easydropdown.js"></script>
<!-- Mega Menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!-- Mega Menu -->
<style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 500px;  /* The height is 400 pixels */
        width: 700px; 
        float: left; /* The width is the width of the web page */
       }w

      #details{
       	height:500px;
       	width: 380px;
       	float: left;
       	 background-image: linear-gradient(to right, rgba(255,0,0,0), rgb(77, 77, 255));
       	opacity: 0.8;
       	margin-left: 50px;
       }

      
    </style>
</head>
<body>
<!-- banner -->
	<div class="header">
		<div class="container">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" class="img-responsive" alt=""></a>
			</div>
			
				<div class="clearfix"></div>
		</div>
	</div>
	<div class="header-bottom">
		<div class="container">
			<div class="top-nav">
				<span class="menu"> </span>
					<ul class="navig megamenu skyblue">
						<li><a href="location.html" class="scroll"><span> </span>Search Bus route</a></li>

						<li><a href="buslocation.html" class="scroll"><span> </span> Track a Bus</a></li>

						<div class="clearfix"></div>
					</ul>
					<script>
					$("span.menu").click(function(){
						$(".top-nav ul").slideToggle(300, function(){
						});
					});
				</script>
			</div>
			<div class="head-right">
				<ul class="number">
					
					<li><a href="Registation/ragistaion.html"><i class="phone"> </i>Sign Up</a></li>
					<li><a href="signup.html"><i class="phone"> </i>Sign In</a></li>
					<li><a href="contact.html"><i class="mail"> </i>Contact</a></li>	
						<div class="clearfix"> </div>						
				</ul>
			</div>
			<div class="clearfix"> </div>	
		</div>
	</div>
<!-- contact -->
	<div class="container">
	<div class="contact-content">
		<div id="map"></div>
    <script>
    	<?php
    		$bus = get_BusDetails($_GET['regno']);
    		$LocStart = -1;
    		$LocEnd = -1;
    		if(isset($_GET['start']))
    			$LocStart = $_GET['start'];
    		if(isset($_GET['end']))
    			$LocEnd = $_GET['end'];
    		echo 'var regno = "'.$_GET['regno'].'";';
    	?>
    	var uluru;
      	var map; 
      	var marker;
    	var x = 0;
		var xmlhttp = new XMLHttpRequest();
		// Initialize and add the map
		function initMap() {
		  // The location of Uluru
		  <?php
		   echo 'uluru = {lat:'.($bus->location->latitude).', lng:'.($bus->location->longitude).'}';
		  ?>
		  //Initialize Services
		  var directionsService = new google.maps.DirectionsService;
          var directionsRenderer = new google.maps.DirectionsRenderer;
		  // The map, centered at Uluru
		  map = new google.maps.Map(
		      document.getElementById('map'), {zoom: 10, center: uluru});
		  directionsRenderer.setMap(map);
		  // The marker, positioned at Uluru
		  marker = new google.maps.Marker({ 
		  	position: uluru, 
		  	map: map});
		  /* Show Direction */
		  
          calculateAndDisplayRoute(directionsService, directionsRenderer);
		  /**/
		  sendRequest();
		}
		function calculateAndDisplayRoute(directionsService, directionsRenderer) {
	        var waypts = [
        <?php
        	$Route = get_Route($bus->route_id,$LocStart,$LocEnd);
  			$pointsCount = count($Route->waypoints);
          	for($i = 0; $i < $pointsCount; $i++){
            echo '{ location: "'.$Route->waypoints[$i]->latitude.','.$Route->waypoints[$i]->longitude.'", stopover: false}';
            if($i + 1 < $pointsCount)
              echo ',';
          }
        ?>
            ];
	        

	        directionsService.route({
          origin: <?php echo '"'.$Route->origin->latitude.','.$Route->origin->longitude.'"'; ?>,
          destination: <?php echo '"'.$Route->destination->latitude.','.$Route->destination->longitude.'"'; ?>,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsRenderer.setDirections(response);
            var route = response.routes[0];
            // var summaryPanel = document.getElementById('directions-panel');
            //summaryPanel.innerHTML = '';
            // For each route, display summary information.
            // for (var i = 0; i < route.legs.length; i++) {
            //   var routeSegment = i + 1;
            //   summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
            //       '</b><br>';
            //   summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
            //   summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
            //   summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            // }
          }
          else if (status === "REQUEST_DENIED") {
              window.alert("Request denied: " + response.statusMessage);
          } 
          else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      	}
    	
		xmlhttp.onreadystatechange = function() {
		  if (this.readyState == 4 && this.status == 200) {
		  	//alert(this.responseText);
		    myObj = JSON.parse(this.responseText);
		    uluru.lat = Number(myObj.latitude);
		    uluru.lng = Number(myObj.longitude);
		    marker.setPosition(uluru);
		    document.getElementById("speed").value = myObj.speed;
		    document.getElementById("last_updated").value = myObj.last_updated;
		    if(document.getElementById("chk_follow").checked)
		    	map.setCenter(uluru);
		    setTimeout(function(){ sendRequest(); }, 1000);
		  }	
		};
		function sendRequest(){ 
			 xmlhttp.open("GET", "comman/getlocation.php?regno="+regno, true);
			 xmlhttp.send();
		}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLLTh4BjjRbNHN9-rTyJlBIjRt1R4CQoQ&callback=initMap">
    </script> 

    <div id="details">
    	<h2 align="center">Bus Details</h2>
    	<br>

    	  <table  align="center" cellpadding="5" cellspacing="5">
    	  	<tr>
    	  		<td><input type="checkbox" id="chk_follow" checked> Follow</td>
    	  		<td></td>
    	  	</tr>
    		<tr>
    			<td>Registration No&nbsp;&nbsp;&nbsp;&nbsp;</td>
    			<td><input type="text" value=<?php echo '"'.$_GET['regno'].'"' ?>;  readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Name</td>
    			<td><input type="text" value=<?php echo '"'.$bus->name.'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Route No</td>
    			<td><input type="text" value=<?php echo '"'.$bus->route_no.'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Route</td>
    			<td><input type="text" value=<?php echo '"'.$bus->route.'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Category</td>
    			<td><input type="text" value=<?php echo '"'.getCategory($bus->category).'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Experss or No</td>
    			<td><input type="text" value=<?php echo '"'.getExpress($bus->express).'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Speed</td>
    			<td><input type="text" id="speed" value=<?php echo '"'.$bus->speed.'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Last Updated</td>
    			<td><input type="text" id="last_updated" value=<?php echo '"'.$bus->last_updated.'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>
    		<tr>
    			<td>Contact</td>
    			<td><input type="text" value=<?php echo '"'.$bus->contact.'"' ?>; readonly></td>
    		</tr>
    		<tr><td>&nbsp;</td>&nbsp;<td> </td></tr>	

    	</table>
    </div>   
		 
	 </div>
	 </div>
<br><br>
	<!-- contact -->
<div class="footer">
		<div class="container">
			<div class="col-md-2 abo-foo1">
				<h5>About Us</h5>
					<ul>
						<li><a href="about.html">About us</a></li>
						<li><a href="#">Who started it</a></li>
						<li><a href="#">how to help</a></li>
					</ul>
			</div>
			<div class="col-md-3 abo-foo">
				<h5>Account Information</h5>
					<ul>
						<li><a href="login.html">How to login</a></li>
						<li><a href="register.html">Create an account</a></li>
						<li><a href="login.html">Logout</a></li>
						<li><a href="register.html">Join us</a></li>
					</ul>
			</div>
			<div class="col-md-2 abo-foo1">
				<h5>Location</h5>
				<p>123, street name</p>
				<p>	landmark,</p>
				<p>	California 123</p>
				<p>	Tel: 123-456-7890</p>
				<p>	Fax. +123-456-7890</p>
			</div>
			<div class="col-md-2 abo-foo1">
			<h5>Agreements</h5>
			<ul>
				<li><a href="#">Legal agreement</a></li>
				<li><a href="#">Model release (adult)</a></li>
				<li><a href="#">Model release (Minor)</a></li>
				<li><a href="#">Property Release</a></li>
			</ul>
		</div>
			<div class="col-md-3 abo-foo">
				<li a="" href="#">
					<div class="drop-down1">
						<select class="d-arrow">
							<option value="Eng">Our Network</option>
								<option value="Fren">versions</option>
								<option value="Russ">variations</option>
								<option value="Chin">Internet</option>
						</select>
					</div>
				</li>
			</div>
				<div class="clearfix"></div>
			<div class="footer-bottom">
				<p>Copyrights © 2020 Location All rights reserved | Template by <a href="http://w3layouts.com/">&nbsp; CodeMart Lanka</a></p>
			</div>
		</div>
	</div>
</body>
</html>