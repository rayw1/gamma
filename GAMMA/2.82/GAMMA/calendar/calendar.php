<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$uname = $_SESSION["username"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

echo( "<head>

<SCRIPT TYPE=\"text/javascript\">
<!--
function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=400,height=200,scrollbars=no');
return false;
}
//-->
</SCRIPT>

" );


$passDay = mysql_real_escape_string($_GET["day"]);
$passMonth = mysql_real_escape_string($_GET["month"]);
$passYear = mysql_real_escape_string($_GET["year"]);
$passHour = mysql_real_escape_string($_GET["hour"]);
$passMin = mysql_real_escape_string($_GET["min"]);

$todayStart = $passYear."-".$passMonth."-".$passDay." ".$passHour.":".$passMin.":00";
$todayEnd = $passYear."-".$passMonth."-".$passDay." 23:59:59";

$timestamp = mktime(0,0,0,$passMonth,$passDay,$passYear);
$Tdate = getdate($timestamp);

$todayWestern = $Tdate["weekday"]." ".$Tdate["month"]." ".$passDay.", ".$passYear;

echo( "<h1>Events for ".$todayWestern."</h1>" );

echo( "<p><a href = \"calendar_add.php\"><img src=\"../images/add.gif\" border=\"0\"></a></p>" );


$sql1 = "SELECT * FROM `calendar` WHERE `date_time` >= '$todayStart' AND `date_time` <= '$todayEnd' AND `visibility` LIKE '%$uname%' AND `Group` = '$group'";
$selectResult1 = mysql_query($sql1);

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );
echo( "<tr><td><b>Time</b></td><td><b>Subject</b></td><td><b>Edit</b></td><td><b>Delete</b></td></tr> ");

$color = "#CCFFCC";
while($row = mysql_fetch_array($selectResult1))
{
	$hour = substr($row["date_time"], 11, 2);
	$minute = substr($row["date_time"], 14, 2);

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

	if($color == "white")
	{
		$color = "#CCFFCC";
	}
	else
	{
		$color = "white";
	}

	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\">" );
	echo( "<td>".$hour.":".$minute." ".$meridian."</td><td>
	<A HREF=\"calendar_details.php?id=".$row["ID"]."\" onClick=\"return popup(this, 'details".$row["ID"]."')\">
	".$row["subject"]."</a></td>" );
	
	
	if($row["creator"] == $uname)
	{
		echo( "<td><a href=\"calendar_edit.php?id=".$row["ID"]."\"><img src=\"../images/edit.gif\" border=\"0\"></a></td>" );
		echo( "<td><a href=\"calendar_delete.php?id=".$row["ID"]."\"><img src=\"../images/delete.gif\" border=\"0\"></a></td>" );		
	}
	else 
	{
		echo( "<td></td><td></td>" );
	}
	echo( "</tr>" );
}

echo("</table><br><br><br>");

//What day was the first of the month?
$day[0] = "Sunday";
$day[1] = "Monday";
$day[2] = "Tuesday";
$day[3] = "Wednesday";
$day[4] = "Thursday";
$day[5] = "Friday";
$day[6] = "Saturday";

$timestamp = mktime(0,0,0,$passMonth,01,$passYear);
$Fdate = getdate($timestamp);

if($Fdate["weekday"] == "Sunday")
{
	$firstDay = 0;
}
elseif($Fdate["weekday"] == "Monday")
{
	$firstDay = 1;
}
elseif($Fdate["weekday"] == "Tuesday")
{
	$firstDay = 2;
}
elseif($Fdate["weekday"] == "Wednesday")
{
	$firstDay = 3;
}
elseif($Fdate["weekday"] == "Thursday")
{
	$firstDay = 4;
}
elseif($Fdate["weekday"] == "Friday")
{
	$firstDay = 5;
}
elseif($Fdate["weekday"] == "Saturday")
{
	$firstDay = 6;
}

