<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
connect_to();
session_start();
$valid = $_SESSION["validsession"];
$toView = mysql_real_escape_string($_POST["toView"]);
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

style("white");

//unlocked calendar code

$sql0 = "SELECT * FROM `users` WHERE `calendar` = 'unlocked' AND `username` = '$toView' AND (`group` = '$group' OR `group` = 'all')";
$selectResult0 = mysql_query($sql0);

if($selectResult0 == 0)
{
	log_error("Calendar Select Failure: $sql0", "calendar_unlocked.php", $_SESSION["username"], $_SESSION["group"]);
	die( "Error selecting calendar for that username, this person's calendar is not unlocked!" );
}
else 
{
	echo( "<h1>Summary of $toView's Calendar</h1>");
}

$begin = mktime(0,0,0,date("m"),date("d"),date("Y"));
$end = mktime(0,0,0,date("m")+1,date("d"),date("Y"));

$Tdate = getdate($begin);
$begin = $Tdate["year"]."-".$Tdate["mon"]."-".$Tdate["mday"]." 00:00:00";;

$Tdate = getdate($end);
$end = $Tdate["year"]."-".$Tdate["mon"]."-".$Tdate["mday"]." 23:59:59";

$sql1 = "SELECT * FROM `calendar` WHERE `date_time` >= '$begin' AND `date_time` <= '$end' AND `visibility` LIKE '%$toView%' AND `Group` = '$group'";
$selectResult1 = mysql_query($sql1);

$color = "#CCFFCC";
echo( "<table width=\"50%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">");
echo( "<tr><td><b>Date/Time</b></td><td><b>Subject</b></td></tr>");

while($row = mysql_fetch_array($selectResult1))
{
	$day = substr($row["date_time"], 8, 2);
	$month = substr($row["date_time"], 5, 2);
	$year = substr($row["date_time"], 0, 4);
	$hour = substr($row["date_time"], 11, 2);

	if($hour > 12)
	{
		$hour = $hour - 12;
		$meridian = "PM";
	}
	elseif($hour == 12)
	{
		$meridian = "PM";
	}
	elseif($hour == 0)
	{
		$hour = 12;
		$meridian = "AM";
	}
	else
	{
		$meridian = "AM";
	}

	$minute = substr($row["date_time"], 14, 2);
	
	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td>$month-$day-$year $hour:$minute $meridian</td><td>".$row["subject"]."</td></tr>");
	echo( "<tr><td></td><td>".$row["message"]."</td></tr>");
	
}
echo("</table>");
?>
