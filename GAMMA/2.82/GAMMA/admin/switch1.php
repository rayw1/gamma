<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = mysql_real_escape_string($_SESSION["group"]);
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}


$sql1 = mysql_query("SELECT DISTINCT `Database` FROM statistics WHERE `Group` = '$group'");

echo( "<form method=\"post\" action=\"switch2.php\">" );
echo( "<h1>Switch Office</h1>" );
echo( "<p>All changes discarded upon logoff</p>" );
echo( "Office: <select name=\"office\">");


while($row = mysql_fetch_array($sql1))
{
	echo("<option value=\"".$row["Database"]."\">".$row["Database"]."</option>");
	
}

echo( "</select><br>" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );
?>
