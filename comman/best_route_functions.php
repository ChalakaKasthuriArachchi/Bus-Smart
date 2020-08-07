<?php
/* Get List of Sub Route IDs */
function findBestRoute($loc1,$loc2){
	//Variable Diclaration
	$S = array(); $T = array(); $P = array(); $Q = array();
	$x = 0; $y = 0;

	$dir = get_DirectionMatrix();
	$n = $dir->locCount;

	//Initialization - S(i)
	for($i = 1; $i < $n; $i++){
		if(isset($dir->matrix[$loc1][$i])){
			$S[$i] = $dir->matrix[$loc1][$i]->Distance;
		}
		$P[$i] = $loc1; //Which location Come From
	}
	//Initialization - T(i)
	for($i = 1; $i < $n; $i++){
		if(isset($dir->matrix[$loc2][$i])){
			$T[$i] = $dir->matrix[$i][$loc2]->Distance;
		}
		$Q[$i] = $loc2;
	}
	// print_Array($S,$n,'S');
	// print_Array($P,$n,'P');
	// print_Array($T,$n,'T');
	// print_Array($Q,$n,'Q');
	while(1){
		/*Display Matrix*/
		// echo "<BR><BR>&nbsp;&nbsp;&nbsp;";
		// for($i = 1; $i < $dir->locCount; $i++)
		// 	echo "&nbsp;$i,0&nbsp;";
		// echo '<BR>';
	 //    for($i = 1; $i < $dir->locCount; $i++){
		// 	echo "&nbsp;$i&nbsp;";
		// 	for($j = 1; $j < $dir->locCount; $j++){
		// 		if(!isset($dir->matrix[$i][$j]))
		// 			echo '&nbsp;u,0&nbsp;';
		// 		else
		// 			echo "&nbsp;".($dir->matrix[$i][$j]->Distance).",".($dir->matrix[$i][$j]->Sub_Route_ID)."&nbsp;";
		// 	}	
		// 	echo '<BR>';
		// }
		//echo '<BR><BR>';
		/**/
		$S_min = get_MinValue($S,$n,$x);
		$T_min = get_MinValue($T,$n,$y);
		$MinOfSum = get_MinOfSum($S,$T,$n);
		
		// echo "S_min : $S_min<BR>";
		// echo "T_min : $T_min<BR>";
		// echo "x : $x<BR>";
		// echo "y : $y<BR>";
		// echo "MinOfSum : $MinOfSum<BR>";

		if($MinOfSum != 0 && $MinOfSum <= $S_min + $T_min){
			break;
		}

		if($S_min <= $T_min){
			$x = $S_min;
			for($a = 1; $a < $n; $a++){
				if(isset($S[$a]) && $S[$a] == $x){
					for($b = 1; $b < $n; $b++){
						if(isset($dir->matrix[$b][$a]) && $dir->matrix[$b][$a]->Distance > 0){
							if(!isset($S[$b]) || ($S[$b] > $dir->matrix[$b][$a]->Distance + $x)){
								$S[$b] = $dir->matrix[$b][$a]->Distance + $x;
								$P[$b] = $a;
							}
						}
					}
				}
			}
		}
		else{
			$y = $T_min;
			for($a = 1; $a < $n; $a++){
				if(isset($T[$a]) && $T[$a] == $y){
					for($b = 1; $b < $n; $b++){
						if(isset($dir->matrix[$b][$a]) && $dir->matrix[$b][$a]->Distance > 0){
							if(!isset($T[$b]) || ($T[$b] > $dir->matrix[$b][$a]->Distance + $y)){
								$T[$b] = $dir->matrix[$b][$a]->Distance + $y;
								$Q[$b] = $a;
							}
						}
					}
				}
			}
		}
		// echo "<br>";
		// print_Array($S,$n,'S');
		// print_Array($P,$n,'P');
		// print_Array($T,$n,'T');
		// print_Array($Q,$n,'Q');		
	}
	/* Find Connection Point - i */
	$i;
    for($i = 1; $i < $n; $i++){
		if(isset($S[$i]) && isset($T[$i]) && $MinOfSum == ($S[$i] + $T[$i]))
			break;
	}
	//echo "<BR>".getPath($i,$P,$loc1)."$i&nbsp;".getReversedPath($i,$Q,$loc2);
	$col = new stdClass();
	$col->arry = array();
	$col->sr = array();
	$col->n = 0;

	$col = getPath($i,$P,$loc1,$col);
	$col->arry[$col->n++] = $i;
	$col = getReversedPath($i,$Q,$loc2,$col);
	
	for($a = 0; $a < $col->n; $a++)
		/*echo $col->arry[$a].'<BR>'*/;

/* Sub Route Location List */
	// for($a = 0; $a + 1 < $col->n; $a++){
	// 	$t1 = $col->arry[$a];
	// 	$t2 = $col->arry[$a+1];
	// 	echo $t1.'-'.$t2.'=>'.$dir->matrix[$t1][$t2]->Sub_Route_ID.'<BR>';
	// }
	/* Sub Route List */
	$subRouteList = new stdClass();
	$subRouteList->list = array();
	$subRouteList->n = 0;

	$prevLoc = $col->arry[0];
	$SubRoute = $dir->matrix[$col->arry[0]][$col->arry[1]]->Sub_Route_ID;
	for($a = 1; $a < $col->n - 1; $a++){
		$t1 = $col->arry[$a];
		$t2 = $col->arry[$a+1];
		if($dir->matrix[$t1][$t2]->Sub_Route_ID != $SubRoute){
				//echo $prevLoc.'-'.$t1.'=>'.$SubRoute.'<BR>';	
			/* Adding to Subroute List */
			$subRoute = new stdClass();
			$subRoute->start = $prevLoc;
			$subRoute->end = $t1;
			$subRoute->subRouteID = $SubRoute;
			$subRouteList->list[$subRouteList->n++] = $subRoute;
			/**/
			$SubRoute = $dir->matrix[$t1][$t2]->Sub_Route_ID;
			$prevLoc = $t1;
		}
	}
	//echo $prevLoc.'-'.$col->arry[$col->n - 1].'=>'.$SubRoute.'<BR>';
	/* Adding to Subroute List  - LAst element*/
	$subRoute = new stdClass();
	$subRoute->start = $prevLoc;
	$subRoute->end = $col->arry[$col->n - 1];
	$subRoute->subRouteID = $SubRoute;
	$subRouteList->list[$subRouteList->n++] = $subRoute;
	/**/
	return getRouteList($subRouteList,$MinOfSum);
}
function getRouteList($subRouteList,$distance){
	$RouteList = new stdClass();
	$RouteList->list = array();
	$RouteList->n = 0;

	for ($i=0; $i < $subRouteList->n - 1; $i++) { 
		// echo $subRouteList->list[$i]->start.'-'.$subRouteList->list[$i]->end.'=>'.
		// $subRouteList->list[$i]->subRouteID.'<BR>';
		$result = get_RouteBySubRoutes($subRouteList->list[$i]->subRouteID,
			$subRouteList->list[$i + 1]->subRouteID);
		//$result = get_RouteBySubRoutes(1,2);
		$Routes = new stdClass();
		$Routes->n = 0;
		$Routes->list = array();

		while($row = $result->fetch_assoc()){
			if($row['n'] == 2){
				$Route = new stdClass();
				$Route->RouteID = $row['RouteID'];
				$Route->start = $subRouteList->list[$i]->start;
				$Route->end = $subRouteList->list[$i + 1]->end;
				//$Route->BusIDList = get_BusIDList($Route->RouteID);
            	$Routes->list[$Routes->n] = $Route;
            	$Routes->n++;
			}
		}
		if($Routes->n > 0){
			$RouteList->list[$RouteList->n] = $Routes;
			$RouteList->n++;
		}	
	}
	$FRoutes = new stdClass();
	$FRoutes->list = array();
	$FRoutes->n = 0;
	$FRoutes->distance = $distance;

	// for($i=0; $i < $RouteList->n; $i++) { 
	// 	echo "$i => ";
	// 	for($j=0; $j < $RouteList->list[$i]->n; $j++) { 
	// 		echo $RouteList->list[$i]->list[$j]->RouteID." (".$RouteList->list[$i]->list[$j]->start.") ";
	// 	}
	// 	echo "<BR>";
	// }
	for($i=0; $i < $RouteList->n; $i++){
		if($i != 0 && $FRoutes->list[$FRoutes->n - 1]->RouteID == $RouteList->list[$i]->list[0]->RouteID){
				$FRoutes->list[$FRoutes->n  - 1]->end = $RouteList->list[$i]->list[0]->end;
				//echo $FRoutes->list[$FRoutes->n - 1]->RouteID." | ".$FRoutes->n."<BR>";
		}
		else{
			$FRoutes->list[$FRoutes->n] = $RouteList->list[$i]->list[0];
			$FRoutes->n++;
		}
	}
	// for($i=0; $i < $FRoutes->n; $i++){
	// 	echo $FRoutes->list[$i]->RouteID."[".$FRoutes->list[$i]->start."|".$FRoutes->list[$i]->end."]"."<BR>";
	// }
	return $FRoutes;
}

