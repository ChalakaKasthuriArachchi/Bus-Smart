<?php 
	include('../comman/connection.php');
	include('../comman/db_functions.php');
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
	<?php 
		include('index.php'); 
		$id = 0;
		$Route_ID = 0;
		$Sub_Route_ID = 0;

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			include('../comman/connection.php');
			$stmt = $conn->prepare("SELECT * FROM route_sub_route WHERE ID='".$id."';");
	    	$stmt->execute();
			$result = $stmt->get_result();
			$row = mysqli_fetch_assoc($result); 
			$Route_ID = $row['RouteID'];
			$Sub_Route_ID = $row['SubRouteID'];
		}
	?>
	<br><br>
	<form action="submit.php" method="get">


		<table>
			
			<tr>
				<td><span> Type </span></td>
				<td><input type="text" name="Type" value="route_sub_route" readonly></td>
			</tr>
			<tr>
				<td><span> ID : </span></td>
				<td><input type="text" name = "id" value=<?php echo '"'.$id.'"'; ?> readonly ></td>
			</tr>

			<tr>
				<td><span>Route : </span></td>
				<td>
					<select id="country" name="Route">
						<?php
							$sql1 = "SELECT * FROM route Order by Route_No";
						    $result = mysqli_query($conn,$sql1);

						    while($row=mysqli_fetch_assoc($result)){
									echo '<option value="'.$row['ID'].'" '.($row['ID'] == $Route_ID ? "selected" : "").'>'.$row['Route_No'].' | '.$row['Route_Name'].'</option>';
							}
						?>
				</select>
				</td>
			</tr>

			<tr>
				<td><span>Sub Route : </span></td>
				<td>
					
				<select id="country" name="Sub_Route">
					<?php
					    $SubRouteName = "";
					    $IsNew = 1; 
					    $Location;
					    $SubRouteID = 0;
					    $result = get_SubRoute_Details();
					    $row;
					    while($row=mysqli_fetch_assoc($result)){
							if($SubRouteID != 0 && $SubRouteID != $row['Sub_Route_ID']){
								echo '<option value="'.$SubRouteID.'" '.($SubRouteID == $Sub_Route_ID ? "selected" : "").'>'.$SubRouteName.' - '.$Location.'</option>';		
								$SubRouteName = "";
								$IsNew = 1;
							}
							if($IsNew == 1){
								$SubRouteID = $row['Sub_Route_ID'];
								$SubRouteName = $row['Name'];
								$IsNew = 0;
							}
							else{
								$Location = $row['Name'];
							}
							
							$SubRouteID = $row['Sub_Route_ID'];
						}
						if($SubRouteID != 0){
							echo '<option value="'.$SubRouteID.'" '.($SubRouteID == $Sub_Route_ID ? "selected" : "").'>'.$SubRouteName.' - '.$Location.'</option>';
						}
					?>
			</select>
				</td>
			</tr>

			<tr>
				<td><input type="submit" name="">	
				<td><input type="reset" name=""></td></td>
			</tr>
		</table>
		
	</form>

<br><br>
	<div>
		<table>
			<tr>
				<th>ID</th>
				<th>Route No</th>
				<th>Route Name</th>
				<th>Sub Route</th>
				<th>Distance</th>
			</tr>
<?php
	
    $ID = 0;
    $SubRouteName = "";
    $Distance = 0;
    $Route_No; $Route_Name; $Location ;$IsNew = 1; 
    $result = get_RouteSubRoute_Details();
    $RouteID;
    $Sub_Route_ID;
    while($row=mysqli_fetch_assoc($result)){
    	$RouteID = $row['RouteID'];
		if($ID != 0 && $ID != $row['ID']){
			echo "<tr>";
			echo '<td><a href="route_sub_route.php?id='.$ID.'">'.$ID."</td>";
			echo "<td>".$Route_No."</td>";
			echo '<td><a href="test_route.php?Route_ID='.$RouteID.'">'.$Route_Name."</a></td>";
			echo '<td><a href="test_sub_route.php?Sub_Route_ID='.$Sub_Route_ID.'">'.$SubRouteName.'-'.$Location."</td>";
			echo "<td>".$Distance."</td>";
			echo "<tr>";
			$SubRouteName = "";
			$Distance = 0;
			$IsNew = 1;
		}
		if($IsNew == 1){
			$RouteID = $row['ID'];
			$Route_No = $row['Route_No'];
			$Route_Name = $row['Route_Name'];
			$SubRouteName = $row['Location'];
			$Sub_Route_ID = $row['Sub_Route_ID'];
			$IsNew = 0;
		}
		else{
			$Location = $row['Location'];
		}
		
		$ID = $row['ID'];
		$Distance += $row['Distance'];
	}
	if($ID != 0){
		echo "<tr>";
			echo '<td><a href="route_sub_route.php?id='.$ID.'">'.$ID."</td>";
			echo "<td>".$Route_No."</td>";
			echo '<td><a href="test_route.php?Route_ID='.$RouteID.'">'.$Route_Name."</a></td>";
			echo '<td><a href="test_sub_route.php?Sub_Route_ID='.$Sub_Route_ID.'">'.$SubRouteName.'-'.$Location."</td>";
			echo "<td>".$Distance."</td>";
			echo "<tr>";
	}
?>
		</table>
	</div>
</body>
</html>