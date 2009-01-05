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
$sql1 = "TRUNCATE TABLE `error_log`";
$selectResult1 = mysql_query($sql1);

echo( "
<script>
location=\"error_search.php\";
</script> 
");
?>
