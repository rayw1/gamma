<?php
//GAMMA V2.7 CERTIFIED
session_start();
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
include(getcwd().'/../includes/common.inc');
style("white");

echo( "<form method=\"post\" action=\"create2.php\">" );
echo( "<h1>Create Office</h1>" );
echo( "<p>Please insert name of office:<br>
Note: ONLY letters and numbers, no spaces</p>" );
echo( "Office: <input class=\"blue\" name=\"office\" type=\"text\"><br>
Office Number: <input class=\"blue\" name=\"onum\" type=\"text\"><br>
Group Code: <input class=\"blue\" name=\"gcode\" type=\"text\"><br>");

echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );
?>
