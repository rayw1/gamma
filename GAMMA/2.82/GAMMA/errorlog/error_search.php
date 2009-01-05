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
$sql1 = "SELECT * FROM `error_log` ORDER BY `id`";
$selectResult1 = mysql_query($sql1);

echo( "<h1>Error Log</h1>" );
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">");
echo( "<tr><td><b>ID</b></td><td><b>Page</b></td><td><b>Error</b></td><td><b>Status</b></td><td><b>User</b></td><td><b>Group</b></td></tr>" );

$color = "#CCFFCC";
while($row1 = mysql_fetch_array($selectResult1))
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
	echo( ";\"><td><a href=\"error_details.php?id=".$row1["id"]."\">".$row1["id"]."</td><td>".$row1["page"]."</td><td>".$row1["error"]."</td><td>".$row1["status"]."</td><td>".$row1["user"]."</td><td>".$row1["group"]."</td></tr>" );
}
echo( "</table>" );
echo( "<a href=\"error_clear.php\">Truncate Table</a><br>");
?>
