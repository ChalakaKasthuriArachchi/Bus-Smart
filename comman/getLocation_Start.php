<?php 


			include('connection.php');


				//echo "name is :".$myobj->Name;


			if(isset($_GET['subrouteid']))
			{
				$id=$_GET['subrouteid'];


				$sql="SELECT Name from location where ID = (SELECT Location_ID FROM 
				sub_route_location where Sub_Route_ID=".$id."
 				ORDER BY ID DESC LIMIT 1) limit 1; ";


				$result = $conn->query($sql);
				$row=mysqli_fetch_assoc($result);

				$myobj=new stdClass; //create empty class

				$myobj->Name=$row['Name'];
				echo json_encode($myobj);

				
			}
?> 




		