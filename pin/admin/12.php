<?php 
	if(isset($_POST['fn_1'])){
		$moreRows = true;
		$i = 1;
		
		while($moreRows){
			if(isset($_POST['fn_'.$i]) && ($_POST['fn_'.$i] != "")){
				
				$fn = $_POST['fn_'.$i];
				$ln = $_POST['ln_'.$i];
				$cs = $_POST['cs_'.$i];
				
				$con = mysqli_connect("localhost","root","","school_db");
				$sql = "INSERT INTO test_tbl VALUES('','$fn','$ln','$cs')";
				$query = mysqli_query($con,$sql);
				
				$i ++;
			}else{
				$moreRows = false;
				
			}
		}
		$i--;
		die("Operation successful!.<br>".$i." records added.<br><br><a href='12'>Continue...</a> ");
		
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
				newRow.innerHTML = i+'.&nbsp;&nbsp; <input type="text" name="fn_'+i+'" placeholder="First name..."><input type="text" name="ln_'+i+'" placeholder="Last name..."><input type="text" name="cs_'+i+'" placeholder="Course...">&emsp;<input type="button" onclick="removeRow(this)" value="-" title="Remove this row">';
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
			<form action="12" method="post">
				<input type="button" id="add_row()" onclick="addRow()" value="[+] Add New Row">
				 &emsp;<input type="submit" value="Submit">&emsp;&emsp; Rows: ( <span id="numrows">1</span> ) 
				<div id="fdata" style="width: 45%; height: 50vh; overflow:auto;">
				1. &nbsp;&nbsp;<input type="text" name="fn_1" placeholder="First name..."><input type="text" name="ln_1" placeholder="Last name..."><input type="text" name="cs_1" placeholder="Course...">
				</div>
				
			</form>
		</div>
	</body>
</html>