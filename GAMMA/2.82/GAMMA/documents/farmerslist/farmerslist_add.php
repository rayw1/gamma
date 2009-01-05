<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$name = mysql_real_escape_string($_POST["name"]);
$location = mysql_real_escape_string($_POST["location"]);

$sql = "INSERT INTO `farmers` (`Number`, `Name`, `Location`, `Group`) VALUES ('', '$name', '$location', '$group')";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Farmers List Insert Failure: $sql2", "farmerslist_add.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure" );
}

echo( "
	<script>
	<!--
	location=\"farmerslist_search.php\";
	//-->
	</script> 
	" )


?>
