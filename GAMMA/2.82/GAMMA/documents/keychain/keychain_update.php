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

$num = mysql_real_escape_string($_POST["number"]);
$name = mysql_real_escape_string($_POST["username"]);
$password = mysql_real_escape_string($_POST["password"]);
$company = mysql_real_escape_string($_POST["company"]);
$agentCode = mysql_real_escape_string($_POST["agentCode"]);

$sql = "UPDATE `keychain` SET `username` = '$name', `password` = '$password', `company` = '$company', `agentCode` = '$agentCode' WHERE `id` = '$num'";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Keychain Update Failure: $sql", "keychain_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write Failure<br>" );
}

echo( "
	<script>
	<!--
	location=\"keychain_search.php\";
	//-->
	</script> 
	" );

?>
