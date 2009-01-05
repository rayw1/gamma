<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
  die("Admin level too low");
}

$id = $_GET["lid"];

include(getcwd().'/../includes/common.inc');
connect_to();

$sql = "DELETE FROM `logbook` WHERE `Number` = '$id' AND `office` = '$office' AND `group` = '$group'";

echo("Attempting to delete Number " . $id . "<br>");
$deleteResult = mysql_query($sql);

echo( "
<script>
<!--
location=\"logbook_search.php\";
//-->
</script> ");

?>
