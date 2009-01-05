<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
connect_to();
style("white");
$valid = $_SESSION["validsession"];
$dbase = $_SESSION["office"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$company = mysql_real_escape_string($_POST["Company"]);
if($company == "")
{
	echo( "Company Blank" );
}

echo( "<h1>Customers Written With $company</h1>" );

$sql0 = "SELECT * FROM `logbook` WHERE `Company` = '$company' AND `Office` = '$dbase' AND `Group` = '$group' ORDER BY `LastName`";
$selectResult0 = mysql_query($sql0);

$color = "#CCFFCCC";
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"75%\">" );
while($row = mysql_fetch_array($selectResult0))
{
	if($color == "white")
	{
		$color = "#CCFFCC";
	}
	else
	{
		$color = "white";
	}

	$fname = $row["FirstName"];
	$lname = $row["LastName"];
	
	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td>$fname</td><td>$lname</td></tr>" );
}
echo( "</table>" );
?>
