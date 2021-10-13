<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
$cid= $sid= $count=$counts=0;
$count=0;
$dl = '<center> <table border="1px" margin="0px">
<tr>
   <td rowspan="2">Center No</td>
   <td colspan="5"><center>School population</center></td>
</tr>
<tr>
   <td colspan="4">Name</td>
   <td>Total</td>
</tr>';
$dlc = '<center> <table border="1px" margin="0px">
<tr>
   <td rowspan="2">Center No</td>
   <td colspan="5"><center>Candidates population</center></td>
</tr>
<tr>
   <td  colspan="4">Center Name</td>
   <td>Total</td>
</tr>';


$sqls = "SELECT * FROM school";
$querys = mysqli_query($con, $sqls);

while($rowq = mysqli_fetch_array($querys))
{ 
		$i=$rowq['id'];
		$sqlq = "SELECT * FROM candidates WHERE school_id=".$i;
		$queryq = mysqli_query($con, $sqlq);
		$counts= mysqli_num_rows($queryq);
		$dl .= '<tr>
                    <td>'.$i.'</td>
                    <td colspan="4">'.$rowq['name'].'</td>
                    <td>'.number_format($counts).'</td>
                </tr>';
		$count+=$counts;
}
$sn=0;
$ad=0;

// $sqlc = "SELECT * FROM center";
// $queryc = mysqli_query($con, $sqlc);
for ($i=1; $i < 8; $i++) { 

		$sqlc = "SELECT * FROM candidates";
		$queryc = mysqli_query($con, $sqlc);
		while($rowc = mysqli_fetch_array($queryc))
		{ 			
				$ic=$rowc['exam_no'];
				$icn=$ic[0];

			if ($icn==$i) {
				$ad++;
				$sqlcn = "SELECT * FROM center WHERE id=".$i;
				$querycn = mysqli_query($con, $sqlcn);
				$rowcn = mysqli_fetch_array($querycn);				
			}
				
		}
		
			$dlc .= '<tr>
				<td>'.$i.'</td>
				<td colspan="4">'.$rowcn['name'].'</td>
				<td>'.number_format($ad).'</td>
			</tr>';
			$ad=0;
	}
  
     $dl .= '<tr>
				<td colspan="5">Total Number of candidates</td>
				<td>'.number_format($count).'</td>
            </tr>
            </table>			
            </center>';
  
	$dlc .= '<tr>
			<td colspan="5">Total Number of candidates</td>
			<td>'.number_format($count).'</td>
		</tr>
		</table>			
		</center>';
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
	<?php echo $dl; ?>
	<br><br>
	<?php echo $dlc; ?>
	</body>
</html>