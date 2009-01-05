<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql0 = "DELETE FROM `quotes` WHERE `ID` = '".$_POST["id"]."'";

$insertresult = mysql_query($sql0);

if($insertresult != 1)
{
	log_error("Delete Quote Failed", "quotesheet_delete2.php", $_SESSION["username"], $_SESSION["group"]);
	die( "Failed to delete quote<br>" );
}

echo( "
<script>
<!--
location=\"quotesheet_search.php\";
//-->
</script> 
" );
?>
