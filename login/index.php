<?php
      error_reporting(0);
      session_start();
      include_once '../oesdb.php';
/***************************** Step 1 : Case 1 ****************************/
 //redirect to registration page
      if(isset($_REQUEST['register']))
      {
            header('Location: ../register.php');
      }
      else if($_REQUEST['name'])
      {
/***************************** Step 1 : Case 2 ****************************/
 //Perform Authentication

			//use password
        //   $result="select *,DECODE(stdpassword,'oespass') as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')";

		  		//dont use password
		   $result="select * from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' ";

          $result=mysqli_query($conn,$result);
		  if(mysqli_num_rows($result)>0)
          {
            $r=mysqli_fetch_array($result);

					//use password
            //   if(strcmp(htmlspecialchars_decode($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
            //   {
            //       $_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
            //       $_SESSION['stdid']=$r['stdid'];
            //       unset($_GLOBALS['message']);
            //       header('Location: ../stdwelcome.php');
            //   }else
			// 	{
			// 		$_GLOBALS['message']="Check Your user name and Password.";
			// 	}

				//Dont use password
				$_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
                  $_SESSION['stdid']=$r['stdid'];
                  unset($_GLOBALS['message']);
				  //header('Location: ../stdwelcome.php');
                  header('Location: ../stdtest.php?testcode=ENGLISH, SCIENCE, MATHS');

          }
          else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
          }
          closedb();
      }
 ?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>EDUmix e-Test</title>

    <style>
@import url(http://fonts.googleapis.com/css?family=Exo:100,200,400);
@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);

body{
	margin: 0;
	padding: 0;
	background: #fff;

	color: #fff;
	font-family: Arial;
	font-size: 12px;
}

.body{
	position: absolute;
	top: -20px;
	left: -20px;
	right: -40px;
	bottom: -40px;
	width: auto;
	height: auto;
	background-image: url(back.jpg);
	/* background-image: url(../intro/intro.gif); */
	background-size: cover;
	-webkit-filter: blur(15px);
	z-index: 0;
}

.grad{
	position: absolute;
	top: -20px;
	left: -20px;
	right: -40px;
	bottom: -40px;
	width: auto;
	height: auto;
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65))); /* Chrome,Safari4+ */
	z-index: 1;
	opacity: 0.7;
}

.header{
	position: absolute;
	top: calc(30% - 5px);
	left: calc(61% - 295px);
	z-index: 2;
}
.msg{
	position: absolute;
	color:red;
	font-size:20px;
	top: calc(65% - 5px);
	left: calc(61% - 295px);
	font-family: 'Exo', sans-serif;
	z-index: 2;
}
.footer{
	position: absolute;
	top: calc(90% - 5px);
	left: calc(60% - 295px);
	z-index: 2;
}

.headerx div{
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 45px;
	font-weight: 1200;
}

.headerx div span{
	color: yellow !important;
}

.login{
	position: absolute;
	top: calc(50% - 75px);
	left: calc(40% - 50px);
	height: 150px;
	width: 350px;
	padding: 10px;
	z-index: 2;
}
.headerx{
	position: absolute;
	top: calc(35% - 75px);
	left: calc(43% - 210px);
	font-family: 'Exo', sans-serif;
	z-index: 2;
}

.login input[type=text]{
	width: 350px;
	height: 30px;
	background: transparent;
	border: 2px solid rgba(255,255,255,0.6);
	border-radius: 10px;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 4px;
}

.login input[type=password]{
	width: 350px;
	height: 30px;
	background: transparent;
	border: 2px solid rgba(255,255,255,0.6);
	border-radius: 10px;
	color: #fff;
	font-family: 'Exo', sans-serif;
	font-size: 16px;
	font-weight: 400;
	padding: 4px;
	margin-top: 10px;
}

.login input[type=submit]{
	width: 130px;
	height: 35px;
	background: #fff;
	border: 1px solid #110033;
	cursor: pointer;
	margin-left:110px;
	border-radius: 20px;
	color: #000;
	font-family: 'Exo', sans-serif;
	font-size: 21px;
	font-weight: 400;
	padding: 6px;
	margin-top: 18px;
}

.login input[type=submit]:hover{
	opacity: 0.8;
}

.login input[type=submit]:active{
	opacity: 0.6;
}

.login input[type=text]:focus{
	outline: none;
	border: 1px solid rgba(255,255,255,0.9);
}

.login input[type=password]:focus{
	outline: none;
	border: 1px solid rgba(255,255,255,0.9);
}

.login input[type=submit]:focus{
	outline: none;
}

::-webkit-input-placeholder{
   color: rgba(255,255,255,0.6);
}

::-moz-input-placeholder{
   color: rgba(255,255,255,0.6);
}
</style>

    <script src="js/prefixfree.min.js"></script>

</head>

<body>
      
  <div class="body">	  </div>
  <div class="msg">
  <?php

        if($_GLOBALS['message'])
        {
         echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
      ?>	  </div>
		<div class="grad"></div>
	<!--<div class="header">-->
	     <div class="headerx">
			<div>School of Science <span>Entrance Exam</span></div>
		</div>
		<br>
		<div class="login">
		<form action="#" method="post">
		  <?php if(isset($_SESSION['stdname']))
		  {
			//header('Location: ../stdwelcome.php');
			header('Location: ../stdtest.php?testcode=ENGLISH, SCIENCE, MATHS');
						  
						}else{  
                          /***************************** Step 2 ****************************/
                        } ?>
						
				<input type="text" placeholder="Exam Number" name="name"><br>
				<input type="hidden" value="student" name="password"><br>
				<input type="submit" name="stdsubmit" value="Login">
		</form>
		</div>

  <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>

</body>
<footer class="footer">
&copy; <?php echo date('Y')?> OYO STATE MINISTRY OF EDUCATION,SCIENCE AND TECHNOLOGY &emsp;
</footer>
</html>