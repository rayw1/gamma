<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$id = $_GET["id"];
$sql0 = "SELECT * FROM `quotes` WHERE `ID` = '$id'";
$selectResult0 = mysql_query($sql0);
$row = mysql_fetch_array($selectResult0);

echo( "
<input type=\"hidden\" name=\"id\" value=\"$id\">
<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">
<tr><td>First Name:</td><td><b>".$row["firstName"]."</b></td><td>Last Name:</td><td><b>".$row["lastName"]."</b></td><td>Phone Number:</td><td><b>".$row["phoneNumber"]."</b></td></tr>
<tr><td>Address:</td><td colspan=\"5\"><b>".$row["address"]."</b></td></tr>
<tr><td>City:</td><td><b>".$row["city"]."</b></td><td>State:</td><td><b>".$row["state"]."</b></td><td>Zip:</td><td><b>".$row["zipCode"]."</b></td></tr>
</table><br>
Date of Birth: ");
$month = substr($row["dob"], 5, 2);
$day = substr($row["dob"], 8, 2);
$year = substr($row["dob"], 0, 4);

echo( "$month/$day/$year<br>
How many months have you lived at your residence? 
<b>".$row["timeAtResidence"]."</b> Marital Status <b>".$row["maritalStatus"]."</b> Single Parent? <b>".$row["singleParent"]."</b>
How many years have you had a drivers license? <b>".$row["yearsLicensed"]."</b><br>
Does anyone else Fifteen years or older live with you? <b>".$row["fifteenOlder"]."</b><br>" );

if($row["otherDriver1Name"] != "")
{
	echo( "Other Driver 1: Name: <b>".$row["otherDriver1Name"]."</b> Date of Birth: ");
	$month = substr($row["otherDriver1DOB"], 5, 2);
	$day = substr($row["otherDriver1DOB"], 8, 2);
	$year = substr($row["otherDriver1DOB"], 0, 4);
	echo( "<b>$month/$day/$year</b><br>" );
}

if($row["otherDriver2Name"] != "")
{
	echo( "Other Driver 2: Name: <b>".$row["otherDriver2Name"]."</b> Date of Birth: ");
	$month = substr($row["otherDriver2DOB"], 5, 2);
	$day = substr($row["otherDriver2DOB"], 8, 2);
	$year = substr($row["otherDriver2DOB"], 0, 4);
	echo( "<b>$month/$day/$year</b><br>" );
}

if($row["otherDriver3Name"] != "")
{
	echo( "Other Driver 3: Name: <b>".$row["otherDriver3Name"]."</b> Date of Birth: ");
	$month = substr($row["otherDriver3DOB"], 5, 2);
	$day = substr($row["otherDriver3DOB"], 8, 2);
	$year = substr($row["otherDriver3DOB"], 0, 4);
	echo( "<b>$month/$day/$year</b><br>" );
}
echo( "<br>
Does anyone have anything on their driving record in the past 5 years?(If an SR-22 is needed, indicate here):<br>
<b>".$row["violations"]."</b><br>

Vehicles:<br>
<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
<tr bgcolor=\"#CCCCCC\"> 
<td width=\"5%\"> <h4 align=\"center\">Vehicle Number</h4></td>
<td width=\"5%\"> <h4 align=\"center\">Year </h4></td>
<td width=\"7%\"> <h4 align=\"center\">Make </h4></td>
<td width=\"16%\"> <h4 align=\"center\">Model </h4></td>
<td width=\"6%\"> <h4 align=\"center\">Doors </h4></td>
<td width=\"9%\"> <h4 align=\"center\">Cylinders </h4></td>
<td width=\"10%\"> <h4 align=\"center\">Airbag: </h4></td>
<td width=\"9%\"> <h4 align=\"center\">ABS: </h4></td>
<td width=\"13%\"> <h4 align=\"center\">4 Wheel Drive: </h4></td>
<td width=\"20%\" nowrap> <h4 align=\"center\">Alarm: </h4></td>
</tr>");

if($row["vehicle1Make"] != "")
{
	echo("
<tr> 
<td height=\"31\">1:</td>
<td><b>".$row["vehicle1Year"]."</b></td>
<td><b>".$row["vehicle1Make"]."</b></td>
<td><b>".$row["vehicle1Model"]."</b></td>
<td><b>".$row["vehicle1Doors"]."</b></td>
<td><b>".$row["vehicle1Cylinders"]."</b></td>
<td><b>".$row["vehicle1Airbags"]."</b></td>
<td><b>".$row["vehicle1ABS"]."</b></td>
<td><b>".$row["vehicle1FourWheelDrive"]."</b></td>
<td><b>".$row["vehicle1Alarm"]."</b></td>
</tr>
");
}

if($row["vehicle2Make"] != "")
{
	echo("
<tr> 
<td height=\"31\">2:</td>
<td><b>".$row["vehicle2Year"]."</b></td>
<td><b>".$row["vehicle2Make"]."</b></td>
<td><b>".$row["vehicle2Model"]."</b></td>
<td><b>".$row["vehicle2Doors"]."</b></td>
<td><b>".$row["vehicle2Cylinders"]."</b></td>
<td><b>".$row["vehicle2Airbags"]."</b></td>
<td><b>".$row["vehicle2ABS"]."</b></td>
<td><b>".$row["vehicle2FourWheelDrive"]."</b></td>
<td><b>".$row["vehicle2Alarm"]."</b></td>
</tr>
");
}

if($row["vehicle3Make"] != "")
{
	echo("
<tr> 
<td height=\"31\">3:</td>
<td><b>".$row["vehicle3Year"]."</b></td>
<td><b>".$row["vehicle3Make"]."</b></td>
<td><b>".$row["vehicle3Model"]."</b></td>
<td><b>".$row["vehicle3Doors"]."</b></td>
<td><b>".$row["vehicle3Cylinders"]."</b></td>
<td><b>".$row["vehicle3Airbags"]."</b></td>
<td><b>".$row["vehicle3ABS"]."</b></td>
<td><b>".$row["vehicle3FourWheelDrive"]."</b></td>
<td><b>".$row["vehicle3Alarm"]."</b></td>
</tr>
");
}

echo( "
</table>

Coverages:<br>
<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
<tr bgcolor=\"#CCCCCC\"> 
<td width=\"5%\"> <h4 align=\"center\">Vehicle Number</h4></td>
<td width=\"13%\"> <h4 align=\"center\">Type</h4></td>
<td width=\"14%\"> <h4 align=\"center\">Liability<br>
Limits</h4></td>
<td width=\"13%\"> <h4 align=\"center\">Comprehensive<br>
Deductible</h4></td>
<td width=\"15%\"> <h4 align=\"center\">Collision<br>
Deductible</h4></td>
<td width=\"13%\"> <h4 align=\"center\">Medical<br>
Payments</h4></td>
<td width=\"11%\"> <h4 align=\"center\">Rental</h4></td>
<td width=\"16%\"> <h4 align=\"center\">Towing</h4></td>
</tr>");

if($row["vehicle1Make"] != "")
{
	echo( "<tr>
<td height=\"31\"><div align=\"center\">1:</div></td>
<td><b>".$row["vehicle1CoverageType"]."</b></td>
<td><b>".$row["vehicle1LiabilityLimits"]."</b></td>
<td><b>".$row["vehicle1Comp"]."</b></td>
<td><b>".$row["vehicle1Collision"]."</b></td>
<td><b>".$row["vehicle1Med"]."</b></td>
<td><b>".$row["vehicle1Rental"]."</b></td>
<td><b>".$row["vehicle1Towing"]."</b></td>
</tr>");
}

if($row["vehicle2Make"] != "")
{
	echo( "<tr>
<td height=\"31\"><div align=\"center\">2:</div></td>
<td><b>".$row["vehicle2CoverageType"]."</b></td>
<td><b>".$row["vehicle2LiabilityLimits"]."</b></td>
<td><b>".$row["vehicle2Comp"]."</b></td>
<td><b>".$row["vehicle2Collision"]."</b></td>
<td><b>".$row["vehicle2Med"]."</b></td>
<td><b>".$row["vehicle2Rental"]."</b></td>
<td><b>".$row["vehicle2Towing"]."</b></td>
</tr>");
}

if($row["vehicle3Make"] != "")
{
	echo( "<tr>
<td height=\"31\"><div align=\"center\">3:</div></td>
<td><b>".$row["vehicle3CoverageType"]."</b></td>
<td><b>".$row["vehicle3LiabilityLimits"]."</b></td>
<td><b>".$row["vehicle3Comp"]."</b></td>
<td><b>".$row["vehicle3Collision"]."</b></td>
<td><b>".$row["vehicle3Med"]."</b></td>
<td><b>".$row["vehicle3Rental"]."</b></td>
<td><b>".$row["vehicle3Towing"]."</b></td>
</tr>");
}

echo( "</table>");

echo( "Occupation: <b>".$row["occupation"]."</b> How long have you worked at your job? <b>".$row["timeAtJob"]."</b> My vehicle is a part of my job: <b>".$row["jobVehicle"]."</b>
<br>
How many miles do you drive to work (one way)? <b>".$row["milesToWork"]."</b> How many miles do you drive in a year (average is 12,000)? <b>".$row["annualMileage"]."</b><br>

Do you have insurance right now? <b>".$row["insuranceNow"]."</b>
if not, how long without? <b>".$row["howLongWithout"]."</b> If so, with who? <b>".$row["withWho"]."</b> For how many months? <b>".$row["priorMonthsCovg"]."</b><br>
Prior liability limits: <b>".$row["priorLiabilityLimits"]."</b>
Do you own your home? <b>".$row["homeowner"]."</b> Do you have insurance (homeowners/renters/condo)? <b>".$row["homeInsurance"]."</b><br>
Are all the vehicles titled in your name or a name listed above? 
<b>".$row["titledInListed"]."</b>
<br>
Social Security Number: <b>".$row["ssn"]."</b>
I like to pay my insurance: ");

if($row["payplan"] == "In Full")
{
	echo( "Pays in Full");
}
else 
{
	echo( "Pays Monthly");
}
echo( "<br>Any additional comments?<br><b>".$row["comments"]."</b><br>");
	

?>
