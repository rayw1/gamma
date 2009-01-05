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

if($selectResult0 == 0)
{
	log_error("Could not select quote: $sql0", "quotesheet_details.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could no obtain quote");
}

$row = mysql_fetch_array($selectResult0);

if($row["office"] != $office || $row["group"] != $group)
{
	echo( "<blink><h1>This quote is in the general queue.  If you want it, scroll to the bottom and assign it to yourself</h1></blink>" );
}

echo( "
<h1>Quote Sheet</h1>
<form action=\"quotesheet_update.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"$id\">
<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">
<tr><td>First Name:</td><td><input class=\"blue\" name=\"firstName\" value=\"".$row["firstName"]."\"></td><td>Last Name:</td><td><input class=\"blue\" name=\"lastName\" value=\"".$row["lastName"]."\"></td><td>Phone Number:</td><td><input class=\"blue\" name=\"phoneNumber\" value=\"".$row["phoneNumber"]."\"> ex. 314-555-1234</td></tr>
<tr><td>Address:</td><td colspan=\"5\"><input class=\"blue\" name=\"address\" size=\"80\" maxlength=\"80\" value=\"".$row["address"]."\"></td></tr>
<tr><td>City:</td><td><input class=\"blue\" name=\"city\" value=\"".$row["city"]."\"></td><td>State:</td><td><input class=\"blue\" name=\"state\" value=\"".$row["state"]."\"></td><td>Zip:</td><td><input class=\"blue\" name=\"zipCode\" size=\"12\" maxlength=\"10\" value=\"".$row["zipCode"]."\"></td></tr>
</table><br>
Date of Birth: ");
$month = substr($row["dob"], 5, 2);
$day = substr($row["dob"], 8, 2);
$year = substr($row["dob"], 0, 4);

month_drop("$month","1");
echo( "/" );
day_drop("$day","1");
echo( "/" );
big_year_drop("1930","$year","1");
echo( "<br>
How many months have you lived at your residence? 
<select name=\"timeAtResidence\">
<option value=\"".$row["timeAtResidence"]."\">".$row["timeAtResidence"]."</option>
<option value=\"0\">Less than 6 Months</option>
<option value=\"6\">6 Months - 1 Year</option>
<option value=\"12\">1 Year</option>
<option value=\"24\">2 Years</option>
<option value=\"36\">3 Years</option>
<option value=\"48\">4 Years</option>
<option value=\"60\">5 Years</option>
<option value=\"60\">More than 5 Years</option>
</select>
Marital Status 
<select name=\"maritalStatus\">
<option value=\"".$row["maritalStatus"]."\">".$row["maritalStatus"]."</option>
<option value=\"M\">Married</option>
<option value=\"S\" selected>Single</option>
</select>
Single Parent? 
<select name=\"singleParent\">
<option value=\"".$row["singleParent"]."\">".$row["singleParent"]."</option>
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select><br>
How many years have you had a drivers license? <input class=\"blue\" name=\"yearsLicensed\" value=\"".$row["yearsLicensed"]."\">
Does anyone else Fifteen years or older live with you? 
<label><input class=\"blue\" name=\"fifteenOlder\" type=\"radio\" value=\"Yes\"");

if($row["fifteenOlder"] == "Yes")
{
	echo(" checked");
}

echo(">Yes</label>
<label><input class=\"blue\" name=\"fifteenOlder\" type=\"radio\" value=\"No\"");

if($row["fifteenOlder"] == "No")
{
	echo(" checked");
}

echo( ">No</label><br>

Other Driver 1: Name: <input class=\"blue\" name=\"otherDriver1Name\" value=\"".$row["otherDriver1Name"]."\"> Date of Birth: ");
$month = substr($row["otherDriver1DOB"], 5, 2);
$day = substr($row["otherDriver1DOB"], 8, 2);
$year = substr($row["otherDriver1DOB"], 0, 4);
month_drop("$month","OD1");
echo( "/" );
day_drop("$day","OD1");
echo( "/" );
big_year_drop("1930","$year","OD1");

echo( "<br>Other Driver 2: Name: <input class=\"blue\" name=\"otherDriver2Name\" value=\"".$row["otherDriver2Name"]."\"> Date of Birth: ");
$month = substr($row["otherDriver2DOB"], 5, 2);
$day = substr($row["otherDriver2DOB"], 8, 2);
$year = substr($row["otherDriver2DOB"], 0, 4);
month_drop("$month","OD2");
echo( "/" );
day_drop("$day","OD2");
echo( "/" );
big_year_drop("1930","$year","OD2");

echo( "<br>Other Driver 3: Name: <input class=\"blue\" name=\"otherDriver3Name\" value=\"".$row["otherDriver3Name"]."\"> Date of Birth: ");
$month = substr($row["otherDriver3DOB"], 5, 2);
$day = substr($row["otherDriver3DOB"], 8, 2);
$year = substr($row["otherDriver3DOB"], 0, 4);
month_drop("$month","OD3");
echo( "/" );
day_drop("$day","OD3");
echo( "/" );
big_year_drop("1930","$year","OD3");
echo( "<br>
Does anyone have anything on their driving record in the past 5 years?(If an SR-22 is needed, indicate here):<br>
<textarea name=\"violations\" cols=\"50\" rows=\"10\">".$row["violations"]."</textarea><br>

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
</tr>
<tr> 
<td height=\"31\"><div align=\"center\">1:</div></td>
<td><div align=\"center\"> ");
big_year_drop("1950", "".$row["vehicle1Year"]."", "VH1");
echo("</div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle1Make\" size=\"10\" value=\"".$row["vehicle1Make"]."\"></div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle1Model\" value=\"".$row["vehicle1Model"]."\"></div></td>
<td><div align=\"center\">
<select name=\"vehicle1Doors\">
<option value=\"".$row["vehicle1Doors"]."\" selected>".$row["vehicle1Doors"]."</option>
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1Cylinders\">
<option value=\"".$row["vehicle1Cylinders"]."\" selected>".$row["vehicle1Cylinders"]."</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
<option value=\"8\">8</option>
<option value=\"10\">10</option>
<option value=\"12\">12</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1Airbags\">
<option value=\"".$row["vehicle1Airbags"]."\" selected>".$row["vehicle1Airbags"]."</option>
<option value=\"B\">Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1ABS\">
<option value=\"".$row["vehicle1ABS"]."\" selected>".$row["vehicle1ABS"]."</option>
<option value=\"A\">Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1FourWheelDrive\">
<option value=\"".$row["vehicle1FourWheelDrive"]."\" selected>".$row["vehicle1FourWheelDrive"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle1Alarm\">
<option value=\"".$row["vehicle1Alarm"]."\" selected>".$row["vehicle1Alarm"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
<td height=\"31\"><div align=\"center\">2:</div></td>
<td><div align=\"center\"> ");
big_year_drop("1950", "".$row["vehicle2Year"]."", "VH2");
echo("</div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle2Make\" size=\"10\" value=\"".$row["vehicle2Make"]."\"></div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle2Model\" value=\"".$row["vehicle2Model"]."\"></div></td>
<td><div align=\"center\">
<select name=\"vehicle2Doors\">
<option value=\"".$row["vehicle2Doors"]."\" selected>".$row["vehicle2Doors"]."</option>
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2Cylinders\">
<option value=\"".$row["vehicle2Cylinders"]."\" selected>".$row["vehicle2Cylinders"]."</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
<option value=\"8\">8</option>
<option value=\"10\">10</option>
<option value=\"12\">12</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2Airbags\">
<option value=\"".$row["vehicle2Airbags"]."\" selected>".$row["vehicle2Airbags"]."</option>
<option value=\"B\">Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2ABS\">
<option value=\"".$row["vehicle2ABS"]."\" selected>".$row["vehicle2ABS"]."</option>
<option value=\"A\">Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2FourWheelDrive\">
<option value=\"".$row["vehicle2FourWheelDrive"]."\" selected>".$row["vehicle2FourWheelDrive"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle2Alarm\">
<option value=\"".$row["vehicle2Alarm"]."\" selected>".$row["vehicle2Alarm"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
<td height=\"31\"><div align=\"center\">3:</div></td>
<td><div align=\"center\"> ");
big_year_drop("1950", "".$row["vehicle3Year"]."", "VH3");
echo("</div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle3Make\" size=\"10\" value=\"".$row["vehicle3Make"]."\"></div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle3Model\" value=\"".$row["vehicle3Model"]."\"></div></td>
<td><div align=\"center\">
<select name=\"vehicle3Doors\">
<option value=\"".$row["vehicle3Doors"]."\" selected>".$row["vehicle3Doors"]."</option>
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3Cylinders\">
<option value=\"".$row["vehicle3Cylinders"]."\" selected>".$row["vehicle3Cylinders"]."</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
<option value=\"8\">8</option>
<option value=\"10\">10</option>
<option value=\"12\">12</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3Airbags\">
<option value=\"".$row["vehicle3Airbags"]."\" selected>".$row["vehicle3Airbags"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3ABS\">
<option value=\"".$row["vehicle3ABS"]."\" selected>".$row["vehicle3ABS"]."</option>
<option value=\"A\">Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3FourWheelDrive\">
<option value=\"".$row["vehicle3FourWheelDrive"]."\" selected>".$row["vehicle3FourWheelDrive"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle3Alarm\">
<option value=\"".$row["vehicle3Alarm"]."\" selected>".$row["vehicle3Alarm"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
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
</tr>
<tr> 
<td height=\"31\"><div align=\"center\">1:</div></td>
<td><div align=\"center\">
<select name=\"vehicle1CoverageType\">
<option value=\"".$row["vehicle1CoverageType"]."\" selected> ".$row["vehicle1CoverageType"]."</option>
<option value=\"Liability only\">Liability only</option>
<option value=\"Liability + Comp\">Liability + Comp</option>
<option value=\"Full Coverage\">Full Coverage</option>
<option value=\"Comp only\">Comp only</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1LiabilityLimits\">
<option value=\"".$row["vehicle1LiabilityLimits"]."\" selected> ".$row["vehicle1LiabilityLimits"]."</option>
<option value=\"20/40/15\">20/40/15 (IL)</option>
<option value=\"25/50/25\">25/50/25 (MO)</option>
<option value=\"50/100/50\">50/100/50 (MO)</option>
<option value=\"100/300/100\">100/300/100 (MO)</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1Comp\">
<option value=\"".$row["vehicle1Comp"]."\" selected> ".$row["vehicle1Comp"]."</option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1Collision\">
<option value=\"".$row["vehicle1Collision"]."\" selected> ".$row["vehicle1Collision"]."</option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1Med\">
<option value=\"".$row["vehicle1Med"]."\" selected> ".$row["vehicle1Med"]."</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
<option value=\"2000\">2000</option>
<option value=\"5000\">5000</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle1Rental\">
<option value=\"".$row["vehicle1Rental"]."\" selected> ".$row["vehicle1Rental"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle1Towing\">
<option value=\"".$row["vehicle1Towing"]."\" selected> ".$row["vehicle1Towing"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
<tr> 
<td height=\"31\"><div align=\"center\">2:</div></td>
<td><div align=\"center\">
<select name=\"vehicle2CoverageType\">
<option value=\"".$row["vehicle2CoverageType"]."\" selected> ".$row["vehicle2CoverageType"]."</option>
<option value=\"Liability only\">Liability only</option>
<option value=\"Liability + Comp\">Liability + Comp</option>
<option value=\"Full Coverage\">Full Coverage</option>
<option value=\"Comp only\">Comp only</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2LiabilityLimits\">
<option value=\"".$row["vehicle2LiabilityLimits"]."\" selected> ".$row["vehicle2LiabilityLimits"]."</option>
<option value=\"20/40/15\">20/40/15 (IL)</option>
<option value=\"25/50/25\">25/50/25 (MO)</option>
<option value=\"50/100/50\">50/100/50 (MO)</option>
<option value=\"100/300/100\">100/300/100 (MO)</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2Comp\">
<option value=\"".$row["vehicle2Comp"]."\" selected> ".$row["vehicle2Comp"]."</option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2Collision\">
<option value=\"".$row["vehicle2Collision"]."\" selected> ".$row["vehicle2Collision"]."</option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2Med\">
<option value=\"".$row["vehicle2Med"]."\" selected> ".$row["vehicle2Med"]."</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
<option value=\"2000\">2000</option>
<option value=\"5000\">5000</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle2Rental\">
<option value=\"".$row["vehicle2Rental"]."\" selected> ".$row["vehicle2Rental"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle2Towing\">
<option value=\"".$row["vehicle2Towing"]."\" selected> ".$row["vehicle2Towing"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
<tr> 
<td height=\"31\"><div align=\"center\">3:</div></td>
<td><div align=\"center\">
<select name=\"vehicle3CoverageType\">
<option value=\"".$row["vehicle3CoverageType"]."\" selected> ".$row["vehicle3CoverageType"]."</option>
<option value=\"Liability only\">Liability only</option>
<option value=\"Liability + Comp\">Liability + Comp</option>
<option value=\"Full Coverage\">Full Coverage</option>
<option value=\"Comp only\">Comp only</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3LiabilityLimits\">
<option value=\"".$row["vehicle3LiabilityLimits"]."\" selected> ".$row["vehicle3LiabilityLimits"]."</option>
<option value=\"20/40/15\">20/40/15 (IL)</option>
<option value=\"25/50/25\">25/50/25 (MO)</option>
<option value=\"50/100/50\">50/100/50 (MO)</option>
<option value=\"100/300/100\">100/300/100 (MO)</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3Comp\">
<option value=\"".$row["vehicle3Comp"]."\" selected> ".$row["vehicle3Comp"]."</option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3Collision\">
<option value=\"".$row["vehicle3Collision"]."\" selected> ".$row["vehicle3Collision"]."</option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3Med\">
<option value=\"".$row["vehicle3Med"]."\" selected> ".$row["vehicle3Med"]."</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
<option value=\"2000\">2000</option>
<option value=\"5000\">5000</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle3Rental\">
<option value=\"".$row["vehicle3Rental"]."\" selected> ".$row["vehicle3Rental"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle3Towing\">
<option value=\"".$row["vehicle3Towing"]."\" selected> ".$row["vehicle3Towing"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
</table>
Occupation: <input class=\"blue\" name=\"occupation\" value=\"".$row["occupation"]."\"> How long have you worked at your job? <input class=\"blue\" name=\"timeAtJob\" value=\"".$row["timeAtJob"]."\"> My vehicle is a part of my job <input class=\"blue\" name=\"jobVehicle\" type=\"checkbox\" value=\"Yes\"");
if($row["jobVehicle"] == "yes")
{
	echo( " checked");
}
echo( "><br>
How many miles do you drive to work (one way)? <input class=\"blue\" name=\"milesToWork\" value=\"".$row["milesToWork"]."\"> How many miles do you drive in a year (average is 12,000)? <input class=\"blue\" name=\"annualMileage\" size=\"8\" maxlength=\"6\" value=\"".$row["annualMileage"]."\"><br>

Do you have insurance right now? <select name=\"insuranceNow\">
<option value=\"".$row["insuranceNow"]."\" selected> ".$row["insuranceNow"]."</option>
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select>
if not, how long without? <input class=\"blue\" name=\"howLongWithout\" value=\"".$row["howLongWithout"]."\"></select>If so, with who? <input class=\"blue\" name=\"withWho\" value=\"".$row["withWho"]."\">For how many months? <input class=\"blue\" name=\"priorMonthsCovg\" value=\"".$row["priorMonthsCovg"]."\"><br>
Prior liability limits: <select name=\"priorLiabilityLimits\">
<option value=\"".$row["priorLiabilityLimits"]."\">".$row["priorLiabilityLimits"]."</option>
<option value=\"25/50/25\">25/50/25</option>
<option value=\"50/100/50\">50/100/50</option>
<option value=\"100/300/100\">100/300/100</option>
</select>
Do you own your home? 
<select name=\"homeowner\">
<option value=\"".$row["homeowner"]."\" selected> ".$row["homeowner"]."</option>
<option value=\"Own\">Own</option>
<option value=\"Rent\">Rent</option>
<option value=\"Other\">Other</option>
<option value=\"No\">No</option>
</select>
Do you have insurance (homeowners/renters/condo)? 
<select name=\"homeInsurance\">
<option value=\"".$row["homeInsurance"]."\" selected> ".$row["homeInsurance"]."</option>
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select>
<br>
Are all the vehicles titled in your name or a name listed above? 
<select name=\"titledInListed\">
<option value=\"".$row["titledInListed"]."\" selected> ".$row["titledInListed"]."</option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
<br>
Social Security Number: <input class=\"blue\" name=\"ssn\" value=\"".$row["ssn"]."\">
I like to pay my insurance: 
<label> 
<input type=\"radio\" name=\"payplan\" value=\"In Full\"");

if($row["payplan"] == "In Full")
{
	echo( " checked");
}

echo(">
In Full</label>
<label> 
<input class=\"blue\" name=\"payplan\" type=\"radio\" value=\"Monthly\"");

if($row["payplan"] == "Monthly")
{
	echo( " checked");
}

echo(">
Monthly</label>

<label>
<input class=\"blue\" name=\"payplan\" type=\"radio\" value=\"EFT\"");

if($row["payplan"] == "EFT")
{
	echo( " checked");
}

echo( ">
Monthly from Checking (EFT)</label><br>


Any additional comments?<br>
<textarea name=\"comments\" cols=\"50\" rows=\"10\" id=\"Additional Comments\">".$row["comments"]."</textarea>
<br>");

if($row["completed"] == "no")
{
echo("<h2>Remove this quote from Pending?
<input class=\"blue\" name=\"completed\" type=\"radio\" value=\"yes\">Yes 
<input class=\"blue\" name=\"completed\" type=\"radio\" value=\"no\" checked>No<br></h2>");
}

$sql2 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY `OfficeNumber`";
$selectResult2 = mysql_query($sql2);
echo("Transfer this quote to: <select name=\"office\">");
while($row2 = mysql_fetch_array($selectResult2))
{
	echo("<option value=\"".$row2["Database"]."\"");

	if($row2["Database"] == $office)
	{
		echo( " selected" );
	}

	echo( ">".$row2["DisplayName"]."</option>");
}
echo("</select>
<br>
<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">
</form>
<form action=\"quotesheet_delete.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"$id\">
<input type=\"Button\" value=\"Delete\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[1].submit()\">
</form>
<input type=\"button\" value=\"Export to Turborater\" onclick=\"location.href='quote_export.php?id=$id'\"><br>
<input type=\"button\" value=\"Print\" onclick=\"location.href='quotesheet_print.php?id=$id'\">
"
);

	

?>