function getPath($i,$P,$loc1,$col){
	if($P[$i] == $loc1){
		$col->arry[0] = $loc1;
		$col->n = 1;
		return $col;
	}
	else{
		$col = getPath($P[$i],$P,$loc1,$col);
		$col->arry[$col->n++] = $P[$i];
		return $col;
	}
}
function getReversedPath($i,$P,$loc1,$col){
	if($P[$i] == $loc1){
		$col->arry[$col->n++] = $loc1;
		return $col;
	}
	else{
		$col->arry[$col->n++] = $P[$i];
		return getReversedPath($P[$i],$P,$loc1,$col);
	}
}
function print_Array($arr,$n,$hd){
	echo "<BR>&nbsp;$hd&nbsp;";
    for($i = 1; $i < $n; $i++){
    	if(isset($arr[$i])){
    		if(isset($arr[$i]->Distance))
    			echo "&nbsp;".($arr[$i]->Distance)."&nbsp;";
    		else
    			echo "&nbsp;".($arr[$i])."&nbsp;";
    	}
    	else{
    		echo '&nbsp;u&nbsp;';
    	}
    }
}
function get_MinOfSum($arr1,$arr2,$n){
	$min = 0;
	for($i = 1; $i < $n; $i++){
		if(isset($arr1[$i]) && isset($arr2[$i])){
			if($min == 0 || $min > $arr1[$i] + $arr2[$i])
				$min = $arr1[$i] + $arr2[$i];
		}
	}
	return $min;
}
function get_MinValue($arr,$n,$b){
	$min = 0;
	for($i = 1; $i < $n; $i++){
		if(isset($arr[$i])){
			if(($min == 0 || $arr[$i] < $min) && $arr[$i] > $b)
				$min = $arr[$i];
		}
	}
	return $min;
}
function get_DirectionMatrix(){
	$prevLoc = 0;
	$subRoute = 0;
	
	$dir = new stdClass();
	$dir->matrix = array();
	$dir->locCount = -1;

	$result = get_AllSubRouteLocations();
	while($row = mysqli_fetch_assoc($result)){
		$srl = toSubRouteLocation($row);

		if($subRoute == 0 || $subRoute != $srl->Sub_Route_ID){
			$subRoute = $srl->Sub_Route_ID;
			$prevLoc = $srl->Location_ID;
		}
		else{
			/* Path Details */
			$path = new stdClass();
			$path->Sub_Route_ID = $subRoute;
			$path->Distance = $srl->Distance;
			/**/
			$dir->matrix[$prevLoc][$srl->Location_ID] = $path;
			$dir->matrix[$srl->Location_ID][$prevLoc] = $path;
			$prevLoc = $srl->Location_ID;

		}
		if($prevLoc > $dir->locCount)
			$dir->locCount = $prevLoc;
	}
	$dir->locCount++;
	/**/
	for($i = 0; $i < $dir->locCount; $i++){
		$path = new stdClass();
		$path->Sub_Route_ID = 0;
		$path->Distance = 0;
		$dir->matrix[$i][$i] = $path;
	}
	/**/
	return $dir;
}

function toSubRouteLocation($row){
  	$srl = new stdClass();
  	$srl->Sub_Route_ID = $row['Sub_Route_ID'];
  	$srl->Location_ID = $row['Location_ID'];
  	$srl->Distance = $row['Distance'];
  	$srl->Way_Point = $row['Way_Point'];
  	return $srl;
}
?>