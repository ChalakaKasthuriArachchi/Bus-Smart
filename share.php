<?php
include('comman/connection.php');

  date_default_timezone_set("Asia/Colombo");
 if (isset($_GET["regno"])&isset($_GET["latitude"])&isset($_GET["longitude"])&isset($_GET["speed"]))
{
     $regno = $_GET["regno"];
     $latitude = $_GET["latitude"];
     $longitude = $_GET["longitude"];
     $speed = $_GET["speed"];
     $lastupdated = date('Y-m-d H:i:s');

     //$sql = "INSERT INTO arduino (data_1, data_2) VALUES ('$data1','$data2')";    
     $sql = "INSERT INTO test_bus (RegNo,Latitude,Longitude,Speed,LastUpdated) VALUES('$regno','$latitude','$longitude','$speed','$lastupdated');";
     $sql2 = "UPDATE bus SET Latitude = '$latitude', Longitude = '$longitude', Speed = '$speed', LastUpdated = '$lastupdated' WHERE RegNo = '$regno'; " ;
    // Execute SQL statement 
    mysqli_query($conn,$sql);
    mysqli_query($conn,$sql2);
    echo 'Location Recieved : ';
}
// else{
//      $sql = "INSERT INTO arduino (data_1, data_2) VALUES (0,0)";    
//     // Execute SQL statement 
//  mysqli_query($conn,$sql);
 
//    header("Location: table.php");
// }


?>