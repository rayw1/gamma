<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
session_start();
set_time_limit(900);
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$sub = mysql_real_escape_string($_POST["subject"]);
$group = $_SESSION["group"];
$i = 0;
$h = 0;

if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 3)
{
  die("ADMIN TOO LOW");
}



$itemList = mysql_query("SELECT * FROM `customer_general` WHERE `Group` = '$group'");

while($row = mysql_fetch_array($itemList))
{
	$subject = mysql_real_escape_string($_POST["subject"]);
	$from = mysql_real_escape_string($_POST["from"]);
	$address = $row["Email"];
	$body = mysql_real_escape_string($_POST["body"]);

	if(mail($address, $subject, $body, $headers))
	{
		$i++;
	}
	else
	{
		$h++;
	}
	$headers = "";
}

echo( "Sent ".$i." successful emails.<br>");
echo( "Sent ".$h." unsuccessful emails.");
?>
