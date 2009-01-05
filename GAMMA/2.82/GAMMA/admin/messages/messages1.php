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

if($_GET["date"] == "")
{
	//Define 2 timestamps.  Today, and yesterday
	$timestamp1 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
	$backstamp1 = date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y")));

	$newTime1 = substr($timestamp1,0,4)."-";
	$newTime1 .= substr($timestamp1,4,2)."-";
	$newTime1 .= substr($timestamp1,6,2);

	$oldTime1 = substr($backstamp1,0,4)."-";
	$oldTime1 .= substr($backstamp1,4,2)."-";
	$oldTime1 .= substr($backstamp1,6,2);
}
else
{
	$timestamp1 = mysql_real_escape_string($_GET["date"]);
	
	$comeback = mysql_real_escape_string($_GET["date"]);
	
	$passYear = substr($timestamp1,0,4)."-";
	$passMonth = substr($timestamp1,4,2)."-";
	$passDay = substr($timestamp1,6,2);
	
	$timestamp1 = date("Ymd",mktime(0,0,0,$passMonth,$passDay,$passYear));
	$backstamp1 = date("Ymd",mktime(0,0,0,$passMonth,$passDay-1,$passYear));
	
	$newTime1 = substr($timestamp1,0,4)."-";
	$newTime1 .= substr($timestamp1,4,2)."-";
	$newTime1 .= substr($timestamp1,6,2);

	$oldTime1 = substr($backstamp1,0,4)."-";
	$oldTime1 .= substr($backstamp1,4,2)."-";
	$oldTime1 .= substr($backstamp1,6,2);
}

$displayDate = substr($timestamp1,4,2)."-";
$displayDate .= substr($timestamp1,6,2)."-";
$displayDate .= substr($timestamp1,0,4);

$sql1 = "SELECT * FROM `messages` WHERE `level` <= '$admin' AND `Group` = '$group' AND `Date` = '$newTime1' ORDER BY `level` DESC";
$selectResult1 = mysql_query($sql1);

echo( "<form method=\"post\" action=\"messages2.php\">" );
echo( "<h1>Dashboard Messages for $displayDate</h1>" );
echo( "<a href=\"messages1.php?date=$backstamp1\">Back one day</a><br>");

for($i = 3; $i >= 0; $i--)
{
	$sql1 = "SELECT * FROM `messages` WHERE `level` = '$i' AND `Group` = '$group' AND `Date` = '$newTime1'";
	$selectResult1 = mysql_query($sql1);
	if($row = mysql_fetch_array($selectResult1))
	{
		$message = $row["Message"];
		$bad = array("<br>", "<br />");
		$good  = "";

		$message = str_replace($bad, $good, $message);

		echo( "<h3>Messages for users that are level: ".$row["level"]."</h3>" );
		echo( "<textarea name=\"message".$row["level"]."\" cols=\"100\" rows=\"10\">".$message."</textarea><br>" );
		echo( "Sticky: <label> <input type=\"radio\" name=\"sticky".$row["level"]."\" value=\"yes\"");
		if($row["Sticky"] == "yes")
		{
			echo("checked");
		}
		echo( ">Yes</label>
		<label><input class=\"blue\" name=\"sticky".$row["level"]."\" type=\"radio\" value=\"no\"");
		if($row["Sticky"] == "no")
		{
			echo( "checked" );
		}
		echo( ">No</label><br>");
		echo( "<input type=\"hidden\" name=\"active$i\" value=\"yes\">");
	}
	else
	{
		echo("No data exists for level $i on ".convertDate($newTime1).".  Would you like to <a href=\"messages_create.php?date=".$newTime1."&number=$i\">create</a>?<br>");
		echo( "<input type=\"hidden\" name=\"active$i\" value=\"no\">");
	}
}
echo( "<input type=\"hidden\" name=\"Date\" value=\"$newTime1\">");
echo( "<input type=\"hidden\" name=\"comeback\" value=\"$comeback\">");
echo( "<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );
?>
