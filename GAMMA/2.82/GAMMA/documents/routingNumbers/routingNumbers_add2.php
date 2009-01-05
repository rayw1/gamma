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
$sql = "SELECT * FROM `routingnumbers`";
$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Routing Numbers Select Failure: $sql", "routingNumbers_add2.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not select Routing Numbers");
}

if($row = mysql_fetch_row($itemList))
{
	$num = count($row);
	$last = $num - 1;

	$sql2 = "INSERT INTO `routingnumbers` (";
	for($i = 0; $i < $num; $i++)
	{
		$fieldname = mysql_field_name($itemList, $i);
		$sql2 .= "`";
		$sql2 .= $fieldname;
		$sql2 .= "`";

		if($i == $last)
		{
			$sql2 .= ")";
		}
		else
		{
			$sql2 .= ", ";
		}
	}

	$sql2 .= " VALUES (";
	for($i = 0; $i < $num; $i++)
	{
		$fieldname = mysql_field_name($itemList, $i);

		$sql2 .= "'";
		$sql2 .= mysql_real_escape_string($_POST["$fieldname"]);
		$sql2 .= "'";


		if($i == $last)
		{
			$sql2 .= ")";
		}
		else
		{
			$sql2 .= ", ";
		}

	}

}
$insertresult = mysql_query($sql2);
if($insertresult == 1)
{
	echo("<p>Created Record</p>");
}
else
{
	log_error("Routing Numbers Update Failure: $sql2", "routingNumbers_add2.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure<br>" );
}



echo( "
<script>
location=\"routingNumbers_view.php?\";
</script> 
");

?>
