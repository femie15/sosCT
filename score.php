<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","oyoedumi_school","","school_db") or die("Connection problem.");
$msg = "";
/*
$gencodes = "";
for($i=0; $i<20; $i++){
	$gencodes .= 1+$i.". ". rand(11111,99999)."<br>";
}
*/
//SIGN UP PROCESSING MECHANISM
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
		<link rel="stylesheet" type="text/css" href="stl.css"/>
	</head>
	<body>
	<h1>Welcome to HITI</h1>
		<div>
			<h2>New Student Signup</h2>
			<?php echo $msg; ?>
			<center>
			<form method="post" action="index.php">
				<input type="text" name="fn" placeholder="First Name..."><br><br>
				<input type="text" name="ln" placeholder="Last Name..."><br><br>
				<input type="text" name="em" placeholder="email..."><br><br>
				<input type="password" name="pw" placeholder="Password..."><br><br>
				<input type="text" name="matno" placeholder="Mat. No...."><br><br>
				<input type="text" name="pn" placeholder="Phone no..."><br><br>
				<input type="submit" value="Sign UP"><br><br>
			</form>
		</center>
		</div>
	</body>
</html>