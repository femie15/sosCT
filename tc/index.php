 <?php
header('Location:login');
      error_reporting(0);
      session_start();
      include_once '../oesdb.php';

      if(isset($_REQUEST['tcsubmit']))
      {
/***************************** Step 1 : Case 2 ****************************/
 //Perform Authentication
          $result="select *,DECODE(tcpassword,'oespass') as tc from testconductor where tcname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and tcpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')";
			$result=mysqli_query($conn,$result);
		 if(mysqli_num_rows($result)>0)
          {

              $r=mysqli_fetch_array($result);
              if(strcmp(htmlspecialchars_decode($r['tc'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['tcname']=htmlspecialchars_decode($r['tcname'],ENT_QUOTES);
                  $_SESSION['tcid']=$r['tcid'];
                  unset($_GLOBALS['message']);
                  header('Location: tcwelcome.php');
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
    <link rel="stylesheet" type="text/css" href="../oes.css"/>
  </head>
  <body>
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
     <form id="tcloginform" action="index.php" method="post">
      <div class="menubar">
       
       <ul id="menu">
                    <?php if(isset($_SESSION['tcname'])){
                          header('Location: tcwelcome.php');}
                          /***************************** Step 2 ****************************/
                        ?>

                      <!--  <li><input type="submit" value="Register" name="register" class="subbtn" title="Register"/></li>-->
           <li></li>
                       
                    </ul>

      </div>
      <div class="page">
              
              <table cellpadding="30" cellspacing="10">
              <tr>
                  <td>TC Name</td>
                  <td><input type="text" tabindex="1" name="name" value="" size="16" /></td>

              </tr>
              <tr>
                  <td>Password</td>
                  <td><input type="password" tabindex="2" name="password" value="" size="16" /></td>
              </tr>

              <tr>
                  <td colspan="2">
                      <input type="submit" tabindex="3" value="Log In" name="tcsubmit" class="subbtn" />
                  </td><td></td>
              </tr>
            </table>


      </div>
       </form>

     <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>
      </div>
  </body>
</html>
