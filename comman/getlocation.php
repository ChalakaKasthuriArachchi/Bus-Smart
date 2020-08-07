<?php
include('connection.php');
include('functions.php');

  date_default_timezone_set("Asia/Colombo");
 if (isset($_GET["regno"]))
{
   	header("Content-Type: application/json; charset=UTF-8");
	
	$stmt = $conn->prepare("SELECT * FROM bus WHERE RegNo ='". 
		$_GET["regno"]."' LIMIT 1");
	//$stmt->bind_param("NG-8310", 1);
	$stmt->execute();
	$result = $stmt->get_result();
	//$outp = $result->fetch_all(MYSQLI_ASSOC);

	$myObj = new stdClass;
	if ($result->num_rows > 0) {
    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        $myObj->latitude = $row["Latitude"];
			$myObj->longitude = $row["Longitude"];
			$myObj->speed = $row["Speed"];
			$str = date('Y-m-d H:i:s').'';
			$myObj->last_updated = get_TimeDifference(strtotime($row['LastUpdated']),strtotime($str));
	    }
	}

	echo json_encode($myObj);
}

?>