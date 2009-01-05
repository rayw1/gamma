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

$sql = "DELETE FROM `mortgagee` WHERE `Number` = '$id'";

echo("Attempting to delete Number " . $id . "<br>");
$insertresult = mysql_query($sql);

	echo( "
	<script>
	<!--
	location=\"mortgagee_search.php\";
	//-->
	</script> 
	" );

?>
