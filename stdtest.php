<?php


error_reporting(0);
session_start();
include_once 'oesdb.php';
if (!isset($_SESSION['stdname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
//} else if (isset($_SESSION['starttime'])) {
   // header('Location: testconducter.php');
} else if (isset($_REQUEST['logout'])) {
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    //redirect to dashboard
    //
    header('Location: stdwelcome.php');
} else if (isset($_REQUEST['starttest'])) {
    //Prepare the parameters needed for Test Conducter and redirect to test conducter
    if (!empty($_REQUEST['tc'])) {
        $result = executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=" . $_SESSION['testid'] . ";");

        if ($r = mysqli_fetch_array($result)) {
            if (strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_REQUEST['tc'], ENT_QUOTES)) != 0) {
                $display = true;
                $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
            } else {
                //now prepare parameters for Test Conducter and redirect to it.
                //first step: Insert the questions into table

                $result = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");

                // $rn=mt_rand(1,10);
                // //STORE FIRST 5 QUESTIONS IN ENGLISH
                // $result = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid LIMIT 5 OFFSET 0;");
                // //STORE RANDOM UNIQUE 28 QUESTIONS IN ENGLISH
                // $resulte = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid LIMIT 28 OFFSET ".($rn+5).";");
                // //STORE RANDOM UNIQUE 33 QUESTIONS IN SCIENCE
                // $results = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid LIMIT 33 OFFSET ".($rn+50).";");
                // //STORE RANDOM UNIQUE 34 QUESTIONS IN MATHS
                // $resultm = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid LIMIT 34 OFFSET ".($rn+100).";");
                
                if (mysqli_num_rows($result) == 0) {
                    $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                } else {
                  //  executeQuery("COMMIT");
                    $error = false;
               
                    if (!executeQuery("insert into studenttest values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress')"))
                        $_GLOBALS['message'] = "error" . mysqli_error();
                    else {               

                        //populate students question
                        while ($r = mysqli_fetch_array($result)) {
                            if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL)")) {
                                $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                $error = true;
            // array_push($_SESSION['qustnum'],$r['qnid']);                                
                          // echo"<script>alert('ok'); </script>";
                            }
                        } 
                        // //populate students remaining english question
                        // while ($re = mysqli_fetch_array($resulte)) {
                        //     if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $re['qnid'] . ",'unanswered',NULL)")) {
                        //         $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                        //         $error = true;
                        // // array_push($_SESSION['qustnum'],$r['qnid']);                       
                        //     }
                        // }
                        // //populate students science question
                        // while ($rs = mysqli_fetch_array($results)) {
                        //     if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $rs['qnid'] . ",'unanswered',NULL)")) {
                        //         $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                        //         $error = true;
                        // // array_push($_SESSION['qustnum'],$r['qnid']);                      
                        //     }
                        // }
                        // //populate students maths question
                        // while ($rm = mysqli_fetch_array($resultm)) {
                        //     if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $rm['qnid'] . ",'unanswered',NULL)")) {
                        //         $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                        //         $error = true;
                        // // array_push($_SESSION['qustnum'],$r['qnid']);                       
                        //     }
                        // }


                        if ($error == true) {
                          // executeQuery("rollback;");
                        } else {    
                            $result = executeQuery("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                            $r = mysqli_fetch_array($result);
                            $_SESSION['duration'] = 60;
                            // $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                            $result = executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                            $r = mysqli_fetch_array($result);
                            $_SESSION['starttime'] = $r['startt'];
                            $_SESSION['endtime'] = $r['endt'];							

							
                            $_SESSION['qn'] = 1;

                          header('Location: exam1.php');
                           // header('Location: testconducter.php');
                        }
                    }
                }
            }
        } else {
            $display = true;
            $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
        }
    } else {
        $display = true;
        $_GLOBALS['message'] = "Enter the Test Code First!";
    }
} else if (isset($_REQUEST['testcode'])) {
    //test code preparation
    if ($r = mysqli_fetch_array($result = executeQuery("select testid from test where testname='" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "';"))) {
        $_SESSION['testname'] = $_REQUEST['testcode'];
        $_SESSION['testid'] = $r['testid'];
    }
} else if (isset($_REQUEST['savem'])) {
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysqli_error();
        else
            $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
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
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE"/>
        <meta http-equiv="PRAGMA" content="NO-CACHE"/>
        <meta name="ruru" content="NONE"/>

        <link rel="stylesheet" type="text/css" href="oes.css"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    <body >
        <?php
        if ($_GLOBALS['message']) {
            echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
        }
        ?>
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

				<!--<h4 style="color:#ffffff;text-align:center;margin:0 0 5px 5px;"><i>...because Examination Matters</i></h4>-->
            </div>
            <form id="stdtest" action="stdtest.php" method="post">
                <div class="menubar">
                    <ul id="menu">
                        <?php
                        if (isset($_SESSION['stdname'])) {
                            // Navigations
                        ?>
                            <!-- <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li> -->
                            <!-- <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li> -->


                        </ul>
                    </div>
                    <div class="page">
                    <?php
                            if (isset($_REQUEST['testcode'])) {
                               // echo "<div class=\"pmsg\" style=\"text-align:center;\">What is the Code of " . $_SESSION['testname'] . " ? </div>";
                            } else {
                                echo "<div class=\"pmsg\" style=\"text-align:center;\">Offered Tests</div>";
                            }
                    ?>
                    <?php
                            if (isset($_REQUEST['testcode']) || $display == true) {

                        //find student name
                        $cid=$_SESSION['stdid'];
                        $sqlcz = "SELECT * FROM candidate WHERE id=$cid";
                        $querycz = mysqli_query($conn, $sqlcz);
                        $rowc = mysqli_fetch_array($querycz);
                    ?>
                    <br>
                    <br>
                    <br>
                    <center>
                <b> Welcome <span style="font-size:30px;"><?php echo $rowc['name'];?> </span></b> <br><br>
                TIME: 1 HOUR  <br><br>

                    Click the button below to start your Exam. <br> 
                                <!-- <img src="intro/1.jpg" width="50%" alt=""> <br> -->
                    <!-- Add Video here. -->
                                <table cellpadding="30" cellspacing="10" width="100%">
                                    <tr hidden>
                                        <td>Enter Test Code</td>
                                        <td><input type="text" tabindex="1" name="tc" value="11111" size="16" /></td>
                                        <td><div class="help"><b>Note:</b><br/>Once you press Start Exam<br/>button timer will be started</div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <input type="submit" tabindex="3" value="Start Exam." name="starttest" class="subbtn" />
                                        </td>
                                    </tr>
                                </table>
                                <!-- <a href="resumetest.php?resume=2"  class="subbtn">Resume Exam</a> -->
                                </center>                                

                    <?php
                    //take to EXAM page                 

                            } else {
                                $result = executeQuery("select t.*,s.subname from test as t, subject as s where s.subid=t.subid and CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from question where testid=t.testid) and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid and stdid=" . $_SESSION['stdid'] . " and status='over');");
                                if (mysqli_num_rows($result) == 0) {
                                    echo"<br/><br/><h3 style=\"color:#ff00cc;text-align:center;\">Time UP !<br/> For this moment, You have no available tests.</h3>";
                                   // header('Location: resumetest.php?resume=2');
                                } else {
                                    //editing components

                                    //RESUME TEST REDIRECT
                                    
                  header('Location: resumetest.php?resume=2');
                    ?>

                    
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Test Description</th>
                                            <th>Subject Name</th>
                                            <th>Duration</th>
                                            <th>Total Questions</th>
                                            <th>Take Test</th>
                                        </tr>
                        <?php
                                    while ($r = mysqli_fetch_array($result)) {
                                        $i = $i + 1;
                                        if ($i % 2 == 0) {
                                            echo "<tr class=\"alt\">";
                                        } else {
                                            echo "<tr>";
                                        }
                                        echo "<td>" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['testdesc'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                                        . "</td><td>" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . " </td><td>" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . " </td>"
                                        . "<td class=\"tddata\"><a title=\"Start Test\" href=\"stdtest.php?testcode=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><img src=\"images/starttest.png\" height=\"30\" width=\"40\" alt=\"Start Test\" /></a></td></tr>";
                                    }
                        ?>
                                </table>
                    <?php
                                }
                                closedb();
                            }
                        }
                    ?>

                </div>

            </form>
            <div id="footer" style="margin-top:100%;">
                <p> Developed By-<b>Browt Tech</b><br/> </p>
            </div>
        </div>
    </body>
</html>

