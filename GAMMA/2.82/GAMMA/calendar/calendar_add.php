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


echo( "<h1>Event Entry</h1>" );
echo( "<form action=\"calendar_insert.php\" method=\"post\">" );
echo( "Subject: <input class=\"blue\" type=\"text\" name=\"subject\" size=\"50\"><br>" );
echo( "Description: <br><textarea name=\"message\" cols=\"50\" rows=\"10\"></textarea><br>" );
echo( "Date: " );
month_drop(date("m"), "");
echo("/");
day_drop(date("d"), "");
echo("/");
year_drop(date("Y"), "");

echo( "<br>Time: <select name=\"hour\">" );
for($i=1; $i <= 12; $i++)
{
	echo( "<option value=\"".$i."\">".$i."</option>" );
}
echo( "</select>" );

echo( ":<select name=\"minute\">" );
for($i=0; $i < 60; $i++)
{
	$i2 = sprintf("%02d", $i);
	echo( "<option value=\"".$i2."\">".$i2."</option>" );
}
echo( "</select>" );

echo( " <select name=\"meridian\">" );
echo( "
<option value=\"AM\">AM</option>
<option value=\"PM\">PM</option>
");

echo( "</select><br>" );

echo( "Visible to (hold CTRL + Click to select multiple people): <br><select name=\"visibility[]\" size=\"10\" multiple=\"multiple\">");

$query = mysql_query("SELECT DISTINCT `username` FROM `users` WHERE `group` = '$group' OR `group` = 'all' ORDER BY `username`");
while($row = mysql_fetch_array($query)) 
{
  echo("<option value=\"".$row["username"]."\">".$row["username"]."</option>");
}

echo( "</select></td><td>" );

echo( "<input type=\"hidden\" name=\"creator\" value=\"".$uname."\">" );
echo( "<br><input type=\"Button\" value=\"Add\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>

