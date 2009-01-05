<?php
//GAMMA V2.7 CERTIFIED
session_start();
if($_SESSION["validsession"] != 1)
{
	die( "Invalid Session" );
}
$admin = $_SESSION["admin"];
$uname = $_SESSION["username"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];

include(getcwd().'/includes/common.inc');
style("white");
echo( "You are logged in as: ".$uname." in office ".$dbase." in group ".$group." Administrative Level: ".$admin );
echo( "<br><br>" );

$x = mysql_real_escape_string($_GET["backMonth"]);
$y = $x+1;

//==================================
//=    Dashboard Messages Code     =
//==================================

//Define 2 timestamps.  Today and 5 days ago
$timestamp1 = date("Ymd",mktime(0,0,0,date("m")-$x,date("d"),date("Y")));
$timestamp2 = date("Ymd",mktime(0,0,0,date("m")-$y,date("d"),date("Y")));

$newTime1 = substr($timestamp1,0,4)."-";
$newTime1 .= substr($timestamp1,4,2)."-";
$newTime1 .= substr($timestamp1,6,2);

$newTime2 = substr($timestamp2,0,4)."-";
$newTime2 .= substr($timestamp2,4,2)."-";
$newTime2 .= substr($timestamp2,6,2);

$newTime1 = $newTime1;
$newTime2 = $newTime2;

connect_to();
$sql1 = "SELECT * FROM `messages` WHERE `level` <= '$admin' AND `Group` = '$group' AND (`Date` <= '$newTime1' AND `Date` >= '$newTime2') ORDER BY `Date` DESC,`level` DESC";
$selectResult1 = mysql_query($sql1);

if($selectResult1 == 0)
{
	log_error("Could not select from messages: $sql1", "dashboardrkive.php", $_SESSION["username"], $_SESSION["group"]);
	echo("Error getting dashboard messages");
}

while($row = mysql_fetch_array($selectResult1))
{
	if($date != $row["Date"])
	{
		$date = $row["Date"];
		
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8,2);
		
		$timestamp = mktime(0,0,0,$month,$day,$year);
		$Tdate = getdate($timestamp);

		$todayWestern = $Tdate["weekday"]." ".$Tdate["month"]." ".$Tdate["mday"].", ".$Tdate["year"];
		
		if($admin >= 3)
		{
			if($Tdate["mon"] < 10)
			{
				$mon = "0".$Tdate["mon"];
			}
			else 
			{
				$mon = $Tdate["mon"];
			}
			$jumpDate = $Tdate["year"].$mon.$Tdate["mday"];
			echo("<a href=\"admin/messages/messages1.php?date=$jumpDate\"><b>$todayWestern</b></a><br>");
		}
		else 
		{		
			echo("<b>$todayWestern</b><br>");
		}
	}	
	echo($row["Message"]."<br><br>");
}

echo( "<a href=\"dashboardrkive.php?backMonth=$y\">Archived Messages</a><br>");

?>
