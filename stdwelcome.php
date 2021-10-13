<?php

/*
***************************************************
*** E-Test.  Examination Manager         ***
***---------------------------------------------***
*** License: Licensed for E-Test.  v.1   ***
*** Author: Browt Technologies                  ***
*** Title: Student Welcome                      ***
***************************************************
*/

error_reporting(0);
session_start();
        if(!isset($_SESSION['stdname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
                unset($_SESSION['stdname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
        }
?>
<html>
    <head>
        <title>EDUmix e-Test</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="oes.css"/>
    </head>
    <body>
        <?php
       
        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <div id="container">
           <div class="header">
                <img style="margin:10px 2px 2px 10px;float:left;" height="80" width="200" src="images/logo.gif" alt="OYO e-Test"/><h4 style="color:#ffff00;text-align:center;margin:20px 10px 5px 5px;"><span class="headtext">  EDUmix e-Test </span><br/><i>...Advancing knowledge through ICT</i></h4>
            </div>
            <div class="menubar">

                <form name="stdwelcome" action="stdwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['stdname'])){ ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                        <?php } ?>
                    </ul>
                </form>
            </div>
            <div class="stdpage">
                <?php if(isset($_SESSION['stdname'])){ ?>

        
                <img height="450" width="70%" alt="background" src="images/img0.png" class="btmimg" align="center"/>
                <div class="topimg">
                    <p><img height="600" width="600" style="border:none;"  src="images/stdwelcome.jpg" alt="image"  usemap="#oesnav" /></p>

                    <map name="oesnav">
                        <area shape="circle" coords="150,160,70" href="viewresult.php" alt="View Results" title="Click to View Results" />
                        <area shape="circle" coords="450,160,70" href="stdtest.php" alt="Take a New Test" title="Take a New Test" />
                        <!--<area shape="circle" coords="300,250,60" href="editprofile.php?edit=edit" alt="Edit Your Profile" title="Click this to Edit Your Profile." />-->
                        <area shape="circle" coords="300,300,70" href="#" alt="Edit Your Profile" title="Click this to Edit Your Profile." />
                        <area shape="circle" coords="170,450,70" href="practicetest.php" alt="Practice Test" title="Click to take a Practice Test" />
                        <area shape="circle" coords="450,455,70" href="resumetest.php" alt="Resume Test" title="Click this to Resume Your Pending Tests." />
                    </map>
                </div>
                <?php }?>

            </div>

           <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>
      </div>
  </body>
</html>
