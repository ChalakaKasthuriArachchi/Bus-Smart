<?php  
	include('comman/db_functions.php');
	include('comman/best_route_functions.php');


	echo "Start : ".$_GET['start'];
	echo "<br>";
	echo "End : ".$_GET['end'];
	echo "<BR>";

	$keywords = preg_split("/[,]+/", $_GET['start']);

	$lat1 = str_replace("(", "",$keywords[0]);
	$lat2 = str_replace(")", "",$keywords[1]);
	$locStart = get_NearestLocation($lat1,$lat2);

	$keywords = preg_split("/[,]+/", $_GET['end']);
	$lat3 = str_replace("(", "",$keywords[0]);
	$lat4 = str_replace(")", "",$keywords[1]);
	$locEnd = get_NearestLocation($lat3,$lat4);

	// echo $locStart->id." ".$locStart->name."<BR>";
	// echo $locEnd->id." ".$locEnd->name;

	//findBestRoute($locStart->id,$locEnd->id);
	echo $locStart->id." ".$locEnd->id.'<BR>';
	findBestRoute($locStart->id,$locEnd->id);
?>