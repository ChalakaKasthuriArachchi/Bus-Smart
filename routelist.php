<!DOCTYPE HTML>
<?php  
	date_default_timezone_set("Asia/Colombo");
	include('comman/db_functions.php');
	include('comman/best_route_functions.php');

	// $keywords = preg_split("/[,]+/", $_GET['start']);

	// $lat1 = str_replace("(", "",$keywords[0]);
	// $lat2 = str_replace(")", "",$keywords[1]);
	// $locStart = get_NearestLocation($lat1,$lat2);

	// $keywords = preg_split("/[,]+/", $_GET['end']);
	// $lat3 = str_replace("(", "",$keywords[0]);
	// $lat4 = str_replace(")", "",$keywords[1]);
	// $locEnd = get_NearestLocation($lat3,$lat4);
	$locStart = get_LocationDetails($_GET['start']);
	$locEnd = get_LocationDetails($_GET['end']);
	$FRoutes = findBestRoute($locStart->id,$locEnd->id);
?>
<html>
<head>
<title>Rote List</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Location Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="./css/styletable.css">


<script src="js/jquery.min.js"></script>



<script src="js/jquery.easydropdown.js"></script>
<!-- Mega Menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!-- Mega Menu -->
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

<!-- registration -->


	<div class="main-1">
		<div class="container">
			<div class="register">
				<a href=""><h1 align="center">
					<?php
						echo $locStart->name." - ".$locEnd->name;
					?>
				</h1></a>
				
				<table class="responstable table">
  
 				 <tr>
  					<th>Get In</th>
    				<th>Route</th>
    				<th>Via</th>
    				<th>Distance</th>
    				<th></th>
  				</tr>
				<?php
					for($i = 0; $i < $FRoutes->n; $i++){
	   					$Route = get_RouteDetails($FRoutes->list[$i]->RouteID);
	   					echo '<tr>';
	   					echo '<td>'.get_LocationDetails($FRoutes->list[$i]->start)->name.'</td>';
	  		 			echo '<td>'.$Route->route_no." ".$Route->route_name.'</td>';
	   					echo "<td>$Route->via</td>";
	   					echo '<td><a id="d'.$i.'"></a></td>';
	   					echo '<td><a href="Busdetails.php?RouteID='.$FRoutes->list[$i]->RouteID.'&LocStart='.$FRoutes->list[$i]->start.'&LocEnd='.$FRoutes->list[$i]->end.'">Go</div></a></td>';
  	   echo '</tr>';
	}
?>
  
</table>
				
					
				
		   </div>
		 </div>
	</div>
<!-- registration -->
<!-- 404 -->
	<div class="location">
		<div class="container">
				
			<div class="locat-bottm">
				
			<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- 404 -->
	<div class="footer">
		<div class="container">
			<div class="col-md-3 abo-foo1">
				<h5>About Us</h5>
					<ul>
						<li><a href="about.html">About us</a></li>
						<li><a href="#">Who started it</a></li>
						<li><a href="#">how to help</a></li>
					</ul>
			</div>
			<div class="col-md-3 abo-foo1">
				<h5>Account Information</h5>
					<ul>
						<li><a href="login.html">How to login</a></li>
						<li><a href="register.html">Create an account</a></li>
						<li><a href="login.html">Logout</a></li>
						<li><a href="register.html">Join us</a></li>
					</ul>
			</div>
			<div class="col-md-3 abo-foo1">
				<h5>Contact</h5>
				<p>CodeMart Lanka </p>
				<p>	Matara,</p>
				<p>	SriLanka</p>
				<p>	Tel: 0765854515</p>
				<p>	Fax. 0765854515</p>
			</div>
			
			
				<div class="clearfix"></div>
			<div class="footer-bottom">
				<p>Copyrights © 2019  All rights reserved | Developed by <a href="">&nbsp; CodeMart Lanka</a></p>
			</div>
		</div>
	</div>
	<script>
		function initMap(){
			var directionsService = new google.maps.DirectionsService;
			<?php
				for($i = 0; $i < $FRoutes->n;$i++){
					$Route = get_Route($FRoutes->list[$i]->RouteID,$FRoutes->list[$i]->start,$FRoutes->list[$i]->end);
		  			$pointsCount = count($Route->waypoints);
					echo "var waypts = [";
		          	for($j = 0; $j < $pointsCount; $j++){
			            echo '{ location: "'.$Route->waypoints[$j]->latitude.','.$Route->waypoints[$j]->longitude.'", stopover: false}';
			            if($j + 1 < $pointsCount)
			              echo ',';
		          	}
		            echo "];";
		            echo 'directionsService.route({
		          origin:"'.$Route->origin->latitude.','.$Route->origin->longitude.'",';
		          	echo "destination: ".'"'.$Route->destination->latitude.','.$Route->destination->longitude.'",';
		          	echo "waypoints: waypts,
		          optimizeWaypoints: true,
		          travelMode: 'DRIVING'},function(response, status) {";
		            echo "if (status === 'OK') {";
		            echo "var route = response.routes[0];";
		            echo "document.getElementById('d".$i."').innerHTML = route.legs[0].distance.text }";
		            echo 'else if (status === "REQUEST_DENIED") {
		              window.alert("Request denied: " + response.statusMessage);
		          } 
		          else {
		            window.alert("Directions request failed due to " + status);
		          }});';
				 }  
			?>
		}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLLTh4BjjRbNHN9-rTyJlBIjRt1R4CQoQ&callback=initMap">
    </script>
</body>
</html>