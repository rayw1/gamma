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

echo( "<h1>Add to Farmers list</h1>" );
echo( "<form method=\"post\" action=\"farmerslist_add.php\">" );
echo( "Name: <input class=\"blue\" type=\"text\" name=\"name\"><br>" );
echo( "Location: <input class=\"blue\" type=\"text\" name=\"location\"><br>" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

?>
