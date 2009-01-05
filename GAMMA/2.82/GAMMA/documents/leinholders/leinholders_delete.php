<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
connect_to();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$id = mysql_real_escape_string($_GET["lid"]);

$sql = "DELETE FROM `leinholders` WHERE `Number` = '$id'";

echo("Attempting to delete Number " . $id . "<br>");
$insertresult = mysql_query($sql);

if($insertresult != 1)
{
	log_error("Leinholder Delete Failure: $sql", "leinholders_delete.php", $_SESSION["username"], $_SESSION["group"]);
}

	echo( "
	<script>
	<!--
	location=\"leinholders_search.php\";
	//-->
	</script> 
	" );

?>
