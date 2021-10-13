<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
$cid= $sid= $count=$counts=0;
$count=0;
$dl = '<center><table border="1px" margin="0px">
<tr>
   <td rowspan="2">S/N</td>
   <td colspan="6"><center>TIME TABLE</center></td>
</tr>
<tr>
   <td>Name</td>
   <td>Exam Number</td>
   <td><center>Exam Center</center></td>
   <td>Exam Time</td>
</tr>';
$dlc = '<center> <table border="1px" margin="0px">
<tr>
   <td rowspan="2">Center No</td>
   <td colspan="6"><center>Candidates population</center></td>
</tr>
<tr>
<td>Center Name</td>
<td>7:30 am</td>
<td>9:30 am</td>
<td>11:30 am</td>
<td>1:30 pm</td>
   <td>Total</td>
</tr>';

$sn=0;
$sns=1;
$ad=$fst=$snd=$thr=$fou=0;

$sqlcnd = "SELECT * FROM center";
				$querycnd = mysqli_query($con, $sqlcnd);
	while($rowcnd = mysqli_fetch_array($querycnd)){
//for ($i=1; $i < 8; $i++) { 
	$i=$rowcnd['id'];

	$sqlc = "SELECT * FROM candidates";
	$queryc = mysqli_query($con, $sqlc);
		
		while($rowc = mysqli_fetch_array($queryc))
		{ 			
				$ic=$rowc['exam_no'];
				$tmc=$rowc['exam_time'];
				$icn=$ic[0];

			if ($icn==$i) {
				$ad++;

				$sqlcn = "SELECT * FROM center WHERE id=".$i;
				$querycn = mysqli_query($con, $sqlcn);
				$rowcn = mysqli_fetch_array($querycn);				
			
				if ($tmc=='7:30 am') {
					$fst++;
				}elseif ($tmc=='9:30 am') {
					$snd++;
				}elseif ($tmc=='11:30 am') {
					$thr++;
				}elseif ($tmc=='1:30 pm') {
					$fou++;
				}
			}	
				
		}
		
			$dlc .= '<tr>
				<td>'.$i.'</td>
				<td>'.$rowcn['name'].'</td>
				<td>'.$fst.'</td>
				<td>'.$snd.'</td>
				<td>'.$thr.'</td>
				<td>'.$fou.'</td>
				<td>'.number_format($ad).'</td>
			</tr>';
			$count+=$ad;
			$ad=$fst=$snd=$thr=$fou=0;
	}
  
	$dlc .= '<tr>
			<td colspan="6">Total Number of candidates</td>
			<td>'.number_format($count).'</td>
		</tr>
		</table>			
		</center>';

		//DISPLAY TIME TABLE
		// $sql = "SELECT * FROM candidates";
		$sql = "SELECT * FROM candidates WHERE id=$id AND id>='4223' AND id<='4524'";
		$query = mysqli_query($con, $sql);
		$tm=1;
		$tmsch=0;
			while($row = mysqli_fetch_array($query)){
				$id=$row['id'];
				$roll=$row['exam_no'];
				//find school name
				$sid=$row['school_id'];
				$sqls = "SELECT * FROM school WHERE id=$sid";
				$querys = mysqli_query($con, $sqls);
				$rows = mysqli_fetch_array($querys);
		
				//find center name based on exam number
				$cid=$roll[0];
				$sqlc = "SELECT * FROM center WHERE id=$cid";
				$queryc = mysqli_query($con, $sqlc);
				$rowc = mysqli_fetch_array($queryc);					
		
				$name = strtoupper($row['name']);
				$cent = strtoupper($rowc['name']);
				//$exam = $row['exam_no']; //original
				$exam1 = $rowc['id'].$row['school_id'].$row['id'];
				$dt = $row['exam_time'];
				
				//update exam number
				// $sqlcst = "UPDATE candidates SET exam_no=$exam1 WHERE id=$id AND id>='4223' AND id<='4524'";
				// $querycst = mysqli_query($con, $sqlcst);
				

				// $sqlcstd = "UPDATE candidates SET exam_time=".$dt." WHERE id=".$id;
				// $querycstd = mysqli_query($con, $sqlcstd);
				
				$dl .= '<tr>
						<td>'.$sns++.'</td>
						<td>'.$name.'</td>
						<td>'.$roll.'_'.$exam1.'</td>
						<td>'.$cent.'</td>
						<td>'.$dt.'</td>
						</tr></center>';
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
				margin-top: -112px;
				margin-left: 90px;
				font-size:10px;
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
		</style>
	</head>
	<body>
	
	<center>
			<h1>
				STUDENT TIME TABLE
			</h1>
	</center>

	<br>
	<?php echo $dlc; ?>
	<br>
	<div>
	<?php echo $dl; ?>
	</div>
	</body>
</html>