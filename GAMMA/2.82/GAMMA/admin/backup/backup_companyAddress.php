<?php
//GAMMA V2.7 CERTIFIED
session_start();
$office = $_SESSION["office"];
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
$now = date("Ymd");

include(getcwd().'/../../includes/common.inc');
connect_to();

if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
  die("ADMIN TOO LOW");
}

header("Content-type: application/txt");
header("Content-Disposition: attachment; filename=".$now."-companyAddress.csv");

$result1 = mysql_query("SELECT * FROM `companyaddress` WHERE `group` = '$group'");

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
