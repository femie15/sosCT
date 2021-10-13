<?php
error_reporting(0);
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
session_start();

$student_id =$_SESSION['stdid'];
$student_name = $_SESSION['stdname'];
$test_id = $_SESSION['testid'];
$duration = $_SESSION['duration'];
$starttime = $_SESSION['starttime'];
$endtime = $_SESSION['endtime'];

if(isset($_POST['qn'])){	
	
	// make local variables for the received data
	
	$qn = preg_replace('#[^0-9]#','',$_POST['qn']);
	$last = preg_replace('#[^0-9]#','',$_POST['last']);
	
	if($qn < 1){
		$qn = 1;
	}else if($qn > $last){
		$qn = $last;
	}
	
	//$last = preg_replace('#[^0-9]#','',$_POST['last']);
	//$totalRows = preg_replace('#[^0-9]#','',$_POST['totalRows']);
	
	
	
	$qlimit = 1;
	
	$limit = "LIMIT ".$qlimit." OFFSET ".($qn-1);
	
	$sql = "SELECT * FROM question WHERE testid='$test_id' $limit ";
	$query = mysqli_query($con,$sql);
	while($row = mysqli_fetch_assoc($query)){
		$qid = $row['qnid'];
		$q = $row['question'];
		$a = $row['optiona'];
		$b = $row['optionb'];
		$c = $row['optionc'];
		$d = $row['optiond'];
		$e = $row['optione'];

		//answered questions		
			$sqlk = "SELECT * FROM studentquestion WHERE stdid='$student_id' and testid='$test_id' and qnid='$qid' ";
			$queryk = mysqli_query($con,$sqlk);
			$rowk = mysqli_fetch_assoc($queryk);
			$check = $rowk['stdanswer'];
			
			if($check=="optiona"){$ckd="checked";$ckd1="";$ckd2="";$ckd3="";$ckd4="";}else
			if($check=="optionb"){$ckd="";$ckd1="checked";$ckd2="";$ckd3="";$ckd4="";}else
			if($check=="optionc"){$ckd="";$ckd1="";$ckd2="checked";$ckd3="";$ckd4="";}else
			if($check=="optiond"){$ckd="";$ckd1="";$ckd2="";$ckd3="checked";$ckd4="";}else
			if($check=="optione"){$ckd="";$ckd1="";$ckd2="";$ckd3="";$ckd4="checked";}else
			{$ckd="";$ckd1="";$ckd2="";$ckd3="";$ckd4="";}
			
		$question = '
			<h2 style="color:blue;">'.htmlspecialchars_decode($q,ENT_QUOTES).'</h2>
				<form>
					A. <input type="radio" name="qv" id="1" value="1" onchange="submitExam(this)" '.$ckd.'> <label for="1"><b>'.htmlspecialchars_decode($a,ENT_QUOTES).'</b></label><br>
					B. <input type="radio" name="qv" id="2"  value="2" onchange="submitExam(this)" '.$ckd1.'> <label for="2"> <b>'.htmlspecialchars_decode($b,ENT_QUOTES).'</b></label><br>
					C. <input type="radio" name="qv" id="3"  value="3" onchange="submitExam(this)" '.$ckd2.'> <label for="3"> <b>'.htmlspecialchars_decode($c,ENT_QUOTES).'</b></label><br>
					D. <input type="radio" name="qv" id="4"  value="4" onchange="submitExam(this)" '.$ckd3.'> <label for="4"> <b>'.htmlspecialchars_decode($d,ENT_QUOTES).'</b></label><br>
					E. <input type="radio" name="qv" id="5"  value="5" onchange="submitExam(this)" '.$ckd4.'> <label for="5"> <b>'.htmlspecialchars_decode($e,ENT_QUOTES).'</b></label><br>
					<input type="hidden" id="qid" name="qid" value="'.$qid.'">
				</form>
		
		';
		echo $question;
		//echo $check;
		
	}
	
	
}
//process submit exam
if(isset($_POST['qv'])){
	$qv = $_POST['qv'];
	$qid = $_POST['qid'];

	$sqlu = "UPDATE studentquestion SET answered='answered', stdanswer='$qv' WHERE stdid='$student_id' and testid='$test_id' and qnid='$qid' ";
	$queryu = mysqli_query($con,$sqlu);	
	
	echo "success";
	
/*if(isset($_POST['qv'])){
	$qv = $_POST['qv'];
	$qid = $_POST['qid'];
	
	
	echo "success";
	*/
}
?>
