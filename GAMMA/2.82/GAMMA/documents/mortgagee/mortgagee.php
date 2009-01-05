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

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">");
echo( "<h1>Add to Mortgagee list</h1>" );
echo( "<form method=\"post\" action=\"mortgagee_add.php\">" );
echo( "<tr><td>Name:</td><td><input class=\"blue\" type=\"text\" name=\"name\"></td></tr>" );
echo( "<tr><td>Address:</td><td><input class=\"blue\" type=\"text\" name=\"address\"></td></tr>" );
echo( "<tr><td>City:</td><td><input class=\"blue\" type=\"text\" name=\"city\"></td></tr>" );
echo( "<tr><td>State:</td><td><input class=\"blue\" type=\"text\" name=\"state\"></td></tr>" );
echo( "<tr><td>Zip:</td><td><input class=\"blue\" type=\"text\" name=\"zip\"></td></tr>" );
echo( "</table>");
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );
?>
