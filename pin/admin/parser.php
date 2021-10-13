<?php
	$con = mysqli_connect("localhost","root","","school_db");
	$questions = "";
	
	//save new exam questions
	if(isset($_POST['a'])){
		$q = $_POST['question'];
		$cid = $_POST['course_id'];
		$a = $_POST['a'];
		$b = $_POST['b'];
		$c = $_POST['c'];
		$d = $_POST['d'];
		$cr = $_POST['correct'];
		
		$sql = "INSERT INTO exam_tbl VALUES('','$cid','$q','$a','$b','$c','$d','$cr')";
		$query = mysqli_query($con,$sql);
		
		
	}
	
	
	if(isset($_POST['course_id'])){
		$cs = $_POST['course_id'];
		$course = "";
		if($cs == 1){
			$course = "HTML"; 
		}else if($cs == 2){
			$course = "CSS";
		}else if($cs == 3){
			$course = "PHP";
		}else if($cs == 4){
			$course = "MySQL";
		}
		
	$sql = "SELECT * FROM exam_tbl WHERE course_id='$cs'";
	$query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($query);
	if($count < 1){
		$questions = "No Questions added for this course.";
	}else{
		$sr = 1;
		while($row = mysqli_fetch_assoc($query)){
			$q = $row['question'];
			$a = $row['a'];
			$b = $row['b'];
			$c = $row['c'];
			$d = $row['d'];
			$cr = $row['correct'];
			
			$questions .="<b>".$sr++.". ". $q."</b><br>";
			$questions .="&emsp; A. ".$a."<br>";
			$questions .="&emsp; B. ".$b."<br>";
			$questions .="&emsp; C. ".$c."<br>";
			$questions .="&emsp; D. ".$d."<br><br>";
			$questions .="&emsp; Correct. <i>".$cr."</i><hr>";
		}
	} 
	
	
		if($cs != ""){
			$form = '
				<table width="100%" cellpadding="20px">
				<tr valign="top">
				<td width="35%">
				<h2 style="padding: 0px; margin: 0px;">Add Question for '.$course.'</h2>
				<form method="post" action="parser.php">
					<textarea name="question" style="width:100%; height:100px;"></textarea><br><br>
					A.<input type="text" name="a" style="width:100%;"><br><br>
					B.<input type="text" name="b" style="width:100%;"><br><br>
					C.<input type="text" name="c" style="width:100%;"><br><br>
					D.<input type="text" name="d" style="width:100%;"><br><br>
					<input type="hidden" name="course_id" value='.$cs.'>
					Correct<select style="width:100%;" name="correct">
						<option value=""></option>
						<option value="a">a</option>
						<option value="b">b</option>
						<option value="c">c</option>
						<option value="d">d</option>
					</select><br><br>
					<button onclick="submitForm()">Save and New...</button>&emsp;<button onclick="window.location(\"index\")>Done!</button>
				</form>
				</td>
				<td width="65%" style="padding-left: 10px;">
					<div id="q" style="height: 80vh; overflow:auto; width: 100%; background: #fff; padding: 10px; border: 1px solid #ccc;">
					<h2 style="padding:0px; margin: 0px;">('.$count.') Questions Added So far</h2><br>
					'.$questions.'
					
					</div>
				</td>
				</tr>
				</table>
			';
		}
		echo $form;
		
	}
	
	//SEARCH FOR STUDENT
	if(isset($_POST['st'])){
		$st =  $_POST['st'];
		$result = "";
		
		$con = mysqli_connect("localhost","root","","school_db");
		
		$sql = "SELECT * FROM students_tbl WHERE firstname LIKE '%$st%' OR lastname LIKE '%$st%' OR email LIKE '%$st%'";
		$query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($query);
		if($count == 0){
			echo "No record found.";
		}else if($count < 2){
			
			$result .= '
				<h2>Search Result</h2>
				<table width=100% style="border:2px solid #ccc; font-size: 150%; color: #666; padding: 20px; background: #fff;">
				
			';
			
			while($row = mysqli_fetch_assoc($query)){
				$id = $row['id'];
				$fn = $row['firstname'];
				$ln = $row['lastname'];
				$pn = $row['phoneno'];
				
				$pic = "dimg.jpg";
				if(file_exists('../s/'.$id.'.jpg')){
					$pic = "$id.jpg";
				}
				
				$result .= '
					<tr>
					<td width="20%" valign="top"><img src="../s/'.$pic.'" width="150" align="center"></td>
					<td width="80%" valign="top">
				';
				
				$result .= '<span class="sp">First Name:</span> '.$fn.'<br>';
				$result .= '<span class="sp">Last Name:</span> '.$ln.'<br>';
				$result .= '<span class="sp">Phone no.:</span> '.$pn.'<br><br><br>';
				$result .= '<a href="student?id='.$id.'">See other details...</a>';;
				
			}
			$result .= '
					</td>
						
					</tr>
				</table>
			'; 
			echo $result;
		}else if($count < 5){
			$result .= '
				<h2>Search Result</h2>
				<table width=100% style="border:2px solid #ccc; font-size: 120%; color: #666; padding: 20px; background: #fff;">
				
			';
			
			while($row = mysqli_fetch_assoc($query)){
				$id = $row['id'];
				$fn = $row['firstname'];
				$ln = $row['lastname'];
				$pn = $row['phoneno'];
				
				$pic = "dimg.jpg";
				if(file_exists('../s/'.$id.'.jpg')){
					$pic = "$id.jpg";
				}
				
				$result .= '
					<tr>
					<td><img src="../s/'.$pic.'" width="70" align="center"></td>
					<td>'.$fn.' '.$ln.' '.$pn.' &emsp;&emsp; <a href="student?id='.$id.'">See the record...</a>
					</td>
					</tr>
					<tr><td colspan="2"><hr></td></tr>
				';
			}
			$result .= '</table>';
			echo $result;
		}else {
			echo "about (".$count.") discovered so far.";
		}
	}
?>