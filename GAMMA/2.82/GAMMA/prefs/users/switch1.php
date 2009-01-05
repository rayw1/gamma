<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];

$username = $_COOKIE["username"];
$password = $_COOKIE["password"];

if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

$sql1 = mysql_query("SELECT DISTINCT `office` FROM `users` WHERE `username` = '$username' AND `password` = '$password' AND `Group` = '$group'");

echo( "<form method=\"post\" action=\"switch2.php\">" );
echo( "<h1>Switch Office</h1>" );
echo( "<p>All changes discarded upon logoff</p>" );
echo( "Office: <select name=\"office\">");

while($row = mysql_fetch_array($sql1))
{
	echo("<option value=\"".$row["office"]."\">".$row["office"]."</option>");
	
}

echo( "</select><br>" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );
?>
