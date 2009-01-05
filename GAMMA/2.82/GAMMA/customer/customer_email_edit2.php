<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
connect_to();
style("white");
$valid = $_SESSION["validsession"];
$id = mysql_real_escape_string($_POST["id"]);
$dbase = mysql_real_escape_string($_POST["dbase"]);
$email = mysql_real_escape_string($_POST["email"]);
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];

if($valid != 1)
{
	die("INVALID SESSION");
}

$sql0 = "UPDATE `customer_general` SET `Email` = '$email' WHERE `ID` = '$id'";
$updateResult0 = mysql_query($sql0);

echo( "

<script>
<!--
location=\"customer_profile.php?id=$id&dbase=$dbase\";
//-->
</script> 

")
?>
