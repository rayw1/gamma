<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
connect_to();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$id = mysql_real_escape_string($_GET["nid"]);

$sql = "DELETE FROM `routingnumbers` WHERE `ID` = '$id'";

echo("Attempting to delete Number " . $id . "<br>");
mysql_query($sql);

echo( "<script>
<!--
location=\"routingNumbers_view.php\";
//-->
</script> " );
?>
