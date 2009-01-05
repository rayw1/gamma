<?php
//GAMMA V2.7 CERTIFIED
session_start();
$office = $_SESSION["office"];
$now = date("Ymd");
header("Content-type: application/txt");
$header2 = "Content-Disposition: attachment; filename=".$office."-".$now."-receipt.csv";
header($header2);
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
connect_to();
$sql1 = "SELECT * FROM `receipt` WHERE `office` = '$office' AND `group` = '$group'";
$result1 = mysql_query($sql1);

while($row = mysql_fetch_row($result1))
{
  $num = count($row);
  for($i = 0 ; $i < $num; $i++)
  {
  echo("\"".$row[$i]."\"" );
  $last = $num - 1;
  if($i != $last)
  {
    echo(",");    
  }
  }
  echo("\n");
}
?>
