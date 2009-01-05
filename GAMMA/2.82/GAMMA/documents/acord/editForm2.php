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

$name = mysql_real_escape_string($_POST["name"]);
$number = mysql_real_escape_string($_POST["number"]);
$data = mysql_real_escape_string($_POST["data"]);
$id = mysql_real_escape_string($_POST["ID"]);

$sql1 = "UPDATE `acord` SET `Name` = '$name', `Data` = '$data', `Number` = '$number' WHERE `ID` = '$id'";
$updateResult1 = mysql_query($sql1);

if($updateResult1 == 0)
{
	log_error("Acord Update Failure: $sql1", "editForm2.php", $_SESSION["username"], $_SESSION["group"]);
	die("Update Failure");
}

echo( "
<script>
location=\"formIndex.php\";
</script> 
");

?>
