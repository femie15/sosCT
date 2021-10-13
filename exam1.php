<?php
error_reporting(0);
//CONNECT TO THE HOST AND THE DATABASE
$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
session_start();
include_once 'oesdb.php';
$final=false;
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}

$title = "Test started";
//$student_image = "dimg.jpg";

/*if(!isset($_SESSION['student_id'])){
	header("location: login?red=exam");
	exit();
}*/

$student_id =$_SESSION['stdid'];
$student_name = $_SESSION['stdname'];
$test_id = $_SESSION['testid'];
$tqn = 100;
$duration = $_SESSION['duration'];
$starttime = $_SESSION['starttime'];
$endtime = $_SESSION['endtime'];

//SELECT STUDENT UNIQUE QUESTIONS
$au=array("");
$resultquest = executeQuery("select qnid from studentquestion where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
while ($rms = mysqli_fetch_array($resultquest)) {
	array_push($au,$rms['qnid']);
}	

unset($au[0]); 

// print_r($au);



?><?php 
	//EXAM SCRIPT
	$sql = "SELECT * FROM question WHERE testid='$test_id'";
	$query = mysqli_query($con,$sql);
	
	$totalRows = 100;
	// $totalRows = mysqli_num_rows($query);
	$numPP = 1;
	$last = $au[100];
	// $last = ceil($totalRows/$numPP);
	
	//COURSE TITLE
	$sqlc = "SELECT * FROM test WHERE testid='$test_id'";
	$queryc = mysqli_query($con,$sqlc);
	$row = mysqli_fetch_assoc($queryc);
	$testname = $row['testname'];

		
?>

<!doctype html>
<html>
	<head>
		<title>
	<?php echo $title; ?></title>
		<link href="styles/fontawesome/css/font-awesome.min.css" rel="stylesheet" media="screen"/>
		<link rel="stylesheet" type="text/css" href="oes.css"/>
		<!-- <script id="MathJax-script" async src="admin/maths.js"></script> -->
		<style>
			#overlay {
				position: fixed;
				top: 0px;
				left: 0px;
				bottom: 0px;
				right: 0px;
				background: rgba(155,155,155, .1);
				z-index: 1000;
				display: none;
				transition: all .5s ease-in-out;
			}
			#note {
				background: #cfc;
				padding: 10px 0px;
				text-align: center;
				border: 1px solid #ccc;
				border-radius: 10px;
				box-shadow: 0px 0px 150px #000;
				width: 200px;
				margin: 200px auto;

			}
			#mnu {
				width: 200px;
				float: left;
				z-index: 10;
				box-shadow: 0px 0px 4px #666;
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
		
		<script>
		function _(x){ return document.getElementById(x);}
	 
		var sec = 1;
		var hr = 1;
		var min = "<?php echo $duration; ?>";					 
		var timeOut;
		
		function tick(){
			/*if(min == 0 && sec == 0){
				stopTimer();
			}*/
			if (hr == 0 && min == 0 && sec == 0) {window.location="testack.php";}
						
			sec = sec < 10 ? "0"+sec : sec;
			//min = min < 10 ? "0"+min : min;
		
			if(min >= 60){
				//display if single or double digit
				if((min>=60 && min<=69) || (min>=0 && min<=9)){					
					_("timer").innerHTML = "0"+hr+":0"+(min-60)+":"+sec;
				}else{
					_("timer").innerHTML = "0"+hr+":"+(min-60)+":"+sec;
				}			

			}else if(min < 60){
			_("timer").innerHTML = "00:"+min+":"+sec;
			}

			if(sec == 0){
				sec = 60;
				min--;
			}
			if(min == 0){
				min = 60;
				hr--;
			}
			
			if(min < 20){
				_("timer").style.color="red";
			}
 			timeOut = setTimeout(function(){tick()},1000);
			sec--;
		}

		function stopTimer(){
			clearTimeout(timeOut);
		}
		
		window.addEventListener("load", function(){
			tick();
		});
		
		//make exam
		var totalRows = "<?php echo $totalRows; ?>";
		var last = "<?php echo $last; ?>";
		var numPP = "<?php echo $numPP; ?>";
		var testname = "<?php echo $testname; ?>";

		function renderExam(num,qn){		
			
			var controls = _("controls");
			var controls1 = _("controls1");
			var qStatus = _("qStatus");
			//var testname = _("testname");
			var eHeader = _("examHeader");
			var eBody = _("exam-body");
			examHeader.innerHTML = testname;
			qStatus.innerHTML = "Question "+ num +" of "+totalRows;
			eBody.innerHTML = '<div style="line-height: center; width: 100%; text-align: center; padding-top: 130px;"><i class="fa fa-spinner fa-spin fa-1x"></i> &nbsp;loading question...</div>';
			 
			//ajax to call the question 
			
			var ajx = new XMLHttpRequest();
			ajx.open("POST","eparser.php", true);
			ajx.setRequestHeader("content-type", "application/x-www-form-urlencoded");
			ajx.onreadystatechange = function(){
				if(ajx.readyState == 4 && ajx.status == 200){
					eBody.innerHTML = ajx.responseText;
				}
			};
			ajx.send('qn='+qn+'&last='+last);
			
			var subBtn
			subBtn='';
			subBtn='&emsp;<button type="submit" id="subBtn" title="Finish and out" onclick= window.location="testack.php";  >Final Submit</button>&emsp;<span style="color:red;">Make sure you have finished the test before clicking</span>';
			
			 controls1.innerHTML=subBtn;
			
			
			var controlBtns = "";

			var au=<?php echo json_encode($au);?>;
			if(num < 2){
				
				controlBtns = '&emsp;<button title="Go to next question" id="nextBtn" onclick="renderExam('+(++num)+','+au[num]+')">Next</button>&emsp;';
				// controlBtns = '&emsp;<button title="Go to next question" id="nextBtn" onclick="renderExam('+(++qn)+')">Next</button>&emsp;';
			}else 
			if(num == totalRows){
				controlBtns = '<button title="Go to previous question" id="prevBtn" onclick="renderExam('+(num-1)+','+au[num-1]+')">Previous</button>&emsp;';
				// controlBtns = '<button title="Go to previous question" id="prevBtn" onclick="renderExam('+(qn-1)+')">Previous</button>&emsp;';
			}else {
			controlBtns = '<button title="Go to previous question" id="prevBtn" onclick="renderExam('+(num-1)+','+au[num-1]+')">Previous</button>&emsp;<button title="Go to next question" id="nextBtn" onclick="renderExam('+(++num)+','+au[num]+')">Next</button>&emsp;';
			}
			
			controls.innerHTML = controlBtns;
			
			
		}
		   //save exam in the system
		var stdid = "<?php echo $student_id; ?>";
		function submitExam(q){
			var qv = q.value;
			var qid = _('qid').value;
			
			var ajax = new XMLHttpRequest();
			ajax.open("POST","eparser.php",true);
			ajax.setRequestHeader("content-type","application/x-www-form-urlencoded");
			ajax.onreadystatechange = function(){
				if(ajax.readyState == 4 && ajax.status == 200){
					if(ajax.responseText == "success"){
						_("overlay").style.display = "block";
						setTimeout(function(){ _("overlay").style.display = "none"; }, 1000);
					}
				}
			};
			ajax.send("qv="+qv+"&qid="+qid+"&stdid="+stdid);	
		}

		</script>
		
	</head>
	<body>
	<div id="overlay"><div id="note">saved successfully!</div></div>
	<div id="container">
	<div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="images/logo.gif" alt="OYO e-Test"/>
				<center><br>
                <h3 class="headtexts" style="color:#ffffff;"> &emsp; 
                MINISTRY OF EDUCATION, SCIENCE AND TECHNOLOGY, OYO STATE.
