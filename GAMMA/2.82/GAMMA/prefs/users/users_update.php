<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$dbase = "dbclients";
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
	die("Admin level too low");
}
include(getcwd().'/../../includes/common.inc');
connect_to();

$id = $_GET["id"];
$user = $_POST["name"];
check_chars($user);
$oldpass = $_POST["oldpass"];
$pass1 = $_POST["pass1"];
check_chars($pass1);
$pass2 = $_POST["pass2"];
$adminlevel = $_POST["adminlevel"];
$calendar = $_POST["calendar"];

$sql = "SELECT * FROM `users` WHERE `id` = '$id'";
$insertresult = mysql_query($sql);
while($row = mysql_fetch_array($insertresult))
{
	if($oldpass != "")
	{
		if( $pass1 !== $pass2)
		{
			die( "Passwords not the same" );
		}
		else
		{
			$pass1 = md5($pass2);
		}

		if(md5($oldpass) == $row["password"])
		{
		}
		else
		{
			die( "Old Password Incorrect" );
		}
	}
	else
	{
		$pass1 = $row["password"];
	}

	if($row["username"] == $uname && $uname != $user)
	{
		$_SESSION["username"] = $user;
		echo("Updated session variable");
	}
	echo( "<script>
         <!--
         location=\"users_search.php\";
         //-->
         </script> " );
}

$sql = "UPDATE `users` SET `calendar` = '$calendar', `username` = '$user', `password` = '$pass1', `Admin` = '$adminlevel' WHERE `id` = '$id'";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Could not update users: $sql", "users_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure<br>" );
}


?>
