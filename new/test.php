<?php
include('../comman/connection.php');
		$bus = new stdClass;
		$RegNo = 'NA-1000';

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
			        $bus->last_updated=$row['LastUpdated'];
			        $bus->contact=$row['Contact'];
			        $bus->route_id=$row['RouteID'];

			        $bus->location = new stdClass;
			        $bus->location->latitude=$row['Latitude'];
			        $bus->location->longitude=$row['Longitude'];
			        break;
			    }
			}
		echo $result->num_rows;
?>