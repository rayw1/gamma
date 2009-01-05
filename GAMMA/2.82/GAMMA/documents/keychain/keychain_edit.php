<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$num = mysql_real_escape_string($_GET["id"]);

$sql0 = "SELECT * FROM `keychain` WHERE `id` = '$num'";
$selectResult0 = mysql_query($sql0);
$row0 = mysql_fetch_array($selectResult0);
if($row0["office"] != $_SESSION["office"] && $_SESSION["admin"] < 3)
{
	echo("ID and Office do not match");
	log_error("Keychain Security Failure: $sql0", "keychain_edit.php", $_SESSION["username"], $_SESSION["group"]);
}

$sql1 = "SELECT * FROM `keychain` WHERE `id` = '$num'";
$selectResult1 = mysql_query($sql1);
if($selectResult1 == 0)
{
	log_error("Keychain Select Failure: $sql1", "keychain_edit.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain record ".$num);
}

$sql2 = "SELECT * FROM `companies`";
$selectResult2 = mysql_query($sql2);
if($selectResult2 == 0)
{
	log_error("Company Select Failure: $sql2", "keychain_edit.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain company list");
}
echo( "<h1>Keychain Edit</h1>" );
$row1 = mysql_fetch_array($selectResult1);


echo( "<form method=\"post\" action=\"keychain_update.php\">" );
echo( "<input type=\"hidden\" name=\"number\" value=\"");
echo( $num );
echo( "\">" );
echo( "Company: <select name=\"company\">" );
while($row2 = mysql_fetch_array($selectResult2))
{
	if($row2["Name"] == $row1["company"])
	{
		echo( "<option value=\"".$row2["Name"]."\" selected>".$row2["Name"]."</option>" );
	}
	else 
	{
		echo( "<option value=\"".$row2["Name"]."\">".$row2["Name"]."</option>" );
	}
}
echo( "</select><br>" );
echo( "Username: <input class=\"blue\" type=\"text\" name=\"username\" value=\"" );
echo( $row1["username"] );
echo( "\"><br>" );
echo( "Password: <input class=\"blue\" type=\"text\" name=\"password\" value=\"" );
echo( $row1["password"] );
echo( "\"><br>" );
echo( "Agent Code: <input class=\"blue\" type=\"text\" name=\"agentCode\" value=\"" );
echo( $row1["agentCode"] );
echo( "\"><br>" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );


?>
