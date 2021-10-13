<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
$dl = $cid= $sid= "";
$numb=0;
// $sql = "SELECT * FROM candidates WHERE school_id='7' ORDER BY rand() LIMIT 53";
 $sql = "SELECT * FROM candidates WHERE exam_no='374742'";
//$sql = "SELECT * FROM candidates ORDER BY school_id";
$query = mysqli_query($con, $sql);
//$count = mysqli_num_rows($query);
//if($count > 0){
	while($row = mysqli_fetch_array($query)){
		$numb++;
		$id=$row['id'];
		$roll=$row['exam_no'];
		//find school name
		$sid=$row['school_id'];
		$sqls = "SELECT * FROM school WHERE id=$sid";
		$querys = mysqli_query($con, $sqls);
		$rows = mysqli_fetch_array($querys);

		//find center name based on school
		$cid=$roll[0];
		$sqlc = "SELECT * FROM center WHERE id=$cid";
		$queryc = mysqli_query($con, $sqlc);
		$rowc = mysqli_fetch_array($queryc);

		$name = strtoupper($row['name']);
		$cent = strtoupper($rowc['name']);
		$exam = $row['exam_no'];
		// $exam = $rowc['id'].$row['school_id'].$row['id'];
		//$exam1 = '3'.$row['school_id'].$row['id'];
		$dt = $row['exam_time'];
		
		//update exam number
		// $sqlcst = "UPDATE candidates SET exam_no=$exam WHERE id=$id";
		// $querycst = mysqli_query($con, $sqlcst);
		
		// $sqlcst = "UPDATE candidates SET exam_no=$exam1 WHERE id=$id";
		// $querycst = mysqli_query($con, $sqlcst);

		$dl .= '
			<div style="width:325px; height:205px; border: 1px solid black">
				<img src="card.jpg" width="100%">
				<!--<div id="sch">'.$rows['name'].'</div>-->
				<div id="pn" style="width:150px;"><b>'.$name.'</b></div>
				<div id="sr"><b>'.$exam.'</b></div>
				<div id="who" style="width:300px;"><br/><b>'.$cent.'</b></div>
				<div id="dt"><b>'.$dt.'</b></div>
				<div id="test"><b>Practice at www.oyoedu.ng/cbt</b></div>
			</div>
		';
 	}
	
// }else{
// 	$dl = 'No card has been used';
// }
?>
<!doctype html>
<html>
	<head>
		<title>Unused Pins</title>
		<style>
			div {
				float: left;
				font-family: courier;
				size: 8px;
			}
			#sch {
				position: absolute;
				margin-top: -162px;
				/* margin-left: 40px; */
				font-size:7px;
			}
			#pn {
				position: absolute;
				margin-top: -132px;
				margin-left: 90px;
				font-size:10px;
			}
			#sr {
				position: absolute;
				margin-top: -111px;
				margin-left: 90px;
				font-size:19px;
			}
			#who {
				position: absolute;
				margin-top: -90px;
				margin-left: 3px;
				font-size:10px;
			}
			#dt {
				position: absolute;
				margin-top: -54px;
				margin-left: 90px;
			}
			#test {
				position: absolute;
				margin-top: -24px;
				margin-left: 3px;
				font-size:9px;
			}
		</style>
	</head>
	<body>
	<?php echo $dl; ?>
	<br>
	<?php echo $numb;?>
	<!--
	<div style="width:325px; height:205px; border: 1px solid black">
		<img src="../images/sc.jpg" width="100%">
		<div id="sr">Serial: 12345</div>
		<div id="pn">Pin: 1234567</div>
	</div>
	-->
	</body>
</html>