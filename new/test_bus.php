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
	<div>
		<table>
			<tr>
				<th>ID</th>
				<th>Reg NO</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th>Speed</th>
				<th>Last Updated</th>
			</tr>
<?php
	$sql1 = "SELECT * FROM test_bus  order by id DESC";
    $result = mysqli_query($conn,$sql1);
    
    while($row=mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo '<td>'.$row['id']."</a></td>";
		echo "<td>".$row['RegNo']."</td>";
		echo "<td>".$row['Latitude']."</td>";
		echo "<td>".$row['Longitude']."</td>";
		echo "<td>".$row['Speed']."</td>";
		echo "<td>".$row['LastUpdated']."</td>";
		echo "<tr>";
	}
?>
		</table>
	</div>
</body>
</html>