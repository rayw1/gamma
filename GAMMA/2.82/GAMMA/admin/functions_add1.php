<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = mysql_real_escape_string($_SESSION["admin"]);
$group = mysql_real_escape_string($_SESSION["group"]);
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 99)
{
	die("ADMIN TOO LOW");
}
include(getcwd().'/../includes/common.inc');
style("white");

echo( "<h1>Add Function</h1>" );

connect_to();

$sql0 = "SELECT * FROM `functions` WHERE `Group` = '$group' && `Admin` <= '$admin' ORDER BY `Group`, `Name";
$selectResult0 = mysql_query($sql0);

echo( "<form action=\"functions_add2.php\" method=\"post\">" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );
echo( "<tr><td><b>Name</b></td><td><b>Link</b></td><td><b>Group</b></td><td><b>Admin</b></td></tr>" );

echo( "<tr><td><input class=\"blue\" name=\"name\"></td><td><textarea name=\"link\" cols=\"45\"></textarea></td><td>".$group."</td><td><select name=\"admin\">" );

for($j = 0; $j <= $admin; $j++)
{
	echo( "<option value=\"".$j."\">".$j."</option>" );
}

echo( "</td></tr>" );

echo( "<input type=\"hidden\" name=\"total_num\" value=\"".$i."\">" );
echo( "</table>" );
echo( "<input type=\"Button\" value=\"Add\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );
?>
