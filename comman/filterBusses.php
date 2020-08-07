<?php
	function getAvailableBusses($RouteID,$LocStart,$LocEnd){
        date_default_timezone_set("Asia/Colombo");

	    include('comman/db_functions.php');
	    include('comman/best_route_functions.php');
	    include('comman/functions.php');

		$FilteredBusList = array();
		$BusList = get_BusList($RouteID);
		$Route = get_RouteDetails($RouteID);
		$AllBusses = count($BusList);
		$n = 0;
		$TravellingDirection = CompareLocationInRoute($RouteID,$LocStart,$LocEnd);
		for ($i=0; $i < $AllBusses; $i++) { 
			if($BusList[$i]->Direction == $TravellingDirection){
				$CurrentLoc = get_NearestLocation($BusList[$i]->Latitude,$BusList[$i]->Longitude);
				if($TravellingDirection == CompareLocationInRoute($RouteID,$CurrentLoc->id,$LocStart)){
					$FilteredBusList[$n] = $BusList[$i];
					setTimeRemain($BusList[$i]);
					$n++;
				}
			}
		}
		return $FilteredBusList;
	}
?>