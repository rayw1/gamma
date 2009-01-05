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

//$data = mysql_real_escape_string($data, $connection);
//$data = addslashes($data);

$sql1 = "INSERT INTO `acord` (`ID`, `Number`, `Name`, `Data`) VALUES ('', '$number', '$name', '$data')";
$insertResult1 = mysql_query($sql1);

if($insertResult1 == 0)
{
	log_error("Acord Insert Failure: $sql1", "addForm2.php", $_SESSION["username"], $_SESSION["group"]);
	die("Insert Failure");
}

echo( "
<script>
location=\"formIndex.php\";
</script> 
");

?>
