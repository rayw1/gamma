<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
connect_to();

$id = mysql_real_escape_string($_GET["lid"]);

$sql = "DELETE FROM `companyaddress` WHERE `Number` = '$id'";

echo("Attempting to delete Number " . $id . "<br>");
$insertresult = mysql_query($sql);

echo( "
	<script>
	<!--
	location=\"companyAddress_search.php\";
	//-->
	</script> 
	" );

?>
