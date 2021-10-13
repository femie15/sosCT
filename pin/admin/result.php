<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oesogbomosho2_") or die("Connection problem.");
$cid= $sid= $count=$counts=0;
$count=0;
$dl = '<table border="1px" margin="0px">
<tr>
   <td rowspan="2">S/N</td>
   <td colspan="5"><center>STUDENTS RESULT</center></td>
</tr>
<tr>
   <td>Name</td>
   <td>Exam Number</td>
   <td><center>School</center></td>
   <td>SCORE</td>
</tr>';
$who=$whoo=$whog='';
$cad=$cadn=$snp=$pass=$passd=$passdo=$passdg=0;
$sn=0;
$sns=1;
$ad=$fst=$snd=$thr=$fou=0;
	
			

		//DISPLAY TIME TABLE
		$sql = "SELECT * FROM studenttest";
		// $sql = "SELECT * FROM candidates WHERE school_id='1'";
		// $sql = "SELECT * FROM candidates WHERE school_id='1' ORDER BY school_id";
		$query = mysqli_query($con, $sql);
		$tm=1;
		$tmsch=0;


			while($row = mysqli_fetch_array($query)){	
				$student_id=$row['stdid'];

				//CANDIDATES DETAILS
				$sqlk = "SELECT * FROM candidates WHERE id=$student_id";
				$queryk = mysqli_query($con, $sqlk);
				$rowk = mysqli_fetch_array($queryk);

				$roll=$rowk['exam_no'];
				$sid=$rowk['school_id'];
				$name = strtoupper($rowk['name']);

				//SELECT STUDENTS ANSWERS
				$sqlsq = "SELECT * FROM studentquestion WHERE stdid=$student_id";
				$querysq = mysqli_query($con,$sqlsq);


				//find school name
				$sqls = "SELECT * FROM school WHERE id=$sid";
				$querys = mysqli_query($con, $sqls);
				$rows = mysqli_fetch_array($querys);
		
				//find center name based on exam number
				//$cid=$roll[0];
				// $sqlc = "SELECT * FROM center WHERE id=$cid";
				// $queryc = mysqli_query($con, $sqlc);
				// $rowc = mysqli_fetch_array($queryc);					
		
				
				//$cent = strtoupper($rowc['name']);
				//$dt = "RESULT";
				


				//nunmber of correct answers START				
	while($rowsq = mysqli_fetch_assoc($querysq)){
			$qid = $rowsq['qnid'];
			$stdanswer = $rowsq['stdanswer'];

		//SELECT QUESTIONS
		$sqlq = "SELECT * FROM question WHERE qnid='$qid' ";
	$queryq = mysqli_query($con,$sqlq);
	$rowq = mysqli_fetch_assoc($queryq);
	$ca = $rowq['correctanswer'];

			
				// $sqlsq = "SELECT * FROM studentquestion WHERE stdid='$student_id' and qnid='$qid' ";
				// $querysq = mysqli_query($con,$sqlsq);
				// $rowsq = mysqli_fetch_assoc($querysq);
			//updating
				if($stdanswer==$ca){
			// $sqlz = "SELECT * FROM studenttest WHERE testid='2' and qnid='$qid' ";
			// $queryz = mysqli_query($con,$sqlz);
			// $rowz = mysqli_fetch_assoc($queryz);
			// $cad = $rowz['correctlyanswered'];
			$cad=$cad+1;
				}
				$cadn=$cadn+1;
	}
	

if ($cadn>=1) {
$snp=$snp+1;
				//upgrade
				$cad=$cad+15;
//SAVE THE TOTAL SCORE
		$sqlc = "UPDATE studenttest SET correctlyanswered='$cad' WHERE stdid='$student_id' and testid='2' ";
		$queryc = mysqli_query($con,$sqlc);	
//nunmber of correct answers END

				$dl .= '<tr>
				<td>'.$sns++.'</td>
				<td>'.$name.'</td>
				<td>'.$roll.'</td>
				<td>'.$rows['name'].'</td>
				<td>'.$cad.'/'.$cadn.'</td>
						</tr>';
			if ($cad>=1) {

						
						if ($cad>=50 && $cad<=79) {
							$pass=$pass+1;
						}elseif ($cad>=80 && $cad<=89) {
							$passd=$passd+1;
							$who.=$roll.'-'.$cad.'<br/>';
						}elseif ($cad>=90 && $cad<=99) {
							$passdg=$passdg+1;
							$whog.=$roll.'-'.$cad.'<br/>';
						}elseif($cad>=100){
							$passdo=$passdo+1;
							$whoo.=$roll.'-'.$cad.'<br/>';
						}
			}
				
						$cad=0;
						$cadn=0;
			}
		}
			// echo $pass."/".$snp;
?>

<center> 
<table border="1px" margin="0px">
<tr>
   <td>TOTAL CANDIDATES</td>
   <td><?php echo $snp;?></td>
</tr>
<tr>
   <td>ABOVE AVERAGE</td>
   <td><?php echo $pass;?></td>
</tr>
<tr>
   <td>80 and ABOVE</td>
   <td><?php echo $passd;?></td>
</tr>
<tr>
<td colspan="2"><?php echo $who;?></td>
</tr>
<tr>
   <td>90 and ABOVE</td>
   <td><?php echo $passdg;?></td>
</tr>
<tr >
<td colspan="2"><?php echo $whog;?></td>
</tr>
<tr>
   <td>100</td>
   <td><?php echo $passdo;?></td>
</tr>
<tr>
<td colspan="2"><?php echo $whoo;?></td>
</tr>
</table>
</center> 

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
				STUDENTS RESULT
			</h1>
	</center> 

	<br>
	<div style="float:center;">

	<?php echo $dl; ?>
	</div>
	</body>
</html>