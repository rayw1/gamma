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
if($admin < 2)
{
	die( "Admin too low" );
}

echo( "<h1>Make Recipient</h1>" );

echo( "<form action=\"makerecipient2.php\" method=\"POST\">" );
echo( "Recipient Name: <input class=\"blue\" name=\"recipient\">" );
echo( "<br><input type=\"Button\" value=\"Create\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

?>
