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
$sql2 = "SELECT * FROM `companies` ORDER BY `Name` ASC";
$selectResult2 = mysql_query($sql2);
if($selectResult2 == 0)
{
	log_error("Company Select Failure: $sql2", "keychain.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain company list");
}

echo( "<h1>New Keychain Entry</h1>" );
echo( "<form method=\"post\" action=\"keychain_add.php\">" );
echo( "Username: <input class=\"blue\" type=\"text\" name=\"username\"><br>" );
echo( "Password: <input class=\"blue\" type=\"text\" name=\"password\"><br>" );
echo( "Company: <select name=\"company\">" );
while($row2 = mysql_fetch_array($selectResult2))
{
	echo( "<option value=\"".$row2["Name"]."\">".$row2["Name"]."</option>" );
}
echo( "</select><br>" );
echo( "Agent Code: <input class=\"blue\" type=\"text\" name=\"agentCode\"><br>" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

?>
