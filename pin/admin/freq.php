<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
$cid= $sid= $count=$counts=0;
$count=$scoreadd=0;
$dlc="";
$dl = '<table border="1px" margin="0px" width="700px">
<tr>
   <td rowspan="2">Score</td>
   <td colspan="2"><center>AVERAGE MARK</center></td>
</tr>
<tr>
   <td><center>Unit</center></td>
   <td><center>Cummulative</center></td>
</tr>';
$who=$whoo=$whog='';
$cad=$cadn=$snp=$pass=$passd=$passdo=$passdg=0;
$sn=0;
$sns=1;
$ad=$fst=$snd=$thr=$fou=$score=0;
	

		$tm=1;
		$tmsch=0;
		$school_id='5';
 
		//find school name
		$sqls = "SELECT * FROM school WHERE id=$school_id";
		$querys = mysqli_query($con, $sqls);
		$rows = mysqli_fetch_array($querys);
		$schname=strtoupper($rows['name']);
		
			for ($i=100; $i >= 0; $i--) { 	             

				//DISPLAY TIME TABLE
                // $sql = "SELECT count(correctlyanswered) as numb FROM studenttest_all WHERE correctlyanswered=$i AND school_id=$school_id";
                $sql = "SELECT count(correctlyanswered) as numb FROM studenttest_all WHERE correctlyanswered=$i";
                $query = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($query);
				// $student_id=$row['stdid'];
				$score=$row['numb'];
				$scoreadd+=$row['numb'];

//FOR STUDENTS THAT WAS ASSIGNED ANOTHER NUMBER.
				$dl .= '<tr>
				<td>'.$i.'</td>
				<td>'.$score.'</td>
				<td>'.$scoreadd.'</td>
						</tr>';
            
		}
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
   <td>90 and ABOVE</td>
   <td><?php echo $passdg;?></td>
</tr>
<tr>
   <td>100</td>
   <td><?php echo $passdo;?></td>
</tr>
</table>
</center>  -->

<!doctype html>
<html>
	<head>
		<title>Unused Pins</title>
		<style>
            /* body{
                background-image:url('oyologo.jpg');
                background-repeat: no-repeat;
                background-size: contain;
            } */
			div {
				float: left;
				font-family: courier;
				size: 8px;
			}
			#sch {
				position: absolute;
				margin-top: -162px;
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
COMPETITIVE ENTRANCE EXAMINATION INTO SCHOOLS OF SCIENCE
2021/2022 ACADEMIC SESSION <br/>
			FREQUENCY DISTRIBUTION: <?php //echo $schname;?>
			</h3>
	</center> 

	<br>
	<div style="float:center;">

	<?php echo $dl; ?> <br>
	<?php  // echo $dlc; ?>
	</div>
	</body>
</html>