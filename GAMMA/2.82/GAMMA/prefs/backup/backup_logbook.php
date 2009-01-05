<?php
//GAMMA V2.7 CERTIFIED
session_start();
$office = $_SESSION["office"];
$now = date("Ymd");
header("Content-type: application/txt");
$header2 = "Content-Disposition: attachment; filename=".$office."-".$now."-logbook.csv";
header($header2);
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
connect_to($office);

$sql2 = "SELECT * FROM `logbook`";
$result2 = mysql_query($sql2);

while($row = mysql_fetch_row($result2))
{
	$num = count($row);
	for($i = 0 ; $i < $num; $i++)
	{
		echo("\"".$row[$i]."\"" );
		$last = $num - 1;
		if($i != $last)
		{
			echo(",");
		}
	}
	echo("\n");
}
?>
