<?php
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","school_db") or die("Connection problem.");
$msg = "";

/*
$gencodes = "";
for($i=0; $i<20; $i++){
	$gencodes .= 1+$i.". ". rand(11111,99999)."<br>";
}
*/
//SIGN UP PROCESSING MECHANISM
if(isset($_POST['pnn'])){
	//create local variable for the form data
	$pnn = $_POST['pnn'];
	
	//form validation
	if($pnn == 'select'){
		$msg = "You must select number of pins to generate. <a href='genpins.php'>Try again</a>";
	}else{
		//register the student into the system.
		
		
		for($i=0; $i<$pnn; $i++){
			$sr = rand(11111,99999);
			$pn = rand(1111111,9999999);
			
			$sql = "INSERT INTO pins VALUES('','$sr','$pn',now(),0,'','')";
			$query = mysqli_query($con, $sql);
		}
		
		die($pnn. " Pins generated successfully. <a href='genpins.php'>Continue...</a>");
	
	}	
	
}
  
?>
<!doctype html>
<html>
	<head>
		<title>Pins Generator</title>
	</head>
	<body>
	<div>
		<a href="genpins.php">Generate Pins</a>&emsp;|&emsp;
		<a href="usedpins.php">View Used Pins</a>&emsp;|&emsp;
		<a href="unusedpins.php">View Unused Pins</a>&emsp;|&emsp;
	</div>
	<h1>Select number of Pins to Generate</h1>
		<div>
			<?php echo $msg; ?>
			<form method="post" action="genpins.php">
				<select name="pnn">
					<option value="select">- select -</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
				<input type="submit" value="Generate"><br><br>
			</form>
		</div>
	</body>
</html>