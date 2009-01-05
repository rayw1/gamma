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
	log_error("Could not obtain logbook structure", "logbook_struct_update.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain logbook structure");
}

$color = "#CCFFCC";
if($row = mysql_fetch_row($itemList))
{
	$num = count($row);
	for($i = 0; $i < $num; $i++)
	{
		$fieldname = mysql_field_name($itemList, $i);

		if($fieldname != "ID" && $fieldname != "office" && $fieldname != "group")
		{
			if($_POST[$fieldname] == $row[$i])
			{
			}
			elseif($_POST[$fieldname] != $row[$i])
			{
				$newData = $_POST[$fieldname];
				$sql2 = "UPDATE `logbook_struct` SET `$fieldname` = '$newData' WHERE `office` = '$dbase' AND `group` = '$group'";
				$updateResult2 = mysql_query($sql2);
			}
		}
	}
}

echo( "<script>
         <!--
         location=\"logbook_struct.php\";
         //-->
         </script> " );
?>
