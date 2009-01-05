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

echo( "
<h1>Quote Sheet</h1>
<form action=\"quotesheet_insert.php\" method=\"post\">
<input type=\"hidden\" name=\"office\" value=\"$office\">
<input type=\"hidden\" name=\"group\" value=\"$group\">
<table border=\"0\" cellpadding=\"4\" cellspacing=\"0\">
<tr><td>First Name:</td><td><input class=\"blue\" name=\"firstName\"></td><td>Last Name:</td><td><input class=\"blue\" name=\"lastName\"></td><td>Phone Number:</td><td><input class=\"blue\" name=\"phoneNumber\"> ex. 314-555-1234</td></tr>
<tr><td>Address:</td><td colspan=\"5\"><input class=\"blue\" name=\"address\" size=\"80\" maxlength=\"80\"></td></tr>
<tr><td>City:</td><td><input class=\"blue\" name=\"city\"></td><td>State:</td><td><input class=\"blue\" name=\"state\"></td><td>Zip:</td><td><input class=\"blue\" name=\"zipCode\" size=\"12\" maxlength=\"10\"></td></tr>
</table><br>
Date of Birth: ");
month_drop("","1");
echo( "/" );
day_drop("","1");
echo( "/" );
big_year_drop("1930","","1");
echo( "<br>
How long have you lived at your residence? 
<select name=\"timeAtResidence\">
<option value=\" \"> </option>
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
<option value=\" \" selected> </option>
<option value=\"M\">Married</option>
<option value=\"S\" selected>Single</option>
</select>
Single Parent? 
<select name=\"singleParent\">
<option value=\" \" selected> </option>
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select><br>
How many years have you had a drivers license? <input class=\"blue\" name=\"yearsLicensed\">
Does anyone else Fifteen years or older live with you? 
<label><input class=\"blue\" name=\"fifteenOlder\" type=\"radio\" value=\"Yes\" checked>Yes</label>
<label><input class=\"blue\" name=\"fifteenOlder\" type=\"radio\" value=\"No\">No</label><br>
Other Driver 1: Name: <input class=\"blue\" name=\"otherDriver1Name\"> Date of Birth: ");
month_drop("","OD1");
echo( "/" );
day_drop("","OD1");
echo( "/" );
big_year_drop("1930","","OD1");
echo( "<br>Other Driver 2: Name: <input class=\"blue\" name=\"otherDriver2Name\"> Date of Birth: ");
month_drop("","OD2");
echo( "/" );
day_drop("","OD2");
echo( "/" );
big_year_drop("1930","","OD2");
echo( "<br>Other Driver 3: Name: <input class=\"blue\" name=\"otherDriver3Name\"> Date of Birth: ");
month_drop("","OD3");
echo( "/" );
day_drop("","OD3");
echo( "/" );
big_year_drop("1930","","OD3");
echo( "<br>
Does anyone have anything on their driving record in the past 5 years?(If an SR-22 is needed, indicate here):<br>
<textarea name=\"violations\" cols=\"50\" rows=\"10\"></textarea><br>

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
big_year_drop("1950", "", "VH1");
echo("</div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle1Make\" size=\"10\"></div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle1Model\"></div></td>
<td><div align=\"center\">
<select name=\"vehicle1Doors\">
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\" selected>4</option>
<option value=\"5\">5</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1Cylinders\">
<option value=\"3\">3</option>
<option value=\"4\" selected>4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
<option value=\"8\">8</option>
<option value=\"10\">10</option>
<option value=\"12\">12</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1Airbags\">
<option value=\"B\" selected>Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1ABS\">
<option value=\"A\" selected>Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle1FourWheelDrive\">
<option value=\"Yes\">Yes</option>
<option value=\"No\" selected>No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle1Alarm\">
<option value=\"Yes\">Yes</option>
<option value=\"No\" selected>No</option>
</select>
</div></td>
</tr>
<td height=\"31\"><div align=\"center\">2:</div></td>
<td><div align=\"center\"> ");
big_year_drop("1950", "", "VH2");
echo("</div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle2Make\" size=\"10\"></div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle2Model\"></div></td>
<td><div align=\"center\">
<select name=\"vehicle2Doors\">
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\" selected>4</option>
<option value=\"5\">5</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2Cylinders\">
<option value=\"3\">3</option>
<option value=\"4\" selected>4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
<option value=\"8\">8</option>
<option value=\"10\">10</option>
<option value=\"12\">12</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2Airbags\">
<option value=\"B\" selected>Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2ABS\">
<option value=\"A\"selected>Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle2FourWheelDrive\">
<option value=\"Yes\">Yes</option>
<option value=\"No\" selected>No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle2Alarm\">
<option value=\"Yes\">Yes</option>
<option value=\"No\" selected>No</option>
</select>
</div></td>
</tr>
<td height=\"31\"><div align=\"center\">3:</div></td>
<td><div align=\"center\"> ");
big_year_drop("1950", "", "VH3");
echo("</div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle3Make\" size=\"10\"></div></td>
<td><div align=\"center\"><input class=\"blue\" name=\"vehicle3Model\"></div></td>
<td><div align=\"center\">
<select name=\"vehicle3Doors\">
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\" selected>4</option>
<option value=\"5\">5</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3Cylinders\">
<option value=\"3\">3</option>
<option value=\"4\" selected>4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
<option value=\"8\">8</option>
<option value=\"10\">10</option>
<option value=\"12\">12</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3Airbags\">
<option value=\"B\" selected>Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3ABS\">
<option value=\"A\" selected>Yes</option>
<option value=\"N\">No</option>
</select>
</div></td>
<td><div align=\"center\"> 
<select name=\"vehicle3FourWheelDrive\">
<option value=\"Yes\">Yes</option>
<option value=\"No\" selected>No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle3Alarm\">
<option value=\"Yes\">Yes</option>
<option value=\"No\" selected>No</option>
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
<option value=\" \"> </option>
<option value=\"Liability only\">Liability only</option>
<option value=\"Liability + Comp\">Liability + Comp</option>
<option value=\"Full Coverage\">Full Coverage</option>
<option value=\"Comp only\">Comp only</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1LiabilityLimits\">
<option value=\" \"> </option>
<option value=\"20/40/15\">20/40/15 (IL)</option>
<option value=\"25/50/25\">25/50/25 (MO)</option>
<option value=\"50/100/50\">50/100/50 (MO)</option>
<option value=\"100/300/100\">100/300/100 (MO)</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1Comp\">
<option value=\" \"> </option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1Collision\">
<option value=\" \"></option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle1Med\">
<option value=\" \"> </option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
<option value=\"2000\">2000</option>
<option value=\"5000\">5000</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle1Rental\">
<option value=\" \"> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle1Towing\">
<option value=\" \"> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
<tr> 
<td height=\"31\"><div align=\"center\">2:</div></td>
<td><div align=\"center\">
<select name=\"vehicle2CoverageType\">
<option value=\" \"> </option>
<option value=\"Liability only\">Liability only</option>
<option value=\"Liability + Comp\">Liability + Comp</option>
<option value=\"Full Coverage\">Full Coverage</option>
<option value=\"Comp only\">Comp only</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2LiabilityLimits\">
<option value=\" \"> </option>
<option value=\"20/40/15\">20/40/15 (IL)</option>
<option value=\"25/50/25\">25/50/25 (MO)</option>
<option value=\"50/100/50\">50/100/50 (MO)</option>
<option value=\"100/300/100\">100/300/100 (MO)</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2Comp\">
<option value=\" \"> </option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2Collision\">
<option value=\" \"></option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle2Med\">
<option value=\" \"> </option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
<option value=\"2000\">2000</option>
<option value=\"5000\">5000</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle2Rental\">
<option value=\" \"> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle2Towing\">
<option value=\" \"> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
<tr> 
<td height=\"31\"><div align=\"center\">3:</div></td>
<td><div align=\"center\">
<select name=\"vehicle3CoverageType\">
<option value=\" \"> </option>
<option value=\"Liability only\">Liability only</option>
<option value=\"Liability + Comp\">Liability + Comp</option>
<option value=\"Full Coverage\">Full Coverage</option>
<option value=\"Comp only\">Comp only</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3LiabilityLimits\">
<option value=\" \"> </option>
<option value=\"20/40/15\">20/40/15 (IL)</option>
<option value=\"25/50/25\">25/50/25 (MO)</option>
<option value=\"50/100/50\">50/100/50 (MO)</option>
<option value=\"100/300/100\">100/300/100 (MO)</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3Comp\">
<option value=\" \"> </option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3Collision\">
<option value=\" \"></option>
<option value=\"250\">250</option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
</select>
</div></td>
<td><div align=\"center\">$ 
<select name=\"vehicle3Med\">
<option value=\" \"> </option>
<option value=\"500\">500</option>
<option value=\"1000\">1000</option>
<option value=\"2000\">2000</option>
<option value=\"5000\">5000</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle3Rental\">
<option value=\" \"> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
<td><div align=\"center\">
<select name=\"vehicle3Towing\">
<option value=\" \"> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
</div></td>
</tr>
</table>
Occupation: <input class=\"blue\" name=\"occupation\"> How long have you worked at your job? <input class=\"blue\" name=\"timeAtJob\"> My vehicle is a part of my job <input class=\"blue\" name=\"jobVehicle\" type=\"checkbox\" value=\"Yes\"><br>
How many miles do you drive to work (one way)? <input class=\"blue\" name=\"milesToWork\"> How many miles do you drive in a year (average is 12,000)? <input class=\"blue\" name=\"annualMileage\" size=\"8\" maxlength=\"6\"><br>

Do you have insurance right now? <select name=\"insuranceNow\">
<option selected> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>If so, with who? <input class=\"blue\" name=\"withWho\"> For how many months? <input class=\"blue\" name=\"priorMonthsCovg\"> <br>if not, how long without? <input class=\"blue\" name=\"howLongWithout\">
Prior liability limits: <select name=\"priorLiabilityLimits\">
<option value=\" \"> </option>
<option value=\"25/50/25\">25/50/25</option>
<option value=\"50/100/50\">50/100/50</option>
<option value=\"100/300/100\">100/300/100</option>
</select>
Do you own your home? 
<select name=\"homeowner\">
<option> </option>
<option value=\"Own\">Own</option>
<option value=\"Rent\">Rent</option>
<option value=\"Other\">Other</option>
<option value=\"No\">No</option>
</select>
Do you have insurance (homeowners/renters/condo)? 
<select name=\"homeInsurance\">
<option> </option>
<option value=\"Y\">Yes</option>
<option value=\"N\">No</option>
</select>
<br>
Are all the vehicles titled in your name or a name listed above? 
<select name=\"titledInListed\">
<option> </option>
<option value=\"Yes\">Yes</option>
<option value=\"No\">No</option>
</select>
<br>
Social Security Number: <input class=\"blue\" name=\"ssn\">
I like to pay my insurance: 
<label> 
<input type=\"radio\" name=\"payplan\" value=\"In Full\">
In Full</label>
<label> 
<input class=\"blue\" name=\"payplan\" type=\"radio\" value=\"Monthly\" checked>
Monthly</label>
<label>
<input class=\"blue\" name=\"payplan\" type=\"radio\" value=\"EFT\">
Monthly from Checking (EFT)</label><br>
Any additional comments?<br>
<textarea name=\"comments\" cols=\"50\" rows=\"10\" id=\"Additional Comments\"></textarea>
<br>
<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">
</form>"
);


?>
