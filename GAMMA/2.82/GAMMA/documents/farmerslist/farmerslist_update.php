<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

$name = mysql_real_escape_string($_POST["name"]);
$location = mysql_real_escape_string($_POST["location"]);
$num = mysql_real_escape_string($_POST["number"]);

$sql = "UPDATE `farmers` SET `Name` = '$name', `Location` = '$location' WHERE `Number` = '$num'";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Farmers List Update Failure: $sql2", "farmerslist_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write Failure<br>" );
}

echo( "
	<script>
	<!--
	location=\"farmerslist_search.php\";
	//-->
	</script> 
	" );

?>
