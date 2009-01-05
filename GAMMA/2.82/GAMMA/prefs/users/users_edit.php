<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$uname = $_SESSION["username"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
	die("Admin level too low");
}

$id = $_GET["id"];

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `users` WHERE `id` = '$id'";
$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Could not obtain users", "users_edit.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain users");
}

$row = mysql_fetch_array($itemList);


$topLevel = $admin;
$levelSelected = $row["Admin"];

echo( "<h1>User Edit</h1>" );
echo( "<form action=\"users_update.php?id=" );
echo( $id );
echo( "\" method=\"post\">" );
echo( "<p>Name: <input class=\"blue\" type=\"text\" name=\"name\" value=\"" );
echo( $row["username"] );
echo( "\"></p><p><table><tr><td>" );
echo( "Old Password: </td><td><input class=\"blue\" type=\"password\" name=\"oldpass\">" );
echo( "</td></tr><tr><td>New Password: </td><td><input class=\"blue\" type=\"password\" name=\"pass1\">" );
echo( "</td></tr><tr><td>Verify: </td><td><input class=\"blue\" type=\"password\" name=\"pass2\">" );
echo( "</td></tr></table><br>If incorrect, password will not be changed.</p>" );

echo( "<p>Calendar: <select name=\"calendar\">" );
echo( "<option value=\"locked\"" );
if($row["calendar"] == "locked")
{
	echo( " selected" );
}
echo( ">locked</option>" );
echo( "<option value=\"unlocked\"" );
if($row["calendar"] == "unlocked")
{
	echo( " selected" );
}
echo( ">unlocked</option>" );
echo( "</select></p>" );


echo( "<p>Admin Level: <select name=\"adminlevel\">" );
for($i = 0; $i <= $topLevel; $i++)
{
	echo( "<option value=\"".$i."\"" );
	if($i == $levelSelected)
	{
		echo( " selected" );
	}
	echo( ">".$i."</option>" );
}

echo( "</select></p>" );

echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

?>


