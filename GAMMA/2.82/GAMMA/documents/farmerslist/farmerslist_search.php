<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `farmers` WHERE `Group` = '$group' ORDER BY `Name`";

$itemList = mysql_query($sql);
echo( "<h1>Farmers List</h1>" );
echo( "<a href = \"farmerslist.php\"><img src=\"../../images/add.gif\" border = \"0\"></a><br>" );

echo( "<table border = \"1\"><tr><td>Number</td><td>Name</td><td>Location</td><td>Edit</td><td>Delete</td></tr>" );

$i = 0;
while($row = mysql_fetch_array($itemList))
{
  $i = $i+1;
  echo( "<tr><td>" );
  echo( $i );
  echo( "</td><td>" );
  echo( $row["Name"] );
  echo( "</td><td>" );
  echo( $row["Location"] );
  echo( "</td><td><a href = \"farmerslist_edit.php?fid=" );
  echo( $row["Number"] );
  echo( "\"><img src = \"edit.jpg\" border = \"0\"></a></td><td><a href = \"farmerslist_delete.php?fid=" );
  echo( $row["Number"] );
  echo( "\"><img src = \"delete.jpg\" border = \"0\"></a></td></tr>" );
}

echo( "</table>" );

?>
