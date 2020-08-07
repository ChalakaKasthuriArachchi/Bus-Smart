<?php 
	function get_RouteSubRoute_Details(){
		include('connection.php');
		$stmt = $conn->prepare("SELECT route_sub_route.ID AS ID,RouteID,Sub_Route_ID,Route_No,Route_Name,location.Name as Location,Distance,Way_Point FROM route_sub_route inner join route on RouteID = route.ID inner join sub_route_location on SubRouteID = sub_route_location.Sub_Route_ID inner join location on Location_ID = location.ID order by RouteID , sub_route_location.ID;");
    	$stmt->execute();
		return $stmt->get_result();
	}
	function get_SubRoute_Details(){
		include('connection.php');
		$stmt = $conn->prepare("SELECT * FROM sub_route_location INNER JOIN location ON sub_route_location.Location_ID = location.ID;");
    	$stmt->execute();
		return $stmt->get_result();	
	}
	function get_Route($RouteID,$LocID1,$LocID2){
		include('connection.php');
		$Route = new stdClass;
		$Route->waypoints = array();
		$stmt = $conn->prepare("SELECT route_sub_route.ID AS ID,RouteID,Sub_Route_ID,Route_No,Route_Name,location.ID as LocationID,location.Name as Location,Distance,Way_Point,Latitude,Longitude FROM route_sub_route inner join route on RouteID = route.ID inner join sub_route_location on SubRouteID = sub_route_location.Sub_Route_ID inner join location on Location_ID = location.ID WHERE route.ID = '$RouteID' order by RouteID , sub_route_location.ID;");
    	$stmt->execute();
		$result = $stmt->get_result();	
		
		$count = 0;
		while($row=mysqli_fetch_assoc($result)){
			if($count == 0){
				$Route->no = $row['Route_No'];
				$Route->name = $row['Route_Name'];
				if($LocID1 < 0){
					$Route->origin = new stdClass;
					$Route->origin->latitude = $row['Latitude'];
					$Route->origin->longitude = $row['Longitude'];
				}
			}
			if($LocID1 == $row['LocationID']){
				if(isset($Route->origin)){
					$Route->destination = new stdClass;
					$Route->destination->latitude = $row['Latitude'];
					$Route->destination->longitude = $row['Longitude'];
					return $Route;
				}
				else{
					$Route->origin = new stdClass;
					$Route->origin->latitude = $row['Latitude'];
					$Route->origin->longitude = $row['Longitude'];	
					$LocID1 = 0;
				}
			}
			else if($LocID2 == $row['LocationID']){
				if(isset($Route->origin)){
					$Route->destination = new stdClass;
					$Route->destination->latitude = $row['Latitude'];
					$Route->destination->longitude = $row['Longitude'];
					return $Route;
				}
				else{
					$Route->origin = new stdClass;
					$Route->origin->latitude = $row['Latitude'];
					$Route->origin->longitude = $row['Longitude'];	
					$LocID2 = 0;
				}
			}
			else if($count + 1 == $result->num_rows){
				$Route->destination = new stdClass;
				$Route->destination->latitude = $row['Latitude'];
				$Route->destination->longitude = $row['Longitude'];
			}
			else if($LocID1 < 1 || $LocID2 < 1){
				if($row['Way_Point'] == 1){
					$location = new stdClass;
					$location->latitude = $row['Latitude'];
					$location->longitude = $row['Longitude'];
					array_push($Route->waypoints,$location);
				}
			}
			$count++;
		}
		return $Route;
	}
	function get_Sub_Route($SubRouteID){
		include('connection.php');
		$Route = new stdClass;
		$Route->id = $SubRouteID;
		$Route->waypoints = array();
		$stmt = $conn->prepare("SELECT * FROM id10834767_mydb.sub_route_location inner join location on Location_ID = location.ID where Sub_Route_ID =".$SubRouteID.";");
    	$stmt->execute();
		$result = $stmt->get_result();	
		
		$count = 0;
		while($row=mysqli_fetch_assoc($result)){
			if($count == 0){
				$Route->origin = new stdClass;
				$Route->origin->latitude = $row['Latitude'];
				$Route->origin->longitude = $row['Longitude'];
			}
			else if($count + 1 == $result->num_rows){
				$Route->destination = new stdClass;
				$Route->destination->latitude = $row['Latitude'];
				$Route->destination->longitude = $row['Longitude'];
			}
			else{
				if($row['Way_Point'] == 1){
					$location = new stdClass;
					$location->latitude = $row['Latitude'];
					$location->longitude = $row['Longitude'];
					array_push($Route->waypoints,$location);
				}
			}
			$count++;
		}
		return $Route;
	}
	function get_AllLocations(){
		include('connection.php');
		$locations = array();
		$stmt = $conn->prepare("SELECT * FROM location;");
    	$stmt->execute();
		$result = $stmt->get_result();	

		while($row=mysqli_fetch_assoc($result)){
			array_push($locations,toLocation($row));
		}
		return $locations;
	}
	function toLocation($row){
		$location = new stdClass;
		$location->id = (int)$row['ID'];
		$location->name = $row['Name'];
		$location->latitude = $row['Latitude'];
		$location->longitude = $row['Longitude'];
		$location->type = $row['Type'];
		return $location;
	}
	function toRoute($row){
		$route = new stdClass;
		$route->id = (int)$row['ID'];
		$route->route_no = $row['Route_No'];
		$route->route_name = $row['Route_Name'];
		$route->location_id1 = $row['Location_ID1'];
		$route->location_id2 = $row['Location_ID2'];
		$route->via = $row['Via'];
		return $route;
	}
	function get_BusDetails($RegNo){
		include('functions.php');
		include('connection.php');
		date_default_timezone_set("Asia/Colombo");
		$bus = new stdClass;

		$stmt = $conn->prepare("SELECT * FROM bus INNER JOIN route ON bus.RouteID = route.ID WHERE RegNo ='".$RegNo."' LIMIT 1");
    		$stmt->execute();
			$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        $bus->name = $row['Name'];
			        $bus->route_no = $row['Route_No'];
			        $bus->route=$row['Route_Name'];
			        $bus->category=$row['Category'];
			        $bus->express=$row['Express'];
			        $bus->speed=$row['Speed'];
			        
			        $bus->contact=$row['Contact'];
			        $bus->route_id=$row['RouteID'];

			        $bus->location = new stdClass;
			        $bus->location->latitude=$row['Latitude'];
			        $bus->location->longitude=$row['Longitude'];

			        $str = date('Y-m-d H:i:s').'';
			        $bus->last_updated = get_TimeDifference(strtotime($row['LastUpdated']),strtotime($str));
			        break;
			    }
			}
		return $bus;
	}
	function get_UserRoute($Route){
		return get_Route();
	}
	function get_LocationDetails($id){
		include('connection.php');
		$stmt = $conn->prepare("SELECT * FROM location WHERE ID='".$id."';");
    	$stmt->execute();
		$result = $stmt->get_result();
		return toLocation(mysqli_fetch_assoc($result));
	}
	function get_RouteDetails($id){
		include('connection.php');
		$stmt = $conn->prepare("SELECT * FROM route WHERE ID='".$id."';");
    	$stmt->execute();
		$result = $stmt->get_result();
		return toRoute(mysqli_fetch_assoc($result));
	}
	function get_NearestLocation($lat,$lng){
		include('connection.php');
		$sql_diff_lat = "Latitude - ".$lat;
		$sql_diff_lng = "Longitude - ".$lng;
		$sql_distance = "SQRT(POWER(".$sql_diff_lat.",2) + POWER(".$sql_diff_lng.",2))";
  		$sql = "SELECT ID,Name,Latitude,Longitude,Type,$sql_distance AS Distance FROM location WHERE $sql_distance = (SELECT MIN($sql_distance) FROM location)";
  		//echo $sql;
  		//$stmt = $conn->prepare("SELECT * FROM location WHERE ID='".$id."';");
  		//echo $sql;
  		$stmt = $conn->prepare($sql);
    	$stmt->execute();
		$result = $stmt->get_result();
		return toLocation(mysqli_fetch_assoc($result));	
  	}
  	function get_LocationGraph($loc){
  		$graph = new stdClass();
  		
  	}
  	function get_AllSubRouteLocations(){
  		include('connection.php');

  		$stmt = $conn->prepare("SELECT * FROM sub_route_location;");
    	$stmt->execute();
		return $stmt->get_result();	
  	}
  	function get_RouteBySubRoutes($sub1,$sub2){
  		include('connection.php');

  		$stmt = $conn->prepare('SELECT RouteID,count(SubRouteID) as n FROM id10834767_mydb.route_sub_route where ('     .'SubRouteID = '.$sub1.' OR SubRouteID = '.$sub2.') group by RouteID;');
    	$stmt->execute();	
		return $stmt->get_result();
  	}
  	function get_BusIDList($RouteID){
  		include('connection.php');
  		$BusIDList = array();
  		$i = 0;
  		$stmt = $conn->prepare("SELECT * FROM id10834767_mydb.bus WHERE RouteID = '".$RouteID."';");
    	$stmt->execute();	
    	$result = $stmt->get_result();
    	while($row = $result->fetch_assoc()){
			$BusIDList[$i++] = $row['RegNo'];  
		}
		return $BusIDList;
  	}
  	function get_BusList($RouteID){
  		include('connection.php');
  		$BusList = array();
  		$i = 0;
  		$stmt = $conn->prepare("SELECT * FROM id10834767_mydb.bus WHERE RouteID = '".$RouteID."' order by Available;");
    	$stmt->execute();	
    	$result = $stmt->get_result();
    	while($row = $result->fetch_assoc()){
			$BusList[$i++] = toBus($row);  
		}
		return $BusList;
  	}
  	function toBus($row){
  		$Bus = new stdClass();
  		$Bus->RegNo = $row['RegNo'];
  		$Bus->Name = $row['Name'];
  		$Bus->Contact = $row['Contact'];
  		$Bus->Category = $row['Category'];
  		$Bus->Express = $row['Express'];
  		$Bus->Latitude = $row['Latitude'];
  		$Bus->Longitude = $row['Longitude'];
  		$Bus->Speed = $row['Speed'];
  		$Bus->LastUpdated = $row['LastUpdated'];
  		$Bus->Available = $row['Available'];
  		$Bus->Direction = $row['Direction'];
  		$Bus->Journey = $row['Journey'];
  		$Bus->OwnerID = $row['OwnerID'];
  		$Bus->RouteID = $row['RouteID'];
  		$str = date('Y-m-d H:i:s').'';
		$Bus->LastUpdated = get_TimeDifference(strtotime($row['LastUpdated']),strtotime($str));
  		return $Bus;
  	}
  	function CompareLocationInRoute($RouteID,$loc1,$loc2){
  		include('connection.php');
		$Route = new stdClass;
		$Route->waypoints = array();
		$stmt = $conn->prepare("SELECT sub_route_location.Location_ID as LocationID FROM route_sub_route inner join route on RouteID = route.ID inner join sub_route_location on SubRouteID = sub_route_location.Sub_Route_ID  WHERE route.ID = $RouteID order by RouteID , sub_route_location.ID;");
    	$stmt->execute();
		$result = $stmt->get_result();

  		while($row = $result->fetch_assoc()){
  			if($row['LocationID'] == $loc1)
  				return 1;
  			if($row['LocationID'] == $loc2)
  				return 0;
  		}
  	}
  	function getMyBusses($OwnerID){
  		include('connection.php');
  		$BusList = array();
  		$i = 0;
  		$stmt = $conn->prepare("SELECT * FROM id10834767_mydb.bus inner join id10834767_mydb.route on RouteID = route.ID WHERE OwnerID = '".$OwnerID."';");
    	$stmt->execute();	
    	$result = $stmt->get_result();
    	while($row = $result->fetch_assoc()){
			$BusList[$i] = toBus($row);  
			$BusList[$i]->Location_ID1 = $row['Location_ID1'];
			$BusList[$i]->Location_ID2 = $row['Location_ID2'];
			$i++;
		}
		return $BusList;
  	}
  	function getLocationHistoryDates($RegNo){
  		include('connection.php');
  		$DateList = array();
  		$i = 0;
  		$stmt = $conn->prepare("SELECT DATE_FORMAT(LastUpdated,'%Y-%m-%d') as `Date`,count(DATE_FORMAT(LastUpdated,'%Y-%m-%d')) as `Count`,Journey_ID FROM id10834767_mydb.test_bus WHERE RegNo = '".$RegNo."' group by DATE_FORMAT(LastUpdated,'%Y-%m-%d');");
    	$stmt->execute();	
    	$result = $stmt->get_result();
    	while($row = $result->fetch_assoc()){
    		$Date = new stdClass();
    		$Date->Date = $row['Date'];
    		$Date->Count = $row['Count'];
    		$Date->Journey = $row['Journey_ID'];
			$DateList[$i] = $Date; 
			$i++;
		}
		return $DateList;
  	}
  	function getLocationHistoryPlaces($RegNo,$Date){
  		include('connection.php');
  		$Locations = array();
  		$i = 0;
  		$stmt = $conn->prepare("SELECT * FROM id10834767_mydb.test_bus WHERE DATE_FORMAT(LastUpdated,'%Y-%m-%d') = '".$Date."' AND RegNo = '".$RegNo."';");
    	$stmt->execute();	
    	$result = $stmt->get_result();
    	while($row = $result->fetch_assoc()){
    		$Location = new stdClass();
    		$Location->latitude = $row['Latitude'];
    		$Location->longitude = $row['Longitude'];
    		$Location->time = $row['LastUpdated']; 
			$Locations[$i] = $Location; 
			$i++;
		}
		return $Locations;
  	}
  	function getAverageSpeed($RegNo,$Date){
  		include('connection.php');
  		$stmt = $conn->prepare("SELECT AVG(Speed) as 'avg' FROM id10834767_mydb.test_bus WHERE RegNo = '".$RegNo."' AND DATE_FORMAT(LastUpdated,'%Y-%m-%d') = '".$Date."' AND Speed > 0 LIMIT 20;");
    	$stmt->execute();	
    	$result = $stmt->get_result();
    	while($row = $result->fetch_assoc()){
    		return $row['avg'];
    	}
  	}
  	function getDirection($RouteID,$Loc1,$Loc2){
  		include('connection.php');
		$Distance = 0;
		$Started = 0;
		$stmt = $conn->prepare("SELECT location.ID as LocationID,Distance FROM route_sub_route inner join route on RouteID = route.ID inner join sub_route_location on SubRouteID = sub_route_location.Sub_Route_ID inner join location on Location_ID = location.ID WHERE route.ID = '$RouteID' order by RouteID , sub_route_location.ID;");
    	$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
			if($Loc1 == $row['LocationID'] || $Loc2 == $row['LocationID']){
				if($Started == 1){
					return $Distance;
				}
				else{
					$Started = 1;
				}
			}
			if($Started == 1){
				$Distance += $row['Distance'];
			}
		}
		return $Distance;
  	}
?>