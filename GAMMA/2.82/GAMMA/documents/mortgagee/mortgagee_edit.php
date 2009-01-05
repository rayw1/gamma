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

$num = mysql_real_escape_string($_GET["lid"]);

$sql = "SELECT * FROM `mortgagee` WHERE `Number` = '$num'";

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Mortgagee Select Failure: $sql", "mortgagee_edit.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain record");
}
else
{
  echo( "<h1>Mortgagee Edit</h1>" );
}

while($row = mysql_fetch_array($itemList))
{
  echo( "<form method=\"post\" action=\"mortgagee_update.php\">" );
  echo( "<input type=\"hidden\" name=\"number\" value=\"");
  echo( $num );
  echo( "\">" );
  echo( "Name: <input class=\"blue\" type=\"text\" name=\"name\" value=\"" );
  echo( $row["Name"] );
  echo( "\"><br>" );
  echo( "Address: <input class=\"blue\" type=\"text\" name=\"address\" value=\"" );
  echo( $row["Address"] );
  echo( "\"><br>" );
  echo( "City: <input class=\"blue\" type=\"text\" name=\"city\" value=\"" );
  echo( $row["City"] );
  echo( "\"><br>" );
  echo( "State: <input class=\"blue\" type=\"text\" name=\"state\" value=\"" );
  echo( $row["State"] );
  echo( "\"><br>" );
  echo( "Zip: <input class=\"blue\" type=\"text\" name=\"zip\" value=\"" );
  echo( $row["Zip"] );
  echo( "\"><br>" );

  echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
  echo( "</form>" );
}

?>
