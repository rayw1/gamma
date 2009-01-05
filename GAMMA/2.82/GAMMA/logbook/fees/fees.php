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
if($admin < 1)
{
  die("ADMIN TOO LOW");
}
include(getcwd().'/../../includes/common.inc');
include(getcwd().'/../../includes/insurance.inc');
style("white");

echo( "<form action=\"fee_result.php\" method=\"post\">" );

echo( "<h1>Fee Finder</h1>" );
echo( "Show all Broker Fees for " );
list_agents($dbase,"");
echo( " for dates ");
month_drop("","1");
echo("/");
day_drop("","1"); 
echo("/");
year_drop("","1");
echo( " to " );
month_drop("","2");
echo("/");
day_drop("","2"); 
echo("/");
year_drop("","2");


//Commission Table
echo("
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr><td><b>Broker Fee Charge Back:</b></td><td>$<input class=\"blue\" type=\"text\" name = \"ChargeBack\" size=\"8\"></td></tr>
<tr><td><b>");
list_companies("", 0);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost0\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 1);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost1\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 2);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost2\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 3);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost3\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 4);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost4\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 5);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost5\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 6);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost6\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 7);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost7\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 8);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost8\" size=\"8\"></td></tr><tr><td><b>");
list_companies("", 9);
echo( "</b></td><td>$<input class=\"blue\" type=\"text\" name = \"cost9\" size=\"8\"></td></tr>
</table>
<b>Empty values will not be shown on total</b>
" );


echo( "<br><input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>

