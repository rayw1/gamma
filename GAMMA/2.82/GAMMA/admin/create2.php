<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
style("white");

connect_to();
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = mysql_real_escape_string($_POST["office"]);
$uname = $_SESSION["username"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}


$onum = mysql_real_escape_string($_POST["onum"]);
$gcode = mysql_real_escape_string($_POST["gcode"]);

if(!stristr($group, $gcode) && $group != "All")
{
	die( "YOU ARE NOT A MEMBER OF THAT GROUP" );
}

$sql = "INSERT INTO `statistics` ( `Number` , `DisplayName` , `Database` , `Color`, `OfficeNumber`, `Group` )";
$sql .= "VALUES ('', '$office', '$office', 'black', '$onum', '$gcode')";
$insertresult = mysql_query($sql);

if($insertresult == 1)
{
	echo( "<h2>Created Statistic Record</h2>" );
}

$pass = md5($office);

$sql = "INSERT INTO `users` ( `id` , `username` , `password` , `admin` , `office`, `Group` )";
$sql .= "VALUES ('', '$office', '$pass', '1' , '$office', '$gcode')";
$insertresult = mysql_query($sql);

if($insertresult == 1)
{
	echo( "<h2>Created User $office</h2>" );
}

$sql = "INSERT INTO `logbook_struct` (`office`, `group`) VALUES ('$office', '$gcode')";
$insertresult = mysql_query($sql);

if($insertresult == 1)
{
	echo( "<h2>Created User Logbook Structure</h2>" );

}

?>
<script>
<!--
location="admin.php";
//-->
</script> 
