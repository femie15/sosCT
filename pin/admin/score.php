<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes_") or die("Connection problem.");
$cid= $sid= $count=$counts=0;
$count=0;
$dl = '<center><table border="1px" margin="0px" width="100%">
<tr>
   <td rowspan="2">Adm No</td>
   <td colspan="7"><center>ADMITTED CANDIDATES</center></td>
</tr>
<tr>
   <td colspan="2">Name</td>
   <td colspan="2">Exam Number</td>
  <!-- <td>School</td>
   <td>Score</td>-->
</tr>';
$who=$whoo=$whog='';
$cad=$cadn=$snp=$pass=$passd=$passdo=$passdg=0;
$sn=0;
$sns=1;
$ad=$fst=$snd=$thr=$fou=$score=0;
	
			$ssd=7;

		//DISPLAY TIME TABLE
		$sql = "SELECT * FROM studenttest_all WHERE (school_id=$ssd AND correctlyanswered=59) ";
		// $sql = "SELECT * FROM studenttest_all WHERE (school_id=$ssd AND correctlyanswered>=35) || (school_id=1 AND correctlyanswered=59) || (school_id=7 AND (correctlyanswered<=54 AND correctlyanswered>=51))";

		$query = mysqli_query($con, $sql);
		$tm=1;
		$tmsch=0;

			while($row = mysqli_fetch_array($query)){	
				$student_id=$row['stdid'];
				$score=$row['correctlyanswered'];

				//CANDIDATES DETAILS
				$sqlk = "SELECT * FROM candidates WHERE id=$student_id";
				$queryk = mysqli_query($con, $sqlk);
				$rowk = mysqli_fetch_array($queryk);

				$roll=$rowk['exam_no'];
				$sid=$rowk['school_id'];
				$name = strtoupper($rowk['name']);
			
				$snp++;
				//find school name
				// if ($sid==$ssd) {
				$sqls = "SELECT * FROM school WHERE id=$ssd";
				$querys = mysqli_query($con, $sqls);
				$rows = mysqli_fetch_array($querys);
				$schname=$rows['name'];
			// }
// $snp=$snp+1;

//FOR STUDENTS THAT WAS ASSIGNED ANOTHER NUMBER.

				$dl .= '<tr>
				<td>'.$sns++.'</td>
				<td colspan="2">'.$name.'</td>
				<td colspan="2">'.$roll.'</td>
						</tr>';
			
						
		}
		$dl.='</table> </center>'
?>

<!-- <center> 
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
</center>  -->

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
	<h3>
			MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY, OYO STATE.
ADMISSION LIST INTO SCHOOLS OF SCIENCE
2021/2022 ACADEMIC SESSION <br/>
			<?php echo strtoupper($schname);?>
			</h3>
				<!-- STUDENTS RESULT -->
			
	</center> 

	<br>
	<!-- <div style="float:center;"> -->

	<?php echo $dl; ?>
	<!-- </div> -->
	</body>
</html>