<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$id = mysql_real_escape_string($_GET["id"]);

$query2 = mysql_query("SELECT * FROM `calendar` WHERE `ID` = '$id'");
$row2 = mysql_fetch_array($query2);

if($row2["creator"] != $uname)
{
	die( "You are not the creator of this calendar object" );
}

$day = substr($row2["date_time"], 8, 2);
$month = substr($row2["date_time"], 5, 2);
$year = substr($row2["date_time"], 0, 4);
$hour = substr($row2["date_time"], 11, 2);

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

$minute = substr($row2["date_time"], 14, 2);



echo( "<h1>Event Edit</h1>" );
echo( "<form action=\"calendar_update.php\" method=\"post\">" );
echo( "<input type=\"hidden\" name=\"id\" value=\"".$id."\">" );
echo( "Subject: <input class=\"blue\" type=\"text\" name=\"subject\" size=\"50\" value=\"".$row2["subject"]."\"><br>" );

$message = $row2["message"];
$bad = array("<br>", "<br />");
$good  = "";

$message = str_replace($bad, $good, $message);

echo( "Description: <br><textarea name=\"message\" cols=\"50\" rows=\"10\">".$message."</textarea><br>" );
echo( "Date: " );
month_drop($month, "");
echo("/");
day_drop($day, "");
echo("/");
year_drop($year, "");

echo( "<br>Time: <select name=\"hour\">" );
for($i=1; $i <= 12; $i++)
{
	echo( "<option value=\"".$i."\"" );
	if($hour == $i)
	{
		echo( "selected" );
	}
	echo( ">".$i."</option>" );
}
echo( "</select>" );

echo( ":<select name=\"minute\">" );
for($i=0; $i < 60; $i++)
{
	$i2 = sprintf("%02d", $i);
	echo( "<option value=\"".$i2."\"" );
	if($minute == $i)
	{
		echo( "selected" );
	}
	echo( ">".$i2."</option>" );
}
echo( "</select>" );

echo( " <select name=\"meridian\">" );
echo( "
<option value=\"AM\"" );
if($meridian == "AM")
{
	echo( "selected" );
}
echo( ">AM</option>
<option value=\"PM\"" );
if($meridian == "PM")
{
	echo( "selected" );
}
echo( ">PM</option>" );

echo( "</select><br>" );

echo( "Visible to (hold CTRL + Click to select multiple people): <br><select name=\"visibility[]\" size=\"10\" multiple=\"multiple\">");

$query = mysql_query("SELECT DISTINCT `username` FROM `users` WHERE `group` = '$group' ORDER BY `username`");
while($row = mysql_fetch_array($query))
{
	echo("<option value=\"".$row["username"]."\" " );

	if(strpos($row2["visibility"], $id2[$v]) !== FALSE)
	{
		echo( "selected" );
	}
	echo( ">".$row["username"]."</option>");
}

echo( "</select></td><td>" );

echo( "<input type=\"hidden\" name=\"creator\" value=\"".$uname."\">" );
echo( "<br><input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>

