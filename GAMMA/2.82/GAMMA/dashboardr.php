<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/includes/common.inc');
include(getcwd().'/includes/weather.inc');
include(getcwd().'/includes/rss.inc');
if($_SESSION["validsession"] != 1)
{
	die( "Invalid Session" );
}
$admin = $_SESSION["admin"];
$uname = $_SESSION["username"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];

echo( "<head> <META HTTP-EQUIV=\"Refresh\" CONTENT=\"1800; URL=dashboardr.php\"></head>" );
style("white");

//==================================
//=         Ticker Code            =
//==================================
echo( "
<div id=\"tempholder\"></div>
<script language=\"JavaScript\" src=\"dhtmllib.js\"></script>
<script language=\"JavaScript\" src=\"scroller.js\"></script>
<script language=\"JavaScript\">

/*
Mike's DHTML scroller (By Mike Hall)
Last updated July 21st, 02' by Dynamic Drive for NS6 functionality
For this and 100's more DHTML scripts, visit http://www.dynamicdrive.com
*/

//SET SCROLLER APPEARANCE AND MESSAGES
var myScroller1 = new Scroller(0, 0, 650, 32, 1, 5); //(xpos, ypos, width, height, border, padding)
myScroller1.setColors(\"#000000\", \"#ffffff\", \"#000000\"); //(fgcolor, bgcolor, bdcolor)
myScroller1.setFont(\"Verdana,Arial,Helvetica\", 2);
//myScroller1.addItem(\"<b>Click here for <a href='http://dynamicdrive.com'>Dynamic Drive</a>, the net\'s #1 DHTML site!</b>\");
myScroller1.addItem(\"You are logged in as: $uname in office $dbase in group $group Administrative Level: $admin\");
");

//Do we need to display any franchise billing messages?  This will find out and display them.
connect_to();

$thisYear = date("Y");
$thisMonth = date("m");

$sql0 = "SELECT * FROM `franchise_bills` WHERE `office` = '$dbase' AND `sent` = 'yes' AND `received` = 'no'";
$selectResult0 = mysql_query($sql0);


if($row = mysql_fetch_array($selectResult0) && $admin >= 2)
{
	$row = mysql_fetch_array($selectResult0);
	$due = $row["due"];
	$month = substr($due, 5, 2);
	$day = substr($due, 8, 2);
	$year = substr($due, 0, 4);
	$timestamp = date("Ymd", mktime(0,0,0,$month,$day,$year));
	$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
	
	if ($timestamp >= $timestamp2)
	{
		echo( "myScroller1.addItem(\"<b>Your online statement is available for viewing</b>\");" );
	}
	else
	{
		echo( "myScroller1.addItem(\"<b>Your online statement is overdue!</b>\");" );
	}
}
//----------------------------------------------------

//What about upcoming homeowners?
connect_to();
$today = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
$today45 = date("Ymd",mktime(0,0,0,date("m"),date("d")+45,date("Y")));

$today = $today;
$today45 = $today45;

$sql3 = "SELECT * FROM `customer_general` WHERE `ReminderDate1` > '$today' AND `ReminderDate1` <= '$today45' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult3 = mysql_query($sql3);
$numRenewals = mysql_num_rows($selectResult3);

$sql4 = "SELECT * FROM `customer_general` WHERE `ReminderDate2` > '$today' AND `ReminderDate2` <= '$today45' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult4 = mysql_query($sql4);
$numRenewals = $numRenewals + mysql_num_rows($selectResult4);

$sql5 = "SELECT * FROM `customer_general` WHERE `ReminderDate3` > '$today' AND `ReminderDate3` <= '$today45' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult5 = mysql_query($sql5);
$numRenewals = $numRenewals + mysql_num_rows($selectResult5);

echo( "myScroller1.addItem(\"<a href='http://www.gammaams.com/customer/customer_reminders.php'>You have $numRenewals upcoming Reminders</a>\");" );

//-----------------------------------------------------

//Weather
$sql4 = "SELECT `ICAO` FROM `statistics` WHERE `Database` = '$dbase'";
$selectResult4 = mysql_query($sql4);
$resultRow4 = mysql_fetch_array($selectResult4);

$station = $resultRow4["ICAO"];
$wxInfo['STATION'] = $station;
$metar = get_metar($station,$wxInfo);
process_metar($metar,$wxInfo);
echo( "myScroller1.addItem(\"");

print_wxInfo($wxInfo);

echo( "\");" );

//-----------------------------------------------------

//News
$sql5 = "SELECT `RSS` FROM `statistics` WHERE `Database` = '$dbase'";
$selectResult5 = mysql_query($sql5);
$resultRow5 = mysql_fetch_array($selectResult5);
$rss_xml = $resultRow5["RSS"];

$rss_feeds = return_xml_array($rss_xml, "feed");
$feed = new GAMMA_RSS();
foreach ($rss_feeds as $single_feed)
{
	$rss_host = return_xml($single_feed, "host");
	$rss_location = return_xml($single_feed, "location");
	$feed->fetch($rss_host, $rss_location);
	$feed->display("myScroller1.addItem(\"","\");");
}
//-----------------------------------------------------
echo( "//SET SCROLLER PAUSE
myScroller1.setPause(2500); //set pause beteen msgs, in milliseconds

function runmikescroll() {

  var layer;
  var mikex, mikey;

  // Locate placeholder layer so we can use it to position the scrollers.

  layer = getLayer(\"placeholder\");
  mikex = getPageLeft(layer);
  mikey = getPageTop(layer);

  // Create the first scroller and position it.

  myScroller1.create();
  myScroller1.hide();
  myScroller1.moveTo(mikex, mikey);
  myScroller1.setzIndex(100);
  myScroller1.show();
}

window.onload=runmikescroll
</script>
<div id=\"placeholder\" style=\"position:relative; width:420px; height:32px;\"> </div>
");
//==================================
//=           End Ticker           =
//==================================

//==================================
//=    Dashboard Messages Code     =
//==================================

//do stickys first
$sql2 = "SELECT * FROM `messages` WHERE `Sticky` = 'yes' AND `Group` = '$group' ORDER BY `Date` DESC,`level` DESC";
$selectResult2 = mysql_query($sql2);
while($row2 = mysql_fetch_array($selectResult2))
{
	if($date != $row2["Date"])
	{
		$date = $row2["Date"];
		
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8,2);

		$timestamp = mktime(0,0,0,$month,$day,$year);
		$Tdate = getdate($timestamp);

		$todayWestern = $Tdate["weekday"]." ".$Tdate["month"]." ".$Tdate["mday"].", ".$Tdate["year"];

		if($Tdate["mon"] < 10)
		{
			$mon = "0".$Tdate["mon"];
		}
		else
		{
			$mon = $Tdate["mon"];
		}
		$jumpDate = $Tdate["year"].$mon.$Tdate["mday"];
		if($admin >= 3)
		{
			echo("<a href=\"admin/messages/messages1.php?date=$jumpDate\"><b>Sticky</b></a><img src=\"images/sticky.gif\" border=\"0\"><br>");
		}
		else 
		{
			echo("<b>Sticky</b><img src=\"images/sticky.gif\" border=\"0\"><br>");
		}
	}
	echo($row2["Message"]."<br><br>");
}

$date = 0;

//Define 2 timestamps.  Today and 5 days ago
$timestamp1 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d")-5,date("Y")));

$newTime1 = substr($timestamp1,0,4)."-";
$newTime1 .= substr($timestamp1,4,2)."-";
$newTime1 .= substr($timestamp1,6,2);

$newTime2 = substr($timestamp2,0,4)."-";
$newTime2 .= substr($timestamp2,4,2)."-";
$newTime2 .= substr($timestamp2,6,2);

$newTime1 = mysql_real_escape_string($newTime1);
$newTime2 = mysql_real_escape_string($newTime2);

$sql1 = "SELECT * FROM `messages` WHERE `level` <= '$admin' AND `Group` = '$group' AND (`Date` <= '$newTime1' AND `Date` >= '$newTime2') AND `Sticky` = 'no' ORDER BY `Date` DESC,`level` DESC";
$selectResult1 = mysql_query($sql1);

if($selectResult1 == 0)
{
	log_error("Could not select from messages: $sql", "dashboardr.php", $_SESSION["username"], $_SESSION["group"]);
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

echo( "<a href=\"dashboardrkive.php?backMonth=0\">Archived Messages</a><br>");


?>
