<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
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

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$office = mysql_real_escape_string($_POST["office"]);
$from = mysql_real_escape_string($_POST["from"]);

$itemList = mysql_query("SELECT * FROM `customer_general` WHERE `Group` = '$group' AND `Office` = '$office'");

while($row = mysql_fetch_array($itemList))
{
	$subject = mysql_real_escape_string($_POST["subject"]);
	$address = $row["Email"];
	$body = mysql_real_escape_string($_POST["body"]);

	if($address != "")
	{
		if(mail($address, $subject, $body, $headers))
		{
			$i++;
		}
		else
		{
			$h++;
		}
	}
	$headers = "";
}

echo( "Sent ".$i." successful emails.<br>");
echo( "Sent ".$h." unsuccessful emails.");
?>
