<?php

error_reporting(0);
include_once 'oesdb.php';

if(isset($_REQUEST['savem']))
{
	
   
     $query="update student set stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass');";
     if(!@executeQuery($query))
        $_GLOBALS['message']=mysqli_error();
     else
        $_GLOBALS['message']="Your Profile is Successfully Updated.";
    
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
           <form id="editprofile" action="#" method="post">
          
      <div class="page">

           <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
           

                      <tr>
                  <td>Password</td>
                  <td><input type="password" name="password" value="" size="16" onkeyup="isalphanum(this)" /></td>
                 
              </tr>
<input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes"/>
               </table>

      </div>

           </form>
      <div id="footer">
          <p> Developed By-<b>Bread on Waters Technologies</b><br/> </p>
      </div>
      </div>
  </body>
</html>
