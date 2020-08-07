<?php  
	include('comman/db_functions.php');
	include('comman/best_route_functions.php');
	include('comman/filterBusses.php');

	$keywords = preg_split("/[,]+/", $_GET['start']);

	$lat1 = str_replace("(", "",$keywords[0]);
	$lat2 = str_replace(")", "",$keywords[1]);
	$locStart = get_NearestLocation($lat1,$lat2);

	$keywords = preg_split("/[,]+/", $_GET['end']);
	$lat3 = str_replace("(", "",$keywords[0]);
	$lat4 = str_replace(")", "",$keywords[1]);
	$locEnd = get_NearestLocation($lat3,$lat4);

	//echo $locStart->id . ' '. $locEnd->id;
	$FRoutes = findBestRoute($locStart->id,$locEnd->id);
	//$FRoutes = findBestRoute(383,259);
	$Alternatives = array();
	$n = 0;
	$PrevLoc = 0;
	for ($i=0; $i < $FRoutes->n; $i++) { 
		if($i == 0  || $PrevLoc != $FRoutes->list[$i]->start){
			$Alternative = new stdClass();
			$Alternative->RouteID = $FRoutes->list[$i]->RouteID;
			$Alternative->Interchanges = '';
			//$Alternative->Distance = $FRoutes->list[$i]->Distance;
			$Alternatives[$n] = $Alternative;
			$PrevLoc = $FRoutes->list[$i]->end;
			$n++;			
		}
		else{
			$loc = get_LocationDetails($PrevLoc);
			$Alternatives[$n-1]->Interchanges = $Alternatives[$n-1]->Interchanges.$loc->name.',';  
		}
		$PrevLoc = $FRoutes->list[$i]->end;
	}
?>

<html>
<head>
<title>Location a Travel Category Flat Bootstarp Responsive Website Template | location :: w3layouts</title>
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
					<li><a href="login.html"><i class="roc"> </i>My Account</a></li>
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
		<div class="containe">
			<div class="register">
				<!-- <h1 align="content">Galle-Matara</h1> -->
				<h1 align="center">Best Route</h1>

				<!-- <a href="Busdetails.html"><div class="containerbtn"><button class="btn">Back</button></div></a> -->
				

		<table class="responstable table ">
  
				  <tr>
				    <th>Starting Route</th>
				    <th>Interchanges</th>
				    <th></th>
				  </tr>
				

				<?php 
					for ($i=0; $i < $n; $i++) { 
						$Route = get_RouteDetails($Alternatives[$i]->RouteID);
						echo '<tr>';
						echo "<td>".$Route->route_no.' | '.$Route->route_name."</td>";
						echo "<td>".$Alternatives[$i]->Interchanges."</td>";
						echo '<td><a href="routelist.php?RouteID='.$Alternatives[$i]->RouteID.'&start='.$locStart->id.'&end='.$locEnd->id.'">';
						echo '<div align="center">Go</div></a></td>';
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
	
</body>
</html>