<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","school_db") or die("Connection problem.");
$dl = "";
$srn = 1;
$sql = "SELECT * FROM pins WHERE is_used=0";
$query = mysqli_query($con, $sql);
$count = mysqli_num_rows($query);
if($count > 0){
	$dl = '
		('.$count.') card are available.<br><br>
			<table width="50%" border="1" cellspacing="0" cellpadding="5">
			<tr bgcolor="silver">
				<th>S/No.</th>
				<th>Card Serial.</th>
				<th>Card Pin</th>
				<th>Date Created</th>
				
			</tr>
		
		';
	while($row = mysqli_fetch_array($query)){
		$sr = $row['serial'];
		$pn = $row['pin'];
		$date_created = $row['date_created'];
		
		
		$dl .= '
			<tr>
				<td>'.$srn++.'</td>
				<td>'.$sr.'</td>
				<td>'.$pn.'</td>
				<td>'.$date_created.'</td>
				
			</tr>
		';
	}
	$dl .= '</table>';
}else{
	$dl = 'No Record to display';
}
  
?>
<!doctype html>
<html>
	<head>
		<title>Unused Pins</title>
	</head>
	<body>
	<div>
		<a href="genpins.php">Generate Pins</a>&emsp;|&emsp;
		<a href="usedpins.php">View Used Pins</a>&emsp;|&emsp;
		<a href="unusedpins.php">View Unused Pins</a>&emsp;|&emsp;
	</div>
	<h1>Unused Pins</h1>
		<div>
			<?php echo $dl; ?>
		</div>
		<!--
		<table width="50%" border="1" cellspacing="0" cellpadding="5">
			<tr bgcolor="silver">
				<th>S/No.</th>
				<th>Card Serial.</th>
				<th>Card Pin</th>
				<th>Date Used</th>
				<th>User</th>
			</tr>
			<tr>
				<th>1</th>
				<th>12345</th>
				<th>1234567</th>
				<th>2016-6-1</th>
				<th>someone@somemail.com</th>
			</tr>
		</table>
		-->
	</body>
</html>