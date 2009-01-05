<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');

style("white");
connect_to();

$insertString = "<?phpxml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
$insertString .= "<feedsList>";

$masterNumber = $_POST["masterNumber"];

for($i = 0; $i <= $masterNumber; $i++)
{
	$hostVar = "host$i";
	$locVar = "location$i";
	$nameVar = "name$i";
	
	$host = $_POST[$hostVar];
	$location = $_POST[$locVar];
	$checked = $_POST[$nameVar];
	
	if($checked == "checked")
	{
		$insertString .= "<feed>";
		$insertString .= "<host>$host</host>";
		$insertString .= "<location>$location</location>";
		$insertString .= "</feed>";
	}
	
}
$insertString .= "</feedsList>";

$insertString = mysql_real_escape_string($insertString);

$sql0 = "UPDATE `statistics` SET `RSS` = '$insertString' WHERE `Database` = '$office'";
$updateResult0 = mysql_query($sql0);

echo( "
<script>
location=\"rss.php\";
</script> 
");
?>
