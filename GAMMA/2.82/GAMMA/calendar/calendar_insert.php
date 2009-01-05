<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$uname = $_SESSION["username"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$subject = mysql_real_escape_string($_POST["subject"]);
$message = mysql_real_escape_string($_POST["message"]);
$message = nl2br($message);
$meridian = mysql_real_escape_string($_POST["meridian"]);
$hour = mysql_real_escape_string($_POST["hour"]);
$minute = mysql_real_escape_string($_POST["minute"]);
$visibility1 = mysql_real_escape_string($_POST["visibility"]);

if($visibility1)
{
	foreach ($visibility1 as $v)
	{
		$visibility2 .= $v;
		$visibility2 .= " ";
	}
}
else
{
	die("Visible to nobody");
}

$creator = mysql_real_escape_string($_POST["creator"]);

$dateTime = mysql_real_escape_string($_POST["year"]);
$dateTime .= "-";
$dateTime .= mysql_real_escape_string($_POST["month"]);
$dateTime .= "-";
$dateTime .= mysql_real_escape_string($_POST["day"]);
$dateTime .= " ";

if($meridian == "PM")
{
	if($hour != 12)
	{
		$hour = $hour + 12;
	}
	$dateTime .= $hour;
	$dateTime .= ":";
	$dateTime .= $minute;
	$dateTime .= ":00";
}
elseif($meridian == "AM")
{
	if($hour == 12)
	{
		$hour = 0;
	}
	$dateTime .= $hour;
	$dateTime .= ":";
	$dateTime .= $minute;
	$dateTime .= ":00";
}


$sql1 = "INSERT INTO `calendar` (`ID`, `subject`, `message`, `date_time`, `visibility`, `creator`, `Group`) VALUES ('', '$subject', '$message', '$dateTime', '$visibility2', '$creator', '$group')";
$insertresult = mysql_query($sql1);

if($insertresult == 0)
{
	log_error("Calendar Insert Failure: $sql1", "calendar_insert.php", $_SESSION["username"], $_SESSION["group"]);
	die( "ERROR" );
}
echo( "
<script>
location=\"calendar.php?month=".mysql_real_escape_string($_POST["month"])."&day=".mysql_real_escape_string($_POST["day"])."&year=".mysql_real_escape_string($_POST["year"])."&hour=".$hour."&min=".$minute."\";
</script> 
");
?>

