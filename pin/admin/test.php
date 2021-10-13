<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","school_db") or die("Connection problem.");
$dl = "";
$sql = "SELECT * FROM pins WHERE is_used = 0 LIMIT 8";
$query = mysqli_query($con, $sql);
$count = mysqli_num_rows($query);
if($count > 0){
	while($row = mysqli_fetch_array($query)){
		$sr = $row['serial'];
		$pn = $row['pin'];
		
		$dl .= '
			<div style="width:325px; height:205px; border: 1px solid black">
				<img src="../images/sc3.jpg" width="100%">
				<div id="sr">Serial: '.$sr.'</div>
				<div id="pn">Pin: '.$pn.'</div>
			</div>
		';
	}
	
}else{
	$dl = 'No card has been used';
}
?>
<!doctype html>
<html>
	<head>
		<title>Unused Pins</title>
		<style>
			div {
				float: left;
				font-family: courier;
				size: 8;
			}
			#sr {
				position: absolute;
				margin-top: -80px;
				margin-left: 30px;
			}
			#pn {
				position: absolute;
				margin-top: -60px;
				margin-left: 30px;
			}
		</style>
	</head>
	<body>
	<?php echo $dl; ?>
	<!--
	<div style="width:325px; height:205px; border: 1px solid black">
		<img src="../images/sc.jpg" width="100%">
		<div id="sr">Serial: 12345</div>
		<div id="pn">Pin: 1234567</div>
	</div>
	-->
	</body>
</html>