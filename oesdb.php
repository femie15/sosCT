<?php

/*
***************************************************
*** E-Test.  Examination Manager         ***
***---------------------------------------------***
*** License: Licensed for E-Test.  v.1   ***
*** Author: Browt Technologies                  ***
*** Title: Database Library Functions           ***
***************************************************
*/

include_once 'dbsettings.php';
$conn = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
//$conn=false;

function executeQuery($query)
{
    global $dbserver,$dbname,$dbpassword,$dbusername;
    global $message;
    if (!($conn = mysqli_connect ($dbserver,$dbusername,$dbpassword)))
         $message="Cannot connect to server";
    if (!@mysqli_select_db ($dbname, $conn))
         $message="Cannot select database";

$conn = mysqli_connect("localhost","root","","oes") or die("Connection problem.");
    $result=mysqli_query($conn,$query);
    if(!$result){
        $message="Error while executing query.<br/>Mysql Error: ";//.mysqli_error();
   }   else{
        return $result;
}
}

function closedb()
{
    global $conn;
    if(!$conn)
    mysqli_close($conn);
}


?>
