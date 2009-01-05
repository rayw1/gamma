<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = mysql_real_escape_string($_SESSION["group"]);
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 99)
{
	die("ADMIN TOO LOW");
}
include(getcwd().'/../includes/common.inc');
style("white");

echo( "<h1>Updating Functions</h1>" );

$end = mysql_real_escape_string($_POST["total_num"]);

connect_to();

for($i = 0; $i <= $end; $i++)
{
	$var_name = "name_".$i;
	$var_link = "link_".$i;
	$var_admin = "admin_".$i;
	
	$tmp_name = mysql_real_escape_string($_POST[$var_name]);
	$tmp_link = mysql_real_escape_string($_POST[$var_link]);
	$tmp_admin = mysql_real_escape_string($_POST[$var_admin]);
	
	$sql0 = "UPDATE `functions` SET `link` = '$tmp_link', `admin` = '$tmp_admin' WHERE `name` = '$tmp_name' && `Group` = '$group'";
	$updateResult0 = mysql_query($sql0);
}

echo( "

<script>
<!--
location=\"functions1.php\";
//-->
</script> 

" );
?>
