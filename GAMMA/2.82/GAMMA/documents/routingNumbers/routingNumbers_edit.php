<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$pnum = mysql_real_escape_string($_GET["nid"]);
$sql = "SELECT * FROM `routingnumbers` WHERE `ID` = '$pnum'";
$itemList = mysql_query($sql);

echo( "<h1>Routing Number Edit</h1>" );
echo( "<form action=\"routingNumbers_update.php\" method=\"post\">" );
echo( "<input type=\"hidden\" name =\"nid\" value=\"".$pnum."\">" );

echo( "<table cellpadding=\"4\" border = \"0\"><tr><td>" );

if($row = mysql_fetch_row($itemList))
{
$num = count($row);

for($i = 0; $i < $num; $i++)
{
  $customfield = 0;
  $fieldname = mysql_field_name($itemList, $i);

  if($fieldname == "ID")
  {
    $customfield = 1;
  }

  if($customfield != 1)
  {
    echo( "<tr><td><b>" );
    echo(replace_chars($fieldname));
    echo( "</b></td><td>" );
    echo( "<input class=\"blue\" type=\"text\" name = \"" );
    echo( $fieldname );
    echo( "\" value=\"".$row[$i]."\">" );
  }

  echo("</td></tr>");
}
}
echo( "</table>" );
echo( "<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>

