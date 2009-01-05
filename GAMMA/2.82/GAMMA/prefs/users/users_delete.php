<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$dbase = "dbclients";
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
  die("Admin level too low");
}

$id = $_GET["id"];

include(getcwd().'/../../includes/common.inc');
connect_to();

$sql = "DELETE FROM `users` WHERE `id` = '$id' AND `office` = '$office'";

echo("Attempting to delete id " . $id . "<br>");
$insertresult = mysql_query($sql);

echo( "
<script>
location=\"users_search.php\";
</script> 
");

?>
