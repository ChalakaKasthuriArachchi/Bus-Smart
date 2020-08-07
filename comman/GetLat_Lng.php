<?php

include('connection.php');
// $Start=$_GET['Start'];
// $End=$_GET['End'];

// $sql="SELECT Latitude,Longitude FROM id10834767_mydb.location 
//   where( Name='".$Start."' or Name='".$End."');";

// $result=$conn->query($sql);
// $myobg=new stdClass(); //create empty clss
//  $x=1;
// while($row=mysqli_fetch_assoc($result))
// {
//     if($x==1)
//     {
//         $myobg->StartLat=$row['Latitude'];
//         $myobg->StartLng=$row['Longitude'];
//         $x++;
//     }
//     else
//     {
//         $myobg->Endlat=$row['Latitude'];
//         $myobg->EndLng=$row['Longitude'];
//     }
    
   
// }

// echo json_encode($myobg);

if(isset($_GET['Start']) && isset($_GET['End']))
{
    $Start=$_GET['Start'];
    $End=$_GET['End'];


    $sql="SELECT Latitude,Longitude FROM id10834767_mydb.location 
    where( Name='".$Start."' or Name='".$End."');";

        $result=$conn->query($sql);
        $myobg=new stdClass(); //create empty clss
        $x=1;
        while($row=mysqli_fetch_assoc($result))
        {
            if($x==1)
            {
                $myobg->EndLat=$row['Latitude'];
                $myobg->EndLng=$row['Longitude'];
                $x++;
            }
            else
            {
                $myobg->StartLat=$row['Latitude'];
                $myobg->StartLng=$row['Longitude'];
            }           
        }
        echo json_encode($myobg);

}



?>