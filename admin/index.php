 <?php
header('Location: login');
/*
***************************************************
*** E-Test.  Examination Manager         ***
***---------------------------------------------***
*** License: Licensed for E-Test.  v.1   ***
*** Author: Browt Technologies                  ***
*** Title:  Admin Authentication                ***
***************************************************
*/

 /* Procedure
*********************************************
 * ------------ *
 * HTML Section *
 * ------------ *
Step 1: Display the Html page to receive Authentication Parameters(Name & Password).
 * ----------- *
 * PHP Section *
 * ----------- *
Step 2: IF POST array has some varibles then, perform authentication.

*********************************************
*/
  //    error_reporting(0);
      session_start();
      include_once '../oesdb.php';

      /***************************** Step 2 ****************************/
      if(isset($_REQUEST['admsubmit']))
      {
          
          $result="select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and admpassword='".md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES))."'";
         $result=mysqli_query($conn,$result);
         // $result=mysqli_query("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'])."' and admpassword='".md5(htmlspecialchars($_REQUEST['password']))."'");
          if(mysqli_num_rows($result)>0)
          {
              
              $r=mysqli_fetch_array($result);
              if(strcmp($r['admpassword'],md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['admname']=htmlspecialchars_decode($r['admname'],ENT_QUOTES);
                  unset($_GLOBALS['message']);
                  header('Location: admwelcome.php');
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
    <title>Administrator Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="../oes.css"/>
  </head>
  <body>
<!--
*********************** Step 1 ****************************
-->
      <?php
      
        if(isset($_GLOBALS['message']))
        {
         echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
      ?>
      <div id="container">
                <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="../images/logo.gif" alt="OYO e-Test"/><h4 style="color:#ffff00;text-align:center;margin:20px 10px 5px 5px;"><span class="headtext">  EDUmix e-Test </span><br/><i>...Advancing knowledge through ICT</i></h4>
            </div>
      <div class="menubar">
        &nbsp;
      </div>
      <div class="page">
              <form id="indexform" action="index.php" method="post">
              <table cellpadding="30" cellspacing="10">
              <tr>
                  <td>Admin Name</td>
                  <td><input type="text" name="name" value="" size="16" /></td>

              </tr>
              <tr>
                  <td> Password</td>
                  <td><input type="password" name="password" value="" size="16" /></td>
              </tr>

              <tr>
                  <td colspan="2">
                      <input type="submit" value="Log In" name="admsubmit" class="subbtn" />
                  </td><td></td>
              </tr>
            </table>

        </form>

      </div>

      <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>
      </div>
  </body>
</html>
