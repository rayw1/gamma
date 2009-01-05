<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$user = $_SESSION["username"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../includes/common.inc');
include(getcwd().'/../includes/insurance.inc');
style("white");
connect_to();
$lnum = $_GET["lid"];
$sql = "SELECT * FROM `logbook` WHERE `Number` = '$lnum' AND `office` = '$dbase' AND `group` = '$group'";
$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Failed to select logbook info $sql", "logbook_edit.php", $user, $group);
}

$sql2 = "SELECT * FROM `logbook_struct` WHERE `office` = '$dbase' AND `group` = '$group'";
$selectResult2 = mysql_query($sql2);

if($selectResult2 == 0)
{
	log_error("Failed to select logbook structure $sql2", "logbook_edit.php", $user, $group);
}

$structRow = mysql_fetch_array($selectResult2);

echo( "<h1>Log Book Edit</h1>" );
echo( "<form action=\"logbook_update.php\" method=\"post\">" );
echo( "<input type=\"hidden\" name =\"lid\" value=\"".$lnum."\">" );
echo( "<input type=\"hidden\" name =\"yPass\" value=\"".$_GET["yPass"]."\">" );
echo( "<input type=\"hidden\" name =\"mPass\" value=\"".$_GET["mPass"]."\">" );


echo( "<table cellpadding=\"4\" border = \"0\"><tr><td>" );
echo( "<b>Delete this record:</b></td><td><a href = \"logbook_delete.php?lid=" );
echo( $lnum );
echo( "\"><img src = \"../images/delete.gif\" border = \"0\"></a></td></tr>" );

if($row = mysql_fetch_row($itemList))
{
	$num = count($row);

	for($i = 0; $i < $num; $i++)
	{
		$customfield = 0;
		$fieldname = mysql_field_name($itemList, $i);

		if($structRow[$fieldname] != "N")
		{

			if($fieldname == "Type")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				polTypeDrop($row[$i]);
				$customfield = 1;
			}

			if($fieldname == "Date")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				$currently = $row[$i];
				month_drop(substr($currently, 5, 2), "");
				day_drop(substr($currently, 8, 2), "");
				year_drop(substr($currently, 0, 4), "");
				$customfield = 1;
			}

			if($fieldname == "Company")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				list_companies($row[$i], "");
				$customfield = 1;
			}

			if($fieldname == "Referred")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				referralDrop($row[$i]);
				$customfield = 1;
			}

			if($fieldname == "Agent")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				list_agents($dbase, $row[$i]);
				$customfield = 1;
			}

			if($fieldname == "Commission_Paid")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>
    			<input class=\"blue\" name=\"Commission_Paid\" type=\"checkbox\" value=\"yes\" " );
				if($row[$i] == "yes")
				{
					echo("checked");
				}
				echo( ">" );
				$customfield = 1;
			}

			if($fieldname == "Number" || $fieldname == "office" || $fieldname == "group")
			{
				$customfield = 1;
				echo( "<input type=\"hidden\" name=\"$fieldname\" value=\"".$row[$i]."\">");
			}

			if($customfield != 1)
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				echo( "<input class=\"blue\" type=\"text\" name = \"" );
				echo( $fieldname );
				echo( "\" value=\"".$row[$i]."\">" );
			}

			echo("</td></tr>");
		}
	}
}
echo( "</table>" );
echo( "<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>

