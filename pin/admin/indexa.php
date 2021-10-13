<?php
session_start();
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","school_db") or die("Connection problem.");
$msg = "";

/*
$gencodes = "";
for($i=0; $i<20; $i++){
	$gencodes .= 1+$i.". ". rand(11111,99999)."<br>";
}
*/

//make dynamic list
$course_id = "";
$list = "";

	$sql = "SELECT * FROM courses1_tbl";
	$query = mysqli_query($con, $sql);
	$count = mysqli_num_rows($query);
	if($count > 0){
		$list = '<option value=""></option>';
		while($row = mysqli_fetch_assoc($query)){
			$course_id = $row['id'];
			$course_code = $row['course_code'];
			
			$list .= '<option value="'.$course_id.'">'.$course_code.'</option>';
		}
	}


//NEW SIGN UP PROCESSING MECHANISM
if(isset($_POST['fn'])){
	//create local variable for the form data
	$fn = $_POST['fn'];
	$ln = $_POST['ln'];
	$em = $_POST['em'];
	$pw = $_POST['pw'];
	$mt = $_POST['matno'];
	$pn = $_POST['pn'];
	
	//encrypt the password
	$pw = md5($pw);
	
	//form validation
	if(!$fn || !$ln || !$em || !$pw || !$mt || !$pn){
		$msg = "You must fill all form data. <a href='index.php'>Try again</a>";
	}else{
		//check to make sure that the user does not exist.
		$sql = "SELECT * FROM students_tbl WHERE email='$em'";
		$query = mysqli_query($con, $sql);
		$count = mysqli_num_rows($query);
		if($count > 0){
			$msg = "That students is already registered. <a href='index.php'>Try another</a>";
		}else{
			//register the student into the system.
		$sql = "INSERT INTO students_tbl VALUES('','$fn','$ln','$mt','$pn','$em','$pw')";
		$query = mysqli_query($con, $sql);
		
			if($query){
				die("Record created successfully. <a href='index.php'>Continue...</a>");
			}else{
				die("Registration failed. <a href='index.php'>Try again</a>");
			}
			
		}
	}
}



  
?>
<!doctype html>
<html>
	<head>
		<title>Home</title>
		<link href="../styles/fontawesome/css/font-awesome.min.css" rel="stylesheet" media="screen"/>
		<style>
			#mnu {
				width: 280px;
				float: left;
				z-index: 10;
				box-shadow: 0px 0px 4px #666;
			}
			#mnu > a > div {
				padding: 12px 15px 12px 30px;
				border-top: 1px solid #ccc;
				background: #fafafa;
				transition: background 0.2s linear 0s;
			}
			#mnu > a > div:hover {
				background: #f0f0f0;
			}
			a {
				text-decoration: none;
				color: #666;
			}
			a:hover {color: #000;}
			.cb {
				padding: 0px;
				margin: 0px;
				height: 0px;
				transition: height 0.3s linear 0s;
				overflow: hidden;
				box-shadow: 0px 3px 3px #999 inset;
			}
			.cb > div{
				margin: 20px;
				padding: 20px;
			}
			#content {
				width: 70%;
				float:right;
				border: 1px solid #ccc;
				margin-right: 30px;
				margin-top: 20px;
				background: #fafafa;
				min-height: 80vh;
				padding: 20px;
			}
			.sp {
				color: teal;
				font-weight: bold;
			}
			::-webkit-scrollbar {
				width: 12px;
			}
			 
			::-webkit-scrollbar-track {
				-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
				border-radius: 10px;
			}
			 
			::-webkit-scrollbar-thumb {
				border-radius: 10px;
				-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
			}
		</style>
		<script>
			function toggleBox(x,y){
				var x = document.getElementById(x);
				var arw = document.getElementById(y);
				if(x.style.height == 130+"px"){
					x.style.height = 0+"px";
					arw.innerHTML = '<i class="fa fa-angle-down"></i>';
				}else{
					
					x.style.height = 130+"px";
					arw.innerHTML = '<i class="fa fa-angle-up"></i>';
				}
			}
			
			
			
			function processData(){
				
				var c = document.getElementById("content");
				c.innerHTML = "<img src='wait.gif'>";
				var ajx = new XMLHttpRequest();
				ajx.open("POST","parser.php", true);
				ajx.setRequestHeader("content-type","application/x-www-form-urlencoded");
				ajx.onreadystatechange = function(){
					if(ajx.readyState == 4 && ajx.status == 200){
						c.innerHTML = ajx.responseText;
					}
				};
				var cs = document.getElementById('course').value;
				ajx.send('course_id='+cs);
			}
			
			function searchStudent(){
				var st = document.getElementById('st').value;
				var c = document.getElementById('content');
				c.innerHTML = "<i class='fa fa-spinner fa-pulse'></i> Searching...";
				
				var ajx = new XMLHttpRequest();
				ajx.open("post","parser.php",true);
				ajx.setRequestHeader("content-type","application/x-www-form-urlencoded");
				ajx.onreadystatechange = function(){
					if(ajx.readyState == 4 && ajx.status == 200){
						c.innerHTML = ajx.responseText;
					}
				};
				ajx.send("st="+st);
			
			}
			
			
			
			function collapseBox(x,y){
				var x = document.getElementById(x);
				var y = document.getElementById(y);
				setTimeout(function(){
					if(x.style.height != 0+"px"){
						x.style.height = 0+"px";
						y.innerHTML = '<i class="fa fa-angle-down"></i>';
					}
				},5000);
			}
			
			
			
		</script>
	</head>
	<body>
		<div id="mnu">
			<a href="index"><div><i class="fa fa-home"></i> Home</div></a>
			<a href="#" onclick="return false" onmouseup="toggleBox('cb','arw')"><div><i class="fa fa-edit"></i> Manage Exam questions <span id="arw" style="float:right;"><i class="fa fa-angle-down"></i></span></div></a>
			<div id="cb" class="cb" onmouseleave="collapseBox('cb','arw')"><div>
				<label>Select course</label>
				
					<select id="course" name="course" style="width:160px;" onchange="processData()"><?php echo $list; ?></select>
					<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
					<!--<input type="submit" value="Go &gt;&gt;">-->
				
			</div></div>
			<a href="#" onclick="return false" onmouseup="toggleBox('sr','ar')"><div><i class="fa fa-search"></i> Search Student <span id="ar" style="float:right;"><i class="fa fa-angle-down"></i></span></div></a>
			<div id="sr" class="cb" onmouseleave="collapseBox('sr','ar')"><div>
				<label>Search student</label>
				<form method="post">
					<input type="text" id="st" name="st" style="width:160px;" onKeyup="searchStudent()">
					<div id="miniresult"></div>
				</form>
			</div></div>
			<a href="student"><div><i class="fa fa-user"></i> Student Portal</div></a>
			<a href="login"><div><i class="fa fa-lock"></i> Login</div></a>
			<a href="signout"><div><i class="fa fa-lock"></i> Logout</div></a>
		</div>
		<div id="content">
			Something here...
			<table width=100% style="border:2px solid #ccc; font-size: 120%; color: #666; padding: 20px; background: #fff;">
				<tr>
					<td valign="top"><img src="../s/dimg.jpg" width="70" align="center"></td>
					<td>
						 Aliyu Muhammad 08011223344 &emsp;&emsp; <a href="student?id=1">See other details...</a>
					</td>
					
					
				</tr>
				<tr><td colspan="2"><hr></td></tr>
			</table>
		</div>
		
	</body>
</html>