<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
if($admin >= 3)
{
	$sql1 = "SELECT * FROM `keychain` WHERE `group`='".$_SESSION["group"]."' ORDER BY `company`";
}
else 
{
	$sql1 = "SELECT * FROM `keychain` WHERE `office`='".$_SESSION["office"]."' ORDER BY `company`";
}
$itemList = mysql_query($sql1);
echo( "<h1>Keychain</h1>" );
echo( "<a href = \"keychain.php\"><img src=\"../../images/add.gif\" border = \"0\"></a><br>" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
<tr><td><b>Company</b></td><td><b>Username</b></td><td><b>Password</b></td><td><b>Agent Code</b></td>" );
if($admin >= 3)
{
	echo( "<td><b>Office</b></td>" );
}

echo( "<td><b>Edit</b></td><td><b>Delete</b></td></tr>" );

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
	echo( $row["company"] );
	echo( "</td><td>" );
	echo( $row["username"] );
	echo( "</td><td>" );
	echo( $row["password"] );
	echo( "</td><td>".$row["agentCode"]."</td>" );
	
	if($admin >= 3)
	{
		$sql2 = "SELECT * FROM `statistics` WHERE `database` = '".$row["office"]."'";
		$selectResult2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($selectResult2);
		echo( "<td>".$row2["DisplayName"]."</td>" );
		
	}
	
	echo( "<td><a href = \"keychain_edit.php?id=" );
	echo( $row["id"] );
	echo( "\"><img src = \"../../images/edit.gif\" border = \"0\"></a></td><td><a href = \"keychain_delete.php?id=" );
	echo( $row["id"] );
	echo( "\"><img src = \"../../images/delete.gif\" border = \"0\"></a></td></tr>" );
}

echo( "</table>" );

?>
