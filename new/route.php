<?php include('../comman/connection.php'); ?>
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
	<?php include('index.php'); ?>
	<br><br>

	<form action="submit.php" method="get">
		<table>
			
			<tr>
				<td>span Type </span></td>
				<td> <input type="text" name="Type" value="route" readonly></td>
			</tr>
		
			<tr>
				<td><span>Route No</span></td>
				<td><input type="text" name = "Route_No"></td>
			</tr>
		
			<tr>
		
				<td> <span>Route Name</span></td>
				<td><input type="text" name = "Route_Name"></td>
			</tr>

			<tr>
				<td><span>From</span></td>
				<td>
					<select id="country" name="Location1">
						<?php
							$sql1 = "SELECT * FROM location Order by Name";
						    $result = mysqli_query($conn,$sql1);

						    while($row=mysqli_fetch_assoc($result)){
									echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
							}
						?>
				</select></td>
			</tr>

			<tr>
				<td><span>To</span></td>
				<td>
					<select id="country" name="Location2">
						<?php
							$sql1 = "SELECT * FROM location Order by Name";
						    $result = mysqli_query($conn,$sql1);

						    while($row=mysqli_fetch_assoc($result)){
									echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
							}
						?>
				</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" name=""></td>
				<td><input type="reset" name=""></td>
			</tr>
		</table>
	</form>


	<div>
		<table>
			<tr>
				<th>ID</th>				
				<th>Route No</th>
				<th>Route Name</th>
				<th>Location1</th>
				<th>Location2</th>
			</tr>
<?php
	$stmt = $conn->prepare("SELECT route.ID as ID,Route_No,Route_Name,Name,Type FROM route INNER JOIN location ON Location_ID1 = location.ID OR Location_ID2 = location.ID".";");
    $stmt->execute();
	$result = $stmt->get_result();
    $count = 0;
    
    while($row=mysqli_fetch_assoc($result)){
    	if($count % 2 == 0){
			echo "<tr>";
			echo "<td>".$row['ID']."</td>";
			echo "<td>".$row['Route_No']."</td>";
			echo '<td><a href="test_route.php?Route_ID='.$row['ID'].'">'.$row['Route_Name']."</a></td>";
			echo "<td>".$row['Name']."</td>";
			
		}
		else{
			echo "<td>".$row['Name']."</td>";
			echo "<tr>";
		}
		$count++;
	}
?>
		</table>
	</div>
</body>
</html>