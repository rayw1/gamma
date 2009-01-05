<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/includes/common.inc');
session_start();
connect_to();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = mysql_real_escape_string($_POST["office"]);
$_SESSION["office"] = $office;
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}

echo( "Success, changing page" );
?>
<script>
<!--
location="admin.php";
//-->
</script> 
