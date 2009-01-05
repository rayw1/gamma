<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

$id = mysql_real_escape_string($_POST["fid"]);

$sql1 = "SELECT * FROM `acord` WHERE `ID` = '$id'";
$selectResult1 = mysql_query($sql1);

$row = mysql_fetch_array($selectResult1);

echo( "<h1>Add Form</h1>" );
echo( "<form action=\"addForm2.php\" method=\"post\">" );
echo( "
	<p><b>Name:</b> <input class=\"blue\" type=\"text\" name=\"name\" size = \"32\"></p>
	<p><b>Number:</b> <input class=\"blue\" type=\"text\" name=\"number\" size = \"6\"></p>
	Data:<br>
	<p><textarea name=\"data\" cols=\"80\" rows=\"20\"></textarea></p>
	" );
echo( "<input type=\"Button\" value=\"Add\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );


?>
