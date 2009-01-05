<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 3)
{
  die("ADMIN TOO LOW");
}

echo( "<h1>Mass Email Creation</h1>" );
echo( "<form action=\"massemail_Office2.php\" method=\"post\">" );
echo( "
<p><b>Subject:</b> <input class=\"blue\" type=\"text\" name=\"subject\" size = \"50\"></p>
<p><b>From Email:</b> <input class=\"blue\" type=\"text\" name=\"from\" size = \"50\"></p>
Message:<br>
<p><textarea name=\"body\" cols=\"80\" rows=\"20\"></textarea></p>
" );
echo( "Office: <select name=\"office\">");

connect_to();
$sql1 = mysql_query("SELECT * FROM `statistics` WHERE `Group` = '$group'");
while($row = mysql_fetch_array($sql1))
{
	echo("<option value=\"".$row["Database"]."\">".$row["DisplayName"]."</option>");
	
}

echo( "</select><br>" );
echo( "<input type=\"Button\" value=\"Send\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );

echo( "Email to <a href=\"massemail.php\">All</a> / Office / <a href=\"massemail_Zip.php\">Zip Code</a> / <a href=\"massemail_bday.php\">Birthdays</a>" );
?>
