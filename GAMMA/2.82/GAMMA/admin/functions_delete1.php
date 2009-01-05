<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 99)
{
	die("ADMIN TOO LOW");
}

$id = mysql_real_escape_string($_GET["id"]);

include(getcwd().'/../includes/common.inc');

connect_to();

mysql_query("DELETE FROM `functions` WHERE `ID` = '$id'");
?>
<script>
<!--
location="functions1.php";
//-->
</script> 
