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

$id = mysql_real_escape_string($_GET["id"]);
$sql1 = "SELECT * FROM `error_log` WHERE `id` = '$id'";
$selectResult1 = mysql_query($sql1);

$row1 = mysql_fetch_array($selectResult1);

echo( "<h1>Error Details</h1>" );

echo("<a href=\"error_close.php?id=$id\">Close this error</a><br><br>");

echo("ID: ".$row1["id"]."<br>");
echo("Page: ".$row1["page"]."<br>");
echo("User: ".$row1["user"]."<br>");
echo("Status: ".$row1["status"]."<br>");
echo("Group: ".$row1["group"]."<br>");
echo("Error: ".$row1["error"]."<br>");
?>
