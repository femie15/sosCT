<?php

/*
***************************************************
*** E-Test.  Examination Manager         ***
***---------------------------------------------***
*** License: Licensed for E-Test.  v.1   ***
*** Author: Browt Technologies                  ***
*** Title:  Test Completion Acknowledgement     ***
***************************************************
*/

$con = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
error_reporting(0);
session_start();
include_once 'oesdb.php';

$student_id =$_SESSION['stdid'];
$student_name = $_SESSION['stdname'];
$test_id = $_SESSION['testid'];
if(isset($_SESSION['stdid'])){

   //update when exam is finished
	$sqlf = "UPDATE studenttest SET status='over' WHERE stdid='$student_id' and testid='$test_id' ";
	$queryf = mysqli_query($con,$sqlf);
	
	
	//nunmber of correct answers
	$sqlq = "SELECT * FROM question WHERE testid='$test_id' ";
	$queryq = mysqli_query($con,$sqlq);
	while($rowq = mysqli_fetch_assoc($queryq)){
			$ca = $rowq['correctanswer'];
			$qid = $rowq['qnid'];
				$sqlsq = "SELECT * FROM studentquestion WHERE stdid='$student_id' and testid='$test_id' and qnid='$qid' ";
				$querysq = mysqli_query($con,$sqlsq);
				$rowsq = mysqli_fetch_assoc($querysq);
				$stdanswer = $rowsq['stdanswer'];
			//updating
				if($stdanswer==$ca){
			$sqlz = "SELECT * FROM studenttest WHERE testid='$test_id' and qnid='$qid' ";
			$queryz = mysqli_query($con,$sqlz);
			$rowz = mysqli_fetch_assoc($queryz);
			$cad = $rowz['correctlyanswered'];
			$cad=$cad+1;
			$sqlc = "UPDATE studenttest SET correctlyanswered='$cad' WHERE stdid='$student_id' and testid='$test_id' ";
			$queryc = mysqli_query($con,$sqlc);	
				}
	}	
		
}
//echo"$student_name";
if(!isset($_SESSION['stdname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}

else if(isset($_REQUEST['logout']))
{
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    session_destroy();
    header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
    //redirect to dashboard
   
     header('Location: stdwelcome.php');

}
/*if(isset($_SESSION['starttime']))
{
    unset($_SESSION['starttime']);
    unset($_SESSION['endtime']);
    unset($_SESSION['tqn']);
    unset($_SESSION['qn']);
    unset($_SESSION['duration']);
    executeQuery("update studenttest set status='over' where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].";");
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>EDUmix-Test Acknowledgement</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    </head>
  <body >
       <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
      <div id="container">
      <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="images/logo.gif" alt="OYO e-Test"/><h4 style="color:#ffff00;text-align:center;margin:20px 10px 5px 5px;"><span class="headtext">  EDUmix e-Test </span><br/><i>...Advancing knowledge through ICT</i></h4>
            </div>
           <form id="editprofile" action="editprofile.php" method="post">
          <div class="menubar">
               <ul id="menu">
                        <?php if(isset($_SESSION['stdname'])) {
                         // Navigations
                         ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <!-- <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li> -->
                       

               </ul>
          </div>
      <div class="page">
      <br>
      <center>
          <h2 style="color:#0000cc;">
          Your exam is Successfully Submitted.
           <br> <br>   
         Dont forget anything while leaving the exam hall, we wish you the best.
         </h2>
    </center>
          <?php
                        }
          ?>
      </div>

           </form>
     <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>
      </div>
  </body>

  <script>
         setTimeout(function(){
            window.location.href = 'testack.php?logout=yes';
         }, 120000);
      </script>


</html>

