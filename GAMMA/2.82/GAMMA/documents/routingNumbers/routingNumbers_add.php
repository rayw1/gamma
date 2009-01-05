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
$sql1 = "SELECT * FROM `routingnumbers` LIMIT 1";
$itemList1 = mysql_query($sql1);

if($itemList1 == 0)
{
	log_error("Routing Numbers Select Failure: $sql1", "routingNumbers_add.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not get Routing Number info");
}

echo( "<h1>Routing Numbers Entry</h1>" );
echo( "<form action=\"routingNumbers_add2.php\" method=\"post\">" );

echo( "<table>" );

if($row1 = mysql_fetch_row($itemList1))
{
	$num = count($row1);

	for($i = 0; $i < $num; $i++)
	{
		$fieldname = mysql_field_name($itemList1, $i);
		if($fieldname != "ID")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			echo( "<input class=\"blue\" type=\"text\" name = \"" );
			echo( $fieldname );
			echo( "\">" );
			echo("</td></tr>");
		}
	}
}

echo( "</table>" );

echo( "<input type=\"Button\" value=\"Add\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>
