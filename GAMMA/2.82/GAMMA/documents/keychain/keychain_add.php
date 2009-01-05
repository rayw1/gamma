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
$username = mysql_real_escape_string($_POST["username"]);
$password = mysql_real_escape_string($_POST["password"]);
$company = mysql_real_escape_string($_POST["company"]);
$aCode = mysql_real_escape_string($_POST["agentCode"]);

$sql1 = "INSERT INTO `keychain` (`id`, `username`, `password`, `company`, `agentCode`, `office`, `group`) VALUES ('', '$username', '$password', '$company', '$aCode', '$dbase', '$group')";

$insertResult1 = mysql_query($sql1);

if($insertResult1 == 0)
{
	log_error("Keychain Insert Failure: $sql2", "keychain_add.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure" );
}

echo( "
	<script>
	<!--
	location=\"keychain_search.php\";
	//-->
	</script> 
	" );

?>
