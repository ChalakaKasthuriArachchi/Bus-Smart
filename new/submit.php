<?php
include('../comman/connection.php');

  date_default_timezone_set("Asia/Colombo");
 if (isset($_GET["Type"]))
{
    if($_GET["Type"] == 'Location'){
         $name = $_GET["Name"];
         $latitude = $_GET["Latitude"];
         $longitude = $_GET["Longitude"];
         $type = $_GET["LocationType"];
         $sql = "";

         if($_GET["id"] > 0)
            $sql = "UPDATE location SET Name = '".$name."', Latitude = '".$latitude."', Longitude = '".$longitude."', Type = '".$type."' WHERE ID = '".$_GET["id"]."';";
         else
            $sql = "INSERT INTO location (Name, Latitude,Longitude,Type) VALUES ('$name','$latitude','$longitude','$type')";    
         
        // Execute SQL statement 
        mysqli_query($conn,$sql);
        //echo $sql;
        header("Location: location.php");
    }
    else if($_GET["Type"] == 'sub_route_location'){
         $sub_route_id = $_GET["Sub_Route_ID"];
         $location_id = $_GET["Location"];
         $distance = $_GET["Distance"];
         $waypoint = $_GET["WayPoint"];
         $sql = "";

        if($_GET["id"] > 0)
            $sql = "UPDATE sub_route_location SET Sub_Route_ID = '".$sub_route_id."', Location_ID = '".$location_id."', Distance = '".$distance."', Way_Point = '".$waypoint."' WHERE ID = '".$_GET["id"]."';";
        else
            $sql = "INSERT INTO sub_route_location (Sub_Route_ID, Location_ID,Distance,Way_Point) VALUES ('$sub_route_id','$location_id','$distance','$waypoint')";    
         
        // Execute SQL statement 
        mysqli_query($conn,$sql);
        //echo $sql;
        header("Location: sub_route_location.php");
    }
    else if($_GET["Type"] == 'route'){
         $name = $_GET["Route_Name"];
         $no = $_GET["Route_No"];
         $location1 = $_GET["Location1"];
         $location2 = $_GET["Location2"];

         $sql = "INSERT INTO route (Route_No, Route_Name,Location_ID1,Location_ID2) VALUES ('$no','$name','$location1','$location2')";    
         
        // Execute SQL statement 
        mysqli_query($conn,$sql);
        header("Location: route.php");
    }
    else if($_GET["Type"] == 'route_sub_route'){
         $Route = $_GET["Route"];
         $Sub_Route = $_GET["Sub_Route"];
         $sql = "";

        if($_GET["id"] > 0)
            $sql = "UPDATE route_sub_route SET RouteID = '".$Route."', SubRouteID = '".$Sub_Route."' WHERE ID = '".$_GET["id"]."';";
        else
            $sql = "INSERT INTO route_sub_route (RouteID, SubRouteID) VALUES ('$Route','$Sub_Route')";    
         
        // Execute SQL statement 
        mysqli_query($conn,$sql);
        header("Location: route_sub_route.php");
    }
}
// else{
//      $sql = "INSERT INTO arduino (data_1, data_2) VALUES (0,0)";    
//     // Execute SQL statement 
//  mysqli_query($conn,$sql);
 
//    header("Location: table.php");
// }


?>