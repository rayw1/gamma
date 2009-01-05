<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_POST["office"];
$_SESSION["office"] = $office;
if($valid != 1)
{
	die("INVALID SESSION");
}


echo( "Success, changing page" );
?>
<script>
<!--
location="switch1.php";
//-->
</script> 
