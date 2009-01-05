<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

$timestamp1 = mysql_real_escape_string($_GET["date"]);
$number = mysql_real_escape_string($_GET["number"]);
$passYear = substr($timestamp1,0,4);
$passMonth = substr($timestamp1,5,2);
$passDay = substr($timestamp1,8,2);

$newTime1 = $passYear."-".$passMonth."-".$passDay;
$nonDash = $passYear.$passMonth.$passDay;

$sql1 = "INSERT INTO `messages` (`ID`, `Message`, `level`, `Group`, `Date`) VALUES ('', '', '$number', '$group', '$newTime1')";
$selectResult1 = mysql_query($sql1);

echo($getDate);


echo( "<script>
<!--
location=\"messages1.php?date=$nonDash\";
//-->
</script> ");

?>
