<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = mysql_real_escape_string($_SESSION["group"]);
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 99)
{
	die("ADMIN TOO LOW");
}
include(getcwd().'/../includes/common.inc');
style("white");

$nameIn = mysql_real_escape_string($_POST["name"]);
$linkIn = mysql_real_escape_string($_POST["link"]);
$adminIn = mysql_real_escape_string($_POST["admin"]);

echo( "<h1>Add Function</h1>" );

connect_to();

$sql0 = "INSERT INTO `functions` (`ID`, `Name`, `Link`, `Group`, `Admin`) VALUES ('', '$nameIn', '$linkIn', '$group', '$adminIn')";
$selectResult0 = mysql_query($sql0);

if($selectResult0 == 0)
{
	log_error("Function Insert Failure: $sql0", "functions_add2.php", $_SESSION["username"], $_SESSION["group"]);
	die( "Write Failure" );
}

echo( "

<script>
<!--
location=\"functions1.php\";
//-->
</script> 

" );
?>
