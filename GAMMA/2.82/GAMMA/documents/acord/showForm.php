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

$id = mysql_real_escape_string($_GET["fid"]);

$sql1 = "SELECT * FROM `acord` WHERE `ID` = '$id'";
$selectResult1 = mysql_query($sql1);

$row = mysql_fetch_array($selectResult1);

echo( $row["Data"] );


?>
