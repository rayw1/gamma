<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 2)
{
	die( "Admin too low" );
}

$recipIn = $_POST["recipient"];

echo( "<h1>Make Recipient (Processing)</h1>" );

connect_to();

$sql = "INSERT INTO `franchise_bills` (`ID`, `office`, `reason`, `Group`) VALUES ('', 'key', '$recipIn', '$group')";
$insertResult = mysql_query($sql);

echo( "
<script>
location=\"franchisebill.php\";
</script> 
");

?>
