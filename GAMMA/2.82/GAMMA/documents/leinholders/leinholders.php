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

echo( "<h1>Add to Leinholders list</h1>" );
echo( "<form method=\"post\" action=\"leinholders_add.php\">" );
echo( "Name: <input class=\"blue\" type=\"text\" name=\"name\"><br>" );
echo( "Address: <input class=\"blue\" type=\"text\" name=\"address\"><br>" );
echo( "City: <input class=\"blue\" type=\"text\" name=\"city\"><br>" );
echo( "State: <input class=\"blue\" type=\"text\" name=\"state\"><br>" );
echo( "Zip: <input class=\"blue\" type=\"text\" name=\"zip\"><br>" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

?>
