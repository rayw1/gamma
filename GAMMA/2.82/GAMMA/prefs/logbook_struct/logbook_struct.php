<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `logbook_struct` WHERE `office` = '$dbase' AND `group` = '$group'";

echo( "<html>" );

echo( "<h1>Log Book Structure</h1>" );

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Could not obtain logbook structure", "logbook_struct.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain logbook structure");
}

echo( "
<form action=\"logbook_struct_update.php\" method=\"post\">
<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );

$color = "#CCFFCC";
if($row = mysql_fetch_row($itemList))
{
	$num = count($row);
	for($i = 0; $i < $num; $i++)
	{
		$fieldname = mysql_field_name($itemList, $i);

		if($fieldname != "ID" && $fieldname != "office" && $fieldname != "group")
		{
			if($color == "white")
			{
				$color = "#CCFFCC";
			}
			else
			{
				$color = "white";
			}
			echo( "<tr style=\"background:" );
			echo( $color );
			echo( ";\">" );
			echo( "<td>" );
			echo($fieldname);
			echo( "</td><td>" );
			if($row[$i] == "Y")
			{
				echo( "<select name=\"$fieldname\">
				<option value=\"N\">Hidden</option>
				<option value=\"Y\" selected>Shown</option>" );
			}
			elseif($row[$i] == "N")
			{
				echo( "<select name=\"$fieldname\">
				<option value=\"N\" selected>Hidden</option>
				<option value=\"Y\">Shown</option>" );
			}
			elseif($row[$i] == "R")
			{
				echo( "<input class=\"blue\" name=\"$fieldname\" type=\"hidden\" value=\"R\">Required" );
			}
			else 
			{
				log_error("Bad value in logbook structure", "logbook_struct.php", $_SESSION["username"], $_SESSION["group"]);
				echo( "ERROR" );
			}
			echo("</td></tr>");
		}
	}
}
echo( "</table>
<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">
</form>
" );
?>
