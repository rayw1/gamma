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

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `logbook`";
$itemList = mysql_query($sql);

$lnum = $_POST["lid"];

if($itemList == 0)
{
	log_error("Logbook Select Failure: $sql", "logbook_update.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not select logbook");
}

if($row = mysql_fetch_row($itemList))
{
	$num = count($row);
	$last = $num - 1;

	$sql2 = "UPDATE `logbook` SET ";
	for($i = 0; $i < $num; $i++)
	{
		$customfield = 0;
		$fieldname = mysql_field_name($itemList, $i);
		if($fieldname == "Date")
		{
			$sql2 .= "`";
			$sql2 .= $fieldname;
			$sql2 .= "` = ";
			$date = $_POST["year"];
			$date .= "-";
			$date .= $_POST["month"];
			$date .= "-";
			$date .= $_POST["day"];
			$sql2 .= "'";
			$sql2 .= $date;
			$sql2 .= "'";
			$sql2 .= ", ";
			$customfield = 1;
		}
		if($fieldname == "Number")
		{
			$customfield = 1;
		}

		if($customfield != 1)
		{
			$sql2 .= "`";
			$sql2 .= $fieldname;
			$sql2 .= "` = ";
			$sql2 .= "'";
			$sql2 .= $_POST["$fieldname"];
			$sql2 .= "'";
		}

		if($i == $last)
		{
			$sql2 .= " WHERE `Number` = '";
			$sql2 .= $lnum;
			$sql2 .= "' AND `office` = '$dbase' AND `group` = '$group'";
		}
		if($i != $last && $customfield != 1)
		{
			$sql2 .= ", ";
		}

	}
}

//echo( $sql2 );

$insertresult = mysql_query($sql2);

if($insertresult == 0)
{
	log_error("Logbook Update Failure: $sql2", "logbook_update.php", $_SESSION["username"], $_SESSION["group"]);
	die("<p>MySQL FAILURE</p>");
}


echo( "
<script>
location=\"logbook_search.php?yPass=".$_POST["yPass"]."&mPass=".$_POST["mPass"]."\";
</script> 
");

?>