if($passMonth == "01" or $passMonth == "03" or $passMonth == "05" or $passMonth == "07" or $passMonth == "08" or $passMonth == "10" or $passMonth == "12")
{
	$daysInMonth = "31";
}
elseif($passMonth == "02")
{
	if(is_int($passYear/4))
	{
		$daysInMonth = "29";
	}
	else
	{
		$daysInMonth = "28";
	}
}
else
{
	$daysInMonth = "30";
}

if($passMonth != 1)
{
	$prevMonth = $passMonth - 1;
	$prevYear = $passYear;
}
else
{
	$prevMonth = 12;
	$prevYear = $passYear - 1;
}

if($passMonth != 12)
{
	$nextMonth = $passMonth + 1;
	$nextYear = $passYear;
}
else
{
	$nextMonth = 1;
	$nextYear = $passYear + 1;
}

$nextStamp = mktime(0,0,0,$nextMonth,1,$nextYear);
$nextDate = getdate($nextStamp);

$prevStamp = mktime(0,0,0,$prevMonth,1,$prevYear);
$prevDate = getdate($prevStamp);

echo( "<center><table border=\"1\" cellspacing=\"1\" cellpadding=\"4\"><tr height=\"50\">
<td colspan=\"2\"><center><font size=\"1pt\"><a href = \"calendar.php?month=".$prevMonth."&day=01&year=".$prevYear."&hour=00&min=00\"> ".$prevDate["month"]." </a></font></center></td>
<td colspan=\"3\"><center><font size=\"6pt\"> ".$Tdate["month"]." </font></center></td>
<td colspan=\"2\"><center><font size=\"1pt\"><a href = \"calendar.php?month=".$nextMonth."&day=01&year=".$nextYear."&hour=00&min=00\"> ".$nextDate["month"]." </a></font></center></td>
</tr>" );
echo( "<tr><td>Sunday</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td></tr>" );

$laidDown = 0;
$blankSpaces = $firstDay;

for($i = 0; $i < $blankSpaces; $i++)
{
	if($laidDown == 0)
	{
		echo("<tr height=\"50\">");
	}
	echo("<td width=\"100\"> </td>");
	$laidDown++;
	if($laidDown == 7)
	{
		echo("</tr>");
		$laidDown = 0;
	}
}
for($i = 1; $i <= $daysInMonth; $i++)
{
	$DayStart = $passYear."-".$passMonth."-".$i." 00:00:00";
	$DayEnd = $passYear."-".$passMonth."-".$i." 23:59:59";

	$sql2 = "SELECT * FROM `calendar` WHERE `date_time` >= '$DayStart' AND `date_time` <= '$DayEnd' AND `visibility` LIKE '%$uname%' AND `Group` = '$group'";
	$selectResult2 = mysql_query($sql2);
	$numOfResults = mysql_numrows($selectResult2);

	if($laidDown == 0)
	{
		echo("<tr height=\"50\">");
	}
	if($numOfResults > 0)
	{
		echo( "<td width=\"100\"><a href=\"calendar.php?month=".$passMonth."&day=".$i."&year=".$passYear."&hour=00&min=00\">".$i."</a><br>Events: ".$numOfResults."</td>" );
	}
	else
	{
		echo( "<td width=\"100\">".$i."</td>" );
	}
	$laidDown++;
	if($laidDown == 7)
	{
		echo("</tr>");
		$laidDown = 0;
	}
}
if($laidDown != 0)
{
	for($i = $laidDown; $i < 7; $i++)
	{
		echo("<td width=\"100\"> </td>");
	}
	echo("</tr>");
}

echo( "</table></center>" );


//unlocked calendar code
$sql3 = "SELECT * FROM `users` WHERE `calendar` = 'unlocked' AND (`Group` = '$group' OR `Group` = 'all')";
$selectResult3 = mysql_query($sql3);
echo( "<form action=\"calendar_unlocked.php\" method=\"post\">" );
echo( "View unlocked calendar: " );
echo( "<select name=\"toView\">");

while($row = mysql_fetch_array($selectResult3))
{
	echo( "<option value=\"".$row["username"]."\">".$row["username"]."</option>");
}

echo("</select><br>
<input type=\"Button\" value=\"View\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">
</form>");
?>
