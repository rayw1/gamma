<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 2)
{
  die("ADMIN TOO LOW");
}

echo( "<h1>Mass Email Creation</h1>" );
echo( "<form action=\"massemail_myOffice2.php\" method=\"post\">" );
echo( "
<p><b>Subject:</b> <input class=\"blue\" type=\"text\" name=\"subject\" size = \"50\"></p>
<p><b>From Email:</b> <input class=\"blue\" type=\"text\" name=\"from\" size = \"50\"></p>
Message:<br>
<p><textarea name=\"body\" cols=\"80\" rows=\"20\"></textarea></p>
" );
echo( "Office: <input type=\"hidden\" name=\"office\" value=\"".$dbase."\">".$dbase."<br>");
echo( "<input type=\"Button\" value=\"Send\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );

?>
