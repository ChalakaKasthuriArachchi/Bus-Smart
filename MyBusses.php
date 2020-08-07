<?php
	$OwnerID = $_GET["OwnerID"];
	$BusList = getMyBusses($OwnerID);
	$n = count($BusList);
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
				<!-- <h1 align="content">Galle-Matara</h1> -->
<table class="responstable table">
  
  
  <tr>
    <th>Reg No</th>
    <th>Current location</th>
    <th>View History</th>
  </tr>
  
  <tr>
    <td>NA-1000</td>
    <td>Tangalle</td>
    <td><a href="Busdetails.html"><div class="containerbtn"><button class="btn">Go</button></div></a></td>
  </tr>
  
  <tr>
    <td>NA-1024</td>
    <td>Gandara</td>
    <td><a href="Busdetails.html"><div class="containerbtn"><button class="btn">Go</button></div></a></td>
  </tr>

   <tr>
    <td>NA-1024</td>
    <td>Gandara</td>
    <td><a href="Busdetails.html"><div class="containerbtn"><button class="btn">Go</button></div></a></td>
  </tr>

   <tr>
    <td>NA-1024</td>
    <td>Gandara</td>
    <td><a href="Busdetails.html"><div class="containerbtn"><button class="btn">Go</button></div></a></td>
  </tr>

   <tr>
    <td>NA-1024</td>
    <td>Gandara</td>
    <td><a href="Busdetails.html"><div class="containerbtn"><button class="btn">Go</button></div></a></td>
  </tr>
  

   
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