<?php
//header('Location: login');
      error_reporting(0);
      session_start();
      include_once 'oesdb.php';
/***************************** Step 1 : Case 1 ****************************/
 //redirect to registration page
      if(isset($_REQUEST['register']))
      {
            header('Location: register.php');
      }
      else if($_REQUEST['stdsubmit'])
      {
/***************************** Step 1 : Case 2 ****************************/
 //Perform Authentication
          $result="select *,DECODE(stdpassword,'oespass') as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')";
          $result=mysqli_query($conn,$result);
		  if(mysqli_num_rows($result)>0)
          {

              $r=mysqli_fetch_array($result);
              if(strcmp(htmlspecialchars_decode($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
                  $_SESSION['stdid']=$r['stdid'];
                  unset($_GLOBALS['message']);
                  header('Location: stdwelcome.php');
              }else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
          }

          }
          else
          {
              $_GLOBALS['message']="Check Your user name and Password.";
          }
          closedb();
      }
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>EDUmix e-Test</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="oes.css"/>
  </head>
  <body >
      <?php

        if($_GLOBALS['message'])
        {
         echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
      ?>
      
      <div id="containers">
            
           <!--     <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="images/logo.gif" alt="OYO e-Test"/><h3 class="headtext"> &nbsp;E-Test.  Examination SIMULATOR </h3><h4 style="color:#ffff00;text-align:center;margin:0 0 5px 5px;"><i>...Advancing knowledge through ICT</i></h4>
            </div>-->
     <form id="stdloginform" action="index.php" method="post">
   <!--   <div class="menubar">
       
       <ul id="menu">
                    <?php if(isset($_SESSION['stdname'])){
                          header('Location: resumetest.php?resume=2');}else{  
                          /***************************** Step 2 ****************************/
                        ?>

           <li><div class="aclass"><a href="admin" title="Click here  to Register">Admin</a></div></li>
           <li><div class="aclass"><a href="tc" title="Click here  to Register">Teacher</a></div></li>
                        <?php } ?>
                    </ul>

      </div>-->
      <div class="page">
              <center>
              <a href="login">
              <img src="intro/intro.gif" alt="intro">
              </a>
              <br>
              <a href="login">
              <h2 class="button">CLICK IF YOU ARE READY TO START</h2>
              </a>
              </center>

              <!-- <table cellpadding="10" cellspacing="5">
              <tr>
                  <td>User Name</td>
                  <td><input type="text" tabindex="1" name="name" value="" size="26" /></td>

              </tr>
              <tr>
                  <td>Password</td>
                  <td><input type="password" tabindex="2" name="password" value="" size="26" /></td>
              </tr>

              <tr>
                  <td colspan="2">
                      <input type="submit" tabindex="3" value="Log In" name="stdsubmit" class="subbtn" />
                  </td><td></td>
              </tr>
            </table> -->


      </div>
       </form>

   <!-- <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>-->
      </div>
  </body>
</html>
