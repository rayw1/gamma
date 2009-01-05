<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}
$id = mysql_real_escape_string($_GET["id"]);

$sql0 = "SELECT * FROM `keychain` WHERE `id` = '$id'";
$selectResult0 = mysql_query($sql0);
$row0 = mysql_fetch_array($selectResult0);
if($row0["office"] != $_SESSION["office"])
{
	echo("ID and Office do not match");
	log_error("Keychain Security Failure: $sql0", "keychain_delete.php", $_SESSION["username"], $_SESSION["group"]);
}

$sql1 = "DELETE FROM `keychain` WHERE `id` = '$id'";
echo("Attempting to delete Number " . $id . "<br>");
$deleteResult1 = mysql_query($sql1);

	echo( "
	<script>
	<!--
	location=\"keychain_search.php\";
	//-->
	</script> 
	" );

?>
