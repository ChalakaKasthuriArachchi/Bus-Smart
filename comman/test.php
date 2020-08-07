<?php
	// include('db_functions.php');
	// include('best_route_functions.php');

	// $keywords = preg_split("/[,]+/", $_GET['start']);

	// $lat1 = str_replace("(", "",$keywords[0]);
	// $lat2 = str_replace(")", "",$keywords[1]);
	// $locStart = get_NearestLocation($lat1,$lat2);

	// $keywords = preg_split("/[,]+/", $_GET['end']);
	// $lat3 = str_replace("(", "",$keywords[0]);
	// $lat4 = str_replace(")", "",$keywords[1]);
	// $locEnd = get_NearestLocation($lat3,$lat4);

	// $FRoutes = findBestRoute(383,382);
	    include('db_functions.php');
	    include('best_route_functions.php');
	    include('functions.php');
	    $RouteID = 16;
	    $LocStart = 99;
	    $LocEnd = 383;

		$FilteredBusList = array();
		$BusList = get_BusList(16);
		$Route = get_RouteDetails(16);
		$AllBusses = count($BusList);
		$n = 0;
		$TravellingDirection = CompareLocationInRoute($RouteID,$LocStart,$LocEnd);
		for ($i=0; $i < $AllBusses; $i++) { 
			if($BusList[$i]->Direction == $TravellingDirection){
				$CurrentLoc = get_NearestLocation($BusList[$i]->Latitude,$BusList[$i]->Longitude);
				echo $CurrentLoc->id." ".$LocStart." | ".CompareLocationInRoute($RouteID,$CurrentLoc->id,$LocStart)."<BR>";
				if($TravellingDirection == CompareLocationInRoute($RouteID,$CurrentLoc->id,$LocStart)){
					$FilteredBusList[$n] = $BusList[$i];
					$n++;
				}
			}
		}
		//echo count($FilteredBusList);
?>