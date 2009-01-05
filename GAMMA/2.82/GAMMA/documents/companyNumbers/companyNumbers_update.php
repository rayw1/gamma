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
$sql = "SELECT * FROM `companynumbers`";
$itemList = mysql_query($sql);

$lnum = mysql_real_escape_string($_POST["nid"]);

if($itemList == 0)
{
	log_error("Company Numbers Select Failure: $sql", "companyNumbers_update.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not select CompanyNumbers" );
}

if($row = mysql_fetch_row($itemList))
{
	$num = count($row);
	$last = $num - 1;

	$sql2 = "UPDATE `companynumbers` SET ";
	for($i = 0; $i < $num; $i++)
	{
		$customfield = 0;
		$fieldname = mysql_field_name($itemList, $i);

		if($fieldname == "ID")
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
			$sql2 .= " WHERE `ID` = '";
			$sql2 .= $lnum;
			$sql2 .= "'";
		}
		if($i != $last && $customfield != 1)
		{
			$sql2 .= ", ";
		}

	}
}
$insertresult = mysql_query($sql2);

if($insertresult == 0)
{
	log_error("Compnay Numbers Update Failure: $sql2", "companyNumbers_update.php", $_SESSION["username"], $_SESSION["group"]);
	die("<p>Update Failed</p>");
}

echo( "
<script>
location=\"companyNumbers_view.php\";
</script> 
");
?>
