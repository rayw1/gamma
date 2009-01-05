<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 1)
{
	die("Admin level too low");
}
include(getcwd().'/../../includes/common.inc');

$user = $_POST["name"];
check_chars($user);
$pass1 = $_POST["pass1"];
check_chars($pass1);
$pass2 = $_POST["pass2"];
$adminlevel = $_POST["adminlevel"];

if( $pass1 !== $pass2)
{
	die( "Passwords not the same" );
}
else
{
	$pass1 = md5($pass2);
}

connect_to();
$sql = "INSERT INTO `users` (`id`, `username`, `password`, `Admin`, `office`, `group`) VALUES ('', '$user', '$pass1', '$adminlevel', '$office', '$group')";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Could not insert user: $sql", "users_insert.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure<br>" );
}

echo( "
<script>
location=\"users_search.php\";
</script> 
");

?>
