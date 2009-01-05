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

$sql0 = "UPDATE `quotes` SET 
`firstName` = '".$_POST["firstName"]."', 
`lastName` = '".$_POST["lastName"]."', 
`phoneNumber` = '".$_POST["phoneNumber"]."', 
`address` = '".$_POST["address"]."', 
`city` = '".$_POST["city"]."', 
`state` = '".$_POST["state"]."', 
`zipCode` = '".$_POST["zipCode"]."', 
`dob` = '".$_POST["year1"]."-".$_POST["month1"]."-".$_POST["day1"]."', 
`timeAtResidence` = '".$_POST["timeAtResidence"]."', 
`maritalStatus` = '".$_POST["maritalStatus"]."', 
`singleParent` = '".$_POST["singleParent"]."', 
`yearsLicensed` = '".$_POST["yearsLicensed"]."', 
`fifteenOlder` = '".$_POST["fifteenOlder"]."', 
`otherDriver1Name` = '".$_POST["otherDriver1Name"]."', 
`otherDriver1DOB` = '".$_POST["yearOD1"]."-".$_POST["monthOD1"]."-".$_POST["dayOD1"]."', 
`otherDriver2Name` = '".$_POST["otherDriver2Name"]."', 
`otherDriver2DOB` = '".$_POST["yearOD2"]."-".$_POST["monthOD2"]."-".$_POST["dayOD2"]."', 
`otherDriver3Name` = '".$_POST["otherDriver3Name"]."', 
`otherDriver3DOB` = '".$_POST["yearOD3"]."-".$_POST["monthOD3"]."-".$_POST["dayOD3"]."', 
`violations` = '".$_POST["violations"]."', 
`vehicle1Year` = '".$_POST["yearVH1"]."', 
`vehicle1Make` = '".$_POST["vehicle1Make"]."', 
`vehicle1Model` = '".$_POST["vehicle1Model"]."', 
`vehicle1Doors` = '".$_POST["vehicle1Doors"]."', 
`vehicle1Cylinders` = '".$_POST["vehicle1Cylinders"]."', 
`vehicle1Airbags` = '".$_POST["vehicle1Airbags"]."', 
`vehicle1ABS` = '".$_POST["vehicle1ABS"]."', 
`vehicle1FourWheelDrive` = '".$_POST["vehicle1FourWheelDrive"]."', 
`vehicle1Alarm` = '".$_POST["vehicle1Alarm"]."', 
`vehicle2Year` = '".$_POST["yearVH2"]."', 
`vehicle2Make` = '".$_POST["vehicle2Make"]."', 
`vehicle2Model` = '".$_POST["vehicle2Model"]."', 
`vehicle2Doors` = '".$_POST["vehicle2Doors"]."', 
`vehicle2Cylinders` = '".$_POST["vehicle2Cylinders"]."', 
`vehicle2Airbags` = '".$_POST["vehicle2Airbags"]."', 
`vehicle2ABS` = '".$_POST["vehicle2ABS"]."', 
`vehicle2FourWheelDrive` = '".$_POST["vehicle2FourWheelDrive"]."', 
`vehicle2Alarm` = '".$_POST["vehicle2Alarm"]."', 
`vehicle3Year` = '".$_POST["yearVH3"]."', 
`vehicle3Make` = '".$_POST["vehicle3Make"]."', 
`vehicle3Model` = '".$_POST["vehicle3Model"]."', 
`vehicle3Doors` = '".$_POST["vehicle3Doors"]."', 
`vehicle3Cylinders` = '".$_POST["vehicle3Cylinders"]."', 
`vehicle3Airbags` = '".$_POST["vehicle3Airbags"]."', 
`vehicle3ABS` = '".$_POST["vehicle3ABS"]."', 
`vehicle3FourWheelDrive` = '".$_POST["vehicle3FourWheelDrive"]."', 
`vehicle3Alarm` = '".$_POST["vehicle3Alarm"]."', 
`vehicle1CoverageType` = '".$_POST["vehicle1CoverageType"]."', 
`vehicle1LiabilityLimits` = '".$_POST["vehicle1LiabilityLimits"]."', 
`vehicle1Comp` = '".$_POST["vehicle1Comp"]."', 
`vehicle1Collision` = '".$_POST["vehicle1Collision"]."', 
`vehicle1Med` = '".$_POST["vehicle1Med"]."', 
`vehicle1Rental` = '".$_POST["vehicle1Rental"]."', 
`vehicle1Towing` = '".$_POST["vehicle1Towing"]."', 
`vehicle2CoverageType` = '".$_POST["vehicle2CoverageType"]."', 
`vehicle2LiabilityLimits` = '".$_POST["vehicle2LiabilityLimits"]."', 
`vehicle2Comp` = '".$_POST["vehicle2Comp"]."', 
`vehicle2Collision` = '".$_POST["vehicle2Collision"]."', 
`vehicle2Med` = '".$_POST["vehicle2Med"]."', 
`vehicle2Rental` = '".$_POST["vehicle2Rental"]."', 
`vehicle2Towing` = '".$_POST["vehicle2Towing"]."', 
`vehicle3CoverageType` = '".$_POST["vehicle3CoverageType"]."', 
`vehicle3LiabilityLimits` = '".$_POST["vehicle3LiabilityLimits"]."', 
`vehicle3Comp` = '".$_POST["vehicle3Comp"]."', 
`vehicle3Collision` = '".$_POST["vehicle3Collision"]."', 
`vehicle3Med` = '".$_POST["vehicle3Med"]."', 
`vehicle3Rental` = '".$_POST["vehicle3Rental"]."', 
`vehicle3Towing` = '".$_POST["vehicle3Towing"]."', 
`occupation` = '".$_POST["occupation"]."', 
`timeAtJob` = '".$_POST["timeAtJob"]."', 
`jobVehicle` = '".$_POST["jobVehicle"]."', 
`milesToWork` = '".$_POST["milesToWork"]."', 
`annualMileage` = '".$_POST["annualMileage"]."', 
`insuranceNow` = '".$_POST["insuranceNow"]."', 
`withWho` = '".$_POST["withWho"]."', 
`priorLiabilityLimits` = '".$_POST["priorLiabilityLimits"]."', 
`howLongWithout` = '".$_POST["howLongWithout"]."', 
`homeOwner` = '".$_POST["homeOwner"]."', 
`homeInsurance` = '".$_POST["homeInsurance"]."', 
`titledInListed` = '".$_POST["titledInListed"]."', 
`ssn` = '".$_POST["ssn"]."', 
`payplan` = '".$_POST["payplan"]."', 
`office` = '".$_POST["office"]."', 
`completed` = '".$_POST["completed"]."', 
`priorMonthsCovg` = '".$_POST["priorMonthsCovg"]."',
`comments` = '".$_POST["comments"]."' 
WHERE `ID` = '".$_POST["id"]."'";

$insertresult = mysql_query($sql0);

if($insertresult != 1)
{
	log_error("Quote update failed: $sql0", "quotesheet_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "Failed to update quote<br>$sql0" );
}

echo( "
<script>
<!--
location=\"quotesheet_search.php\";
//-->
</script> 
" );
?>
