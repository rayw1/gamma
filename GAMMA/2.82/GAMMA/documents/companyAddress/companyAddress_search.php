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
$sql = "SELECT * FROM `companyaddress` ORDER BY `Name`";

$itemList = mysql_query($sql);
echo( "<h1>Company Address List</h1>" );
echo( "<a href = \"companyAddress.php\"><img src=\"../../images/add.gif\" border = \"0\"></a><br>" );

echo( "<table border = \"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"75%\"><tr><td>Name</td><td>Address</td><td>City</td><td>State</td><td>Zip</td><td>Date Updated</td><td>Edit</td><td>Delete</td></tr>" );

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
	echo( $row["Name"] );
	echo( "</td><td>" );
	echo( $row["Address"] );
	echo( "</td><td>" );
	echo( $row["City"] );
	echo( "</td><td>" );
	echo( $row["State"] );
	echo( "</td><td>" );
	echo( $row["Zip"] );
	echo( "</td><td>" );
	echo( $row["Date"] );
	echo( "</td><td><a href = \"companyAddress_edit.php?lid=" );
	echo( $row["Number"] );
	echo( "\"><img src=\"../../images/edit.gif\" border = \"0\"></a></td><td><a href = \"companyAddress_delete.php?lid=" );
	echo( $row["Number"] );
	echo( "\"><img src=\"../../images/delete.gif\" border = \"0\"></a></td></tr>" );
}

echo( "</table>" );

?>
