<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
$schname=$dl = $snp = $cid= $sid= "";
$numb=0;
$sns=1;

$ssd=8; //SCHOOL ID

//DISPLAY TIME TABLE
$sql = "SELECT * FROM studenttest_all WHERE (school_id=$ssd AND correctlyanswered>=35) || (school_id=1 AND correctlyanswered=59) || (school_id=7 AND (correctlyanswered<=54 AND correctlyanswered>=51))";

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
	
		// $snp++;
		//find school name
		// if ($sid==$ssd) {
		$sqlsa = "SELECT * FROM school WHERE id=$ssd";
		$querysx = mysqli_query($con, $sqlsa);
		$rowsx = mysqli_fetch_array($querysx);
		$schname=$rowsx['name'];
	// }

//FOR STUDENTS THAT WAS ASSIGNED ANOTHER NUMBER.

		$dl .= '<div  style="width:100%;margin-bottom:5px; height:9.1cm; page-break-inside: avoid; border: 2px solid brown;">
		<table width="100%" border="0" style="font-weight:bold;">	
			<tr>
				<td >
					<img src="../../images/oyo.jpg" width="70px">
			   </td>
				<td colspan="2">
				<div style="margin-top:-7px; font-size:20px; font-family:ubuntu; background-color: green; color:#ffffff; border-radius:50px;">
				<center><b>
   OYO STATE MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY. <br>ADMISSION INTO SCHOOLS OF SCIENCE</b>
   </center>
   </div>
				</td>
			</tr>
			<tr>
					<td></td>
				<td>
					   <b style="color:brown; font-family:ubuntu; font-size:20px; float:right;"><center>
							ADMISSION SLIP 
					   </center></b> 
				</td>
				<td style="float:right;color:brown;">
						SESSION: 2021/2022
				</td>
			</tr>		
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>
			<tr>
				<td>
				   Form/Adm No:
				</td>
				<td colspan="2">'.$roll.' / '.$sns++.'</td>
		   </tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>

			<tr>
				<td>
				   Candidate\'s Name:
				</td>
				<td colspan="2">'.$name.'</td>
		   </tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>
   <tr><td></td><td></td><td></td></tr>


		   <tr>
				<td>
					Admitted Into:
				</td>
				<td colspan="2">'.$schname.' </td>
			</tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td></tr>
   
			<tr>
					<td></td>
				<td>
					   <b style="color:brown; font-family:ubuntu; font-size:20px; float:right;"><center>
						   Congratulations 
					   </center></b> 
				</td>
				<td style="color:brown;">
				<img src="../../images/atere.jpg" width="120px" height="30px" style=" margin-left:20px;  margin-bottom:-17px;"><br>
						------------------
						<br>
						Permanent Secretary
				</td>
			</tr>
			</table>
	   </div>';
	
				
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
				/* background-color: #fff; */

			}
			#sch{
				position: absolute;
				margin-top: -162px;
				font-size:7px;
			}
			#pn {
				position: absolute;
				margin-top: 132px;
				margin-left: 90px;
				font-size:10px;
			}
			#sr {
				position: absolute;
				margin-top: 111px;
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
				margin-top: 54px;
				margin-left: 90px;
			}
			#test {
				position: absolute;
				margin-top: 24px;
				margin-left: 3px;
				font-size:9px;
			}
		</style>
	</head>
	<body>
	<?php echo $dl; ?>
	<br>
	<?php //echo $numb;?>
	

	
	
	</body>
</html>