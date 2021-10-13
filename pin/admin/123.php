<?php 
	if(isset($_POST['fn'])){
		$fn = $_POST['fn'];
		$ln = $_POST['ln'];
		$cs = $_POST['cs'];
		$c = 0;
		
		for($i=0; $i<$fn.length; $i++){
			if($fn !="" || $ln !="" || $cs !=""){
				$con = mysqli_connect("localhost","root","","school_db");
				$sql = "INSERT INTO test_tbl VALUES('','$fn','$ln','$cs')";
				$query = mysqli_query($con,$sql);
				
				$c += $i;
			}
		}
		
		die("Operation successful!.<br>".$c." records added.<br><br><a href='123'>Continue...</a> ");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home </title>
		<script>
			var i = 1;
			function _(x){return document.getElementById(x);}
			function addRow(){
				i++;
				var newRow = document.createElement('div');
				newRow.innerHTML = i+'.&nbsp;&nbsp; <input type="text" name="fn[]" placeholder="First name..."><input type="text" name="ln[]" placeholder="Last name..."><input type="text" name="cs[]" placeholder="Course...">&emsp;<input type="button" onclick="removeRow(this)" value="-" title="Remove this row">';
				_('fdata').appendChild(newRow);
				_('numrows').innerHTML = i;
			}
			function removeRow(x){
				_('fdata').removeChild(x.parentNode);
				i--;
				_('numrows').innerHTML = i;
			}
		</script>
	</head>
	<body>
		<div style="margin: 20px; padding: 20px;">
			<h2>Form with Batch Operation</h2>
			<form action="123" method="post">
				<input type="button" id="add_row()" onclick="addRow()" value="[+] Add New Row">
				 &emsp;<input type="submit" value="Submit">&emsp;&emsp; Rows: ( <span id="numrows">1</span> ) 
				<div id="fdata" style="width: 45%; height: 50vh; overflow:auto;">
				1. &nbsp;&nbsp;<input type="text" name="fn[]" placeholder="First name..."><input type="text" name="ln[]" placeholder="Last name..."><input type="text" name="cs[]" placeholder="Course...">
				</div>
				
			</form>
		</div>
	</body>
</html>