COMPETITIVE ENTRANCE EXAMINATION INTO SCHOOLS OF SCIENCE
2021/2022 ACADEMIC SESSION
                </h3>
                </center>
            </div>
				
		<div style="float:right; width: 120px; border:1px solid #fff; margin: 30px;">
		
		</div>
			
			<div id="mutd" style="width: 320px; height: 200px; float: right; margin-top: 50px;position: relative;margin-right:-180px;" >
				<style>
				.mutd{
					width: 20px;
					height: 20px;
					border: 1px solid #999;
					float:left;
					margin:1px;
					padding: 5px;
					text-align: center;
					background: #efefef;
					cursor: pointer;
				}
				.mutd:hover{
					background: #ffaaaa;
				}
			</style>
			<script>
			var jary= new Array();
			<?php
				foreach($au as $x => $val) {
				//echo "$x = $val<br>";
				?>
				// jary.push('<?php echo $val;?>');
				var mutd = document.createElement('div');
				mutd.className = "mutd";
				mutd.innerHTML= <?php echo $x;?>;
				mutd.addEventListener("click", function(){ renderExam(<?php echo $x?>,<?php echo $val?>) });
				document.getElementById('mutd').appendChild(mutd);
			<?php	} ?>

				// for(var x=1; x<= totalRows; x++ ){
				// var mutd = document.createElement('div');
				// mutd.className = "mutd";
				// mutd.innerHTML= x;
				// mutd.addEventListener("click", function(){ renderExam(this.innerHTML) });
				// document.getElementById('mutd').appendChild(mutd);
				// }
			</script>				
			</div>

		<div style="width:70%; border: 5px solid #ccc; margin-top: 33px; margin-left: 33px; background-color:#fff;">
			<div id="exam-header">
				
				<h2 id="examHeader" style="color: #000;">
				PRACTICE EXAM
				</h2>
				<span id="qStatus" style="color: #000;">Question 3 of 10</span>&emsp;&emsp;&emsp; <b><span id="timer" style="font-family: segoe ui; color: #00ff00; font-size: 25px; float:right;">Remaining Time: 00:05:33</span></b>
				<hr style="color:#0000ff;"/>
			</div>
			<div id="exam-body" style="padding: 20px; font-size: 14px; color: #000; min-height: 300px;">
				<h2 style="color:blue;">What is the meaning of HTML...?</h2>
				<form>
					A. <strong><input type="radio" name="opt()" value=""> Hypertext Markup Language</strong><br>
					B. <input type="radio" name="opt()" value=""> Hyperlink Markup Link<br>
					C. <input type="radio" name="opt()" value=""> High text Marking Language<br>
					D. <input type="radio" name="opt()" value=""> Hypertext Markup Link<br>
					E. <input type="radio" name="opt()" value=""> Hypertext Markup Link<br>
				</form>
				
			</div>
					
			<div id="controls" style="text-align:right; background: #eee; padding: 10px; border-top: 1px solid #666;">
				
				<button title="Go to previous question" id="prevBtn">&lt;</button>&emsp;
				<button title="Go to next question" id="nextBtn">&gt;</button>&emsp;
			</div>
			<div id="controls1">
				<button type="submit" id="subBtn" name="subbt" title="Finish and out">Final Submit</button>&emsp; 
			</div>
		</div>
		<script>
			renderExam(1);
		</script>
	</body>
	     <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>
      </div>
</html>