<?php
session_start();
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","school_db") or die("Connection problem.");
$msg = "";

$red = "student";
if(isset($_GET['red']) && true){
	$_SESSION['red'] = $_GET['red'];
}

if(isset($_POST['em'])){
	$em = $_POST['em'];
	$pw = $_POST['pw'];
	$encpass = md5($pw);
	
	//validating our form
	if(!$em || !$pw){
		$msg = "You must supply both email and password.";
	}else{
		//check for existence of the student in the system
		$sql = "SELECT * FROM students_tbl WHERE email='$em' AND password='$encpass'";
		$query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($query);
		if($count < 1){
			$msg = "email or password incorrect.";
		}else{
			$row = mysqli_fetch_assoc($query);
			
			$id = $row['id'];
			
			//create a session for the student
			$_SESSION['student_id'] = $id;
			
			//check where the student came from
			if(isset($_SESSION['red'])){
				$red = $_SESSION['red'];
			}
			
			//redirect the student
			header("location: $red");
			exit();
		}
	}
}

?>
<!doctype html>
<html>
	<head>
		<title>Manage Questions</title>
		<link href="styles/fontawesome/css/font-awesome.min.css" rel="stylesheet" media="screen"/>
		<style>
			#mnu {
				width: 200px;
				float: left;
				z-index: 10;
				box-shadow: 0px 0px 4px #666;
				position: absolute;
			}
			#mnu > a > div {
				padding: 12px 30px;
				border-top: 1px solid #ccc;
				background: #fafafa;
				transition: background 0.3s linear 0s;
			}
			#mnu > a > div:hover {
				background: #ccc;
			}
			a {
				text-decoration: none;
				color: #666;
			}
			a:hover {color: #000;}
		</style>
	</head>
	<body>
		<div id="mnu">
			<a href="index"><div><i class="fa fa-home"></i> Home</div></a>
			<a href="signout"><div><i class="fa fa-lock"></i> Logout</div></a>
		</div>
		<div style="margin: 100px auto; padding: 30px; border:solid 2px #ccc; width: 300px;" >
			<h3>Login</h3>
			<?php echo $msg; ?>
			<form method="post" action="login">
				<input type="email" name="em" placeholder="Your email..."><br><br>
				<input type="password" name="pw" placeholder="Your password..."><br><br>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>