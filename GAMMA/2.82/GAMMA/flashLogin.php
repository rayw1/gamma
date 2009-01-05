<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/includes/common.inc');
connect_to();

$utest = mysql_real_escape_string($_COOKIE["username"]);
$ptest = mysql_real_escape_string($_COOKIE["password"]);
$gtest = mysql_real_escape_string($_COOKIE["group"]);
$_SESSION["admin"] = 0;

$sql1 = "SELECT * FROM `users` WHERE `username` = '$utest' AND `password` = '$ptest' AND (`group` = '$gtest' OR `group` = 'All')";
$uquery = mysql_query($sql1);

if($uquery == 0)
{
	log_error("Could not select from users: $sql1", "flashLogin.php", $utest, $gtest);
	die( "There has been an error.  This could be caused because:<br>
	 It has been 30 days since your last login to GAMMA<br>
	 Your username or password is no longer valid<br>
	 Please try again, or login to <a href=\"index.php\">GAMMA again</a>");
}
else
{
	$row = mysql_fetch_array($uquery);

	$_SESSION["username"] = $row["username"];
	$_SESSION["office"] = $row["office"];
	$_SESSION["validsession"] = 1;
	$_SESSION["group"] = $gtest;
	$_SESSION["admin"] = $row["Admin"];
	echo( "Success, changing page" );
	echo( "
	<script>
	<!--
	location=\"dashboard.php\";
	//-->
	</script> 
	" );

}

?>
