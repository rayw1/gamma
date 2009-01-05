<?php
//GAMMA V2.7 CERTIFIED
session_start();
set_time_limit(900);
$admin = $_SESSION["admin"];
$valid = $_SESSION["validsession"];
$group = $_SESSION["group"];
$i = 0;
$color = "#CCFFCC";
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die( "Admin too low" );
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$itemList = mysql_query("SELECT * FROM `customer_general` WHERE `Group` = '$group'");
echo( "<h1>Duplicates List</h1>" );

while($row = mysql_fetch_array($itemList))
{
	$email[$i] = $row["Email"];
	$eid[$i] = $row["ID"];
	$i++;
}

for($v=0; $v < $i; $v++)
{

	for($w=$v+1; $w < $i; $w++)
	{
		if($email[$v] == $email[$w])
		{
			$duplicate = 1;
		}
	}

	if($duplicate == 1 && $email[$v] != "")
	{
		echo( $email[$v]."<a href = \"customerlist_delete.php?eid=".$eid[$v]."\"> Delete</a><br>" );
	}
	$duplicate = 0;
}
?>
