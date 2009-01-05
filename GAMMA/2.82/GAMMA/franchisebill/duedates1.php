<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 2)
{
	die( "Admin too low" );
}

connect_to();

$yearIn = $_GET["year"];
$lastYear = $yearIn - 1;
$nextYear = $yearIn + 1;

echo( "<h1>Set Due Dates for ".$yearIn."</h1>" );
echo( "View due dates for <a href = \"duedates1.php?year=".$lastYear."\">".$lastYear."</a> or <a href = \"duedates1.php?year=".$nextYear."\">".$nextYear."</a><br>" );

echo( "<form action=\"duedates2.php\" method=\"POST\">" );
echo( "<input type=\"hidden\" name=\"year\" value=\"".$yearIn."\">" );
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
$color = "#CCFFCC";

echo( "<tr><td><b>Period</b></td><td><b>Due Date</b></td><td><b>Sent</b></td></tr>" );

for($i = 1; $i <= 12; $i++)
{
	$sql1 = "SELECT * FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `due` <> '0000-00-00' AND `Group` = '$group'";
	$selectResult1 = mysql_query($sql1);
	
	$row = mysql_fetch_array($selectResult1);
	
	$due = $row["due"];
	$sent = $row["sent"];
	
	echo( "<tr><td>".$i."/".$yearIn."</td><td>");
	month_drop(substr($due, 5, 2), $i);
    day_drop(substr($due, 8, 2), $i); 
    year_drop(substr($due, 0, 4), $i);
	echo( "</td><td>" );
	
	if($sent == "yes")
	{
		echo( "<select name=\"sent".$i."\">
		<option value=\"yes\" selected>Yes</option>
		<option value=\"no\">No</option>
		</select>" );
	}
	else 
	{
		echo( "<select name=\"sent".$i."\">
		<option value=\"yes\">Yes</option>
		<option value=\"no\" selected>No</option>
		</select>" );
	}
	
	echo( "</td></tr>" );
}
echo( "</table>" );
echo( "<br><input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

?>
