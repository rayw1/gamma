<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = mysql_real_escape_string($_SESSION["admin"]);
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

echo( "<h1>Dashboard Functions</h1>" );

connect_to();

$sql0 = "SELECT * FROM `functions` WHERE `Group` = '$group' && `Admin` <= '$admin' ORDER BY `Group`, `Name";
$selectResult0 = mysql_query($sql0);

echo( "<form action=\"functions2.php\" method=\"post\">" );

echo( "<a href=\"functions_add1.php\"><img src=\"../images/add.gif\" border=\"0\"></a><br>" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );
echo( "<tr><td><b>Name</b></td><td><b>Link</b></td><td><b>Group</b></td><td><b>Admin</b></td><td><b>Delete</b></td></tr>" );

$i = 0;
$color = "#CCFFCC";
while($row = mysql_fetch_array($selectResult0))
{
	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td><input type=\"hidden\" name=\"name_".$i."\" value=\"".$row["Name"]."\">".$row["Name"]."</td><td><textarea name=\"link_".$i."\" cols=\"45\">".$row["Link"]."</textarea></td><td>".$row["Group"]."</td><td>
	<select name=\"admin_".$i."\">" );
	
	for($j = 0; $j <= 99; $j++)
	{
		echo( "<option value=\"".$j."\"" );
		if($j == $row["Admin"])
		{
			echo( "selected" );
		}
		echo( ">".$j."</option>" );
	}
	
	echo( "</td><td><a href=\"functions_delete1.php?id=".$row["ID"]."\"><img src=\"delete.gif\" border=\"0\"></td></tr>" );
	$i++;
	if($color == "white")
	{
		$color = "#CCFFCC";
	}
	else
	{
		$color = "white";
	}
}
echo( "<input type=\"hidden\" name=\"total_num\" value=\"".$i."\">" );
echo( "</table>" );
echo( "<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form> " );
?>
