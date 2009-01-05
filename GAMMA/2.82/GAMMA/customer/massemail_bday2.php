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
$sql1 = "SELECT * FROM `customer_general` WHERE `Office` = '$office' ORDER BY `DOB` DESC";
$itemList = mysql_query($sql1);

while($row = mysql_fetch_array($selectResult1))
{
	$dob = $row["DOB"];
	$month = substr($dob, 5, 2);
	$day = substr($dob, 8, 2);
	$year = substr($dob, 0, 4);

	$dob = $month."-".$day."-".$year;

	//Define 3 timestamps.  Today, 31 days from now, and customers next birthday
	$timestamp1 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
	$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d")+31,date("Y")));
	$timestamp3 = date("Ymd",mktime(0,0,0,$month, $day, date("Y")));

	//If timestamp3 is between 1&2, display a row
	if($timestamp3 > $timestamp1 && $timestamp3 < $timestamp2)
	{
		$subject = mysql_real_escape_string($_POST["subject"]);
		$from = mysql_real_escape_string($_POST["from"]);
		$address = $row["Email"];
		$body = mysql_real_escape_string($_POST["body"]);
		$body .= "\nTo be removed from this email list, click ";
		$body .= "http://www.alternativesins.com/customerlist_delete.php?eid=";
		$body .= $row["Number"];
		$headers .= "From: Alternatives Insurance<$from>\r\n";

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
}

while($row = mysql_fetch_array($itemList))
{

}

echo( "Sent ".$i." successful emails.<br>");
echo( "Sent ".$h." unsuccessful emails.");
?>
