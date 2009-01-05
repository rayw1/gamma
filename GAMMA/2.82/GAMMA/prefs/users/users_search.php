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
	die( "Admin too low" );
}

include(getcwd().'/../../includes/common.inc');

style("white");
connect_to();
$sql = "SELECT * FROM `users` WHERE `office` = '$office'";

echo( "<html>" );
echo( "<h1>User Accounts</h1>" );
echo( "Results for office: " );
echo( $office );
echo( "<br>" );

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Could not obtain users: $sql", "users_search.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain users");
}

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
echo( "<tr><td>" );
echo( "Name" );
echo( "</td><td>" );
echo( "Admin Level" );
echo( "</td><td>" );
echo( "Calendar" );
echo( "</td><td>" );
echo( "Edit" );
echo( "</td><td>" );
echo( "Delete" );
echo( "</td></tr>" );

$color = "#CCFFCC";

while($row = mysql_fetch_array($itemList))
{
	if($color == "white")
	{
		$color = "#CCFFCC";
	}
	else
	{
		$color = "white";
	}
	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td>" );
	echo( $row["username"] );
	echo( "</td><td>" );
	echo( $row["Admin"] );
	echo( "</td><td>" );
	echo( $row["calendar"] );
	echo( "</td><td>" );
	if($row["Admin"] <= $admin)
	{
		echo( "<a href = \"users_edit.php?id=" );
		echo( $row["id"] );
		echo( "\"><img src = \"../../images/edit.gif\" border = \"0\"></a>" );
	}
	echo( "</td><td>" );
	if($uname != $row["username"])
	{
		if($row["Admin"] <= $admin)
		{
			echo( "<a href = \"users_delete.php?id=" );
			echo( $row["id"] );
			echo( "\"><center><img src = \"../../images/delete.gif\" border = \"0\"></a></center>" );
		}
	}
	echo( "</td></tr>" );
}
?>
</table><br>
<a href = "users_add.php">Add User</a><br>
