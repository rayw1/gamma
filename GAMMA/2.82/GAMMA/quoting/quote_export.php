<?php
//GAMMA V2.7 CERTIFIED
session_start();
header("Content-type: application/txt");
$header2 = "Content-Disposition: attachment; filename=quote.tt2";
header($header2);
$valid = $_SESSION["validsession"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../includes/common.inc');
connect_to();

$id = $_GET["id"];
$sql0 = "SELECT * FROM `quotes` WHERE `ID` = '$id'";
$selectResult0 = mysql_query($sql0);
$row = mysql_fetch_array($selectResult0);

if($row["office"] != $office || $row["group"] != $group)
{
	log_error("Could not obtain logbook structure", "logbook_struct_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "General Security Failure: Possibly Malformed URI");
}

//Named Insured
echo("\"tagname\",\"scope\",\"value1\",\"value2\",\"value3\",\"value4\"\r\n");
echo("\"firstname\",\"pol0\",\"".$row["firstName"]."\"\r\n");
echo("\"firstname\",\"drv1\",\"".$row["firstName"]."\"\r\n");
echo("\"lastname\",\"pol0\",\"".$row["lastName"]."\"\r\n");
echo("\"lastname\",\"drv1\",\"".$row["lastName"]."\"\r\n");

$numDrivers = 1;

$acode = substr($row["phoneNumber"], 0,3);
$prefix = substr($row["phoneNumber"], 4,3);
$suffix = substr($row["phoneNumber"], 8,4);
echo("\"homephone\",\"pol0\",\"($acode) $prefix-$suffix\"\r\n");
echo("\"address1\",\"pol0\",\"".$row["address"]."\"\r\n");
echo("\"city\",\"pol0\",\"".$row["city"]."\"\r\n");
echo("\"state\",\"pol0\",\"".$row["state"]."\"\r\n");
echo("\"zipcode\",\"pol0\",\"".$row["zipCode"]."\"\r\n");
echo("\"zipcode\",\"car1\",\"".$row["zipCode"]."\"\r\n");
$month = substr($row["dob"],5,2);
$day = substr($row["dob"],8,2);
$year = substr($row["dob"], 0, 4);
echo("\"dob\",\"pol0\",\"04/07/3000\"\r\n");
echo("\"dob\",\"drv1\",\"$month/$day/$year\"\r\n");
echo("\"residetime\",\"drv1\",\"".$row["timeAtResidence"]."\"\r\n");
echo("\"maritaltype\",\"drv1\",\"".$row["maritalStatus"]."\"\r\n");
echo("\"singleparent\",\"drv1\",\"".$row["singleParent"]."\"\r\n");
$monthsLicensed = $row["yearsLicensed"] * 12;
echo("\"monthslicensed\",\"drv1\",\"$monthsLicensed\"\r\n");

//other drivers
$month = substr($row["otherDriver1DOB"],5,2);
$day = substr($row["otherDriver1DOB"],8,2);
$year = substr($row["otherDriver1DOB"],0,4);
echo("\"dob\",\"drv2\",\"$month/$day/$year\"\r\n");
if( $row["otherDriver1Name"] != "")
{
	$numDrivers++;
	echo("\"firstname\",\"drv2\",\"".$row["otherDriver1Name"]."\"\r\n");
}

$month = substr($row["otherDriver2DOB"],5,2);
$day = substr($row["otherDriver2DOB"],8,2);
$year = substr($row["otherDriver2DOB"],0,4);
echo("\"dob\",\"drv3\",\"$month/$day/$year\"\r\n");
if( $row["otherDriver2Name"] != "")
{
	$numDrivers++;
	echo("\"firstname\",\"drv3\",\"".$row["otherDriver2Name"]."\"\r\n");
}

$month = substr($row["otherDriver3DOB"],5,2);
$day = substr($row["otherDriver3DOB"],8,2);
$year = substr($row["otherDriver3DOB"],0,4);
echo("\"dob\",\"drv4\",\"$month/$day/$year\"\r\n");
if( $row["otherDriver3Name"] != "")
{
	$numDrivers++;
	echo("\"firstname\",\"drv4\",\"".$row["otherDriver3Name"]."\"\r\n");
}

echo( "\"numofdrivers\",\"pol0\",\"$numDrivers\"\r\n");

//Vehicles
echo( "\"airbags\",\"car1\",\"".$row["vehicle1Airbags"]."\"\r\n" ); //b(oth) or n(one)
echo( "\"airbags\",\"car2\",\"".$row["vehicle2Airbags"]."\"\r\n" ); //b(oth) or n(one)
echo( "\"airbags\",\"car3\",\"".$row["vehicle3Airbags"]."\"\r\n" ); //b(oth) or n(one)

echo( "\"antilock\",\"car1\",\"".$row["vehicle1ABS"]."\"\r\n" ); //n(one) or a(ll)
echo( "\"antilock\",\"car2\",\"".$row["vehicle2ABS"]."\"\r\n" ); //n(one) or a(ll)
echo( "\"antilock\",\"car3\",\"".$row["vehicle3ABS"]."\"\r\n" ); //n(one) or a(ll)

$numCars = 0;
if($row["vehicle1Make"] != "")
{
	$numCars++;
	echo( "\"numofcyl\",\"car1\",\"".$row["vehicle1Cylinders"]."\"\r\n" );
	echo( "\"numofdoors\",\"car1\",\"".$row["vehicle1Doors"]."\"\r\n" );
	echo( "\"year\",\"car1\",\"".$row["vehicle1Year"]."\"\r\n" );

	$make = $row["vehicle1Make"];
	$make = strtoupper($make);
	echo( "\"maker\",\"car1\",\"$make\"\r\n" );

	$model = $row["vehicle1Model"];
	$model = strtoupper($model);
	echo( "\"model\",\"car1\",\"$model\"\r\n" );

	echo( "\"subtotalpremium\",\"car1\",\"280\"\r\n" );
}
if($row["vehicle2Make"] != "")
{
	$numCars++;
	echo( "\"numofcyl\",\"car2\",\"".$row["vehicle2Cylinders"]."\"\r\n" );
	echo( "\"numofdoors\",\"car2\",\"".$row["vehicle2Doors"]."\"\r\n" );
	echo( "\"year\",\"car2\",\"".$row["vehicle2Year"]."\"\r\n" );

	$make = $row["vehicle2Make"];
	$make = strtoupper($make);
	echo( "\"maker\",\"car2\",\"$make\"\r\n" );

	$model = $row["vehicle2Model"];
	$model = strtoupper($model);
	echo( "\"model\",\"car2\",\"$model\"\r\n" );

	echo( "\"subtotalpremium\",\"car2\",\"280\"\r\n" );
}
if($row["vehicle3Make"] != "")
{
	$numCars++;
	echo( "\"numofcyl\",\"car3\",\"".$row["vehicle3Cylinders"]."\"\r\n" );
	echo( "\"numofdoors\",\"car3\",\"".$row["vehicle3Doors"]."\"\r\n" );
	echo( "\"year\",\"car3\",\"".$row["vehicle3Year"]."\"\r\n" );

	$make = $row["vehicle3Make"];
	$make = strtoupper($make);
	echo( "\"maker\",\"car3\",\"$make\"\r\n" );

	$model = $row["vehicle3Model"];
	$model = strtoupper($model);
	echo( "\"model\",\"car3\",\"$model\"\r\n" );

	echo( "\"subtotalpremium\",\"car3\",\"280\"\r\n" );
}

echo( "\"numofcars\",\"pol0\",\"$numCars\"\r\n" );

//Coverage
for($i = 1; $i <= $numCars; $i++)
{
	$vehXLiaLImits = "vehicle".$i."LiabilityLimits";
	if($row[$vehXLiaLImits] == "25/50/25")
	{
		echo( "\"uninsbi\",\"car$i\",\"Y\"\r\n" );
		echo( "\"uninsbilimits1\",\"car$i\",\"25\"\r\n" );
		echo( "\"uninsbilimits2\",\"car$i\",\"50\"\r\n" );
		echo( "\"uninsbipremium\",\"car$i\",\"34\"\r\n" );
		echo( "\"liab\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabbi\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabbipremium\",\"car$i\",\"139\"\r\n" );
		echo( "\"liabpd\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabpdpremium\",\"car$i\",\"107\"\r\n" );
		echo( "\"liablimits1\",\"car$i\",\"25\"\r\n" );
		echo( "\"liablimits2\",\"car$i\",\"50\"\r\n" );
		echo( "\"liablimits3\",\"car$i\",\"25\"\r\n" );
	}
	elseif($row[$vehXLiaLImits] == "50/100/50")
	{
		echo( "\"uninsbi\",\"car$i\",\"Y\"\r\n" );
		echo( "\"uninsbilimits1\",\"car$i\",\"50\"\r\n" );
		echo( "\"uninsbilimits2\",\"car$i\",\"100\"\r\n" );
		echo( "\"uninsbipremium\",\"car$i\",\"34\"\r\n" );
		echo( "\"liab\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabbi\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabbipremium\",\"car$i\",\"139\"\r\n" );
		echo( "\"liabpd\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabpdpremium\",\"car$i\",\"107\"\r\n" );
		echo( "\"liablimits1\",\"car$i\",\"50\"\r\n" );
		echo( "\"liablimits2\",\"car$i\",\"100\"\r\n" );
		echo( "\"liablimits3\",\"car$i\",\"50\"\r\n" );
	}
	elseif($row[$vehXLiaLImits] == "100/300/100")
	{
		echo( "\"uninsbi\",\"car$i\",\"Y\"\r\n" );
		echo( "\"uninsbilimits1\",\"car$i\",\"100\"\r\n" );
		echo( "\"uninsbilimits2\",\"car$i\",\"300\"\r\n" );
		echo( "\"uninsbipremium\",\"car$i\",\"34\"\r\n" );
		echo( "\"liab\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabbi\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabbipremium\",\"car$i\",\"139\"\r\n" );
		echo( "\"liabpd\",\"car$i\",\"Y\"\r\n" );
		echo( "\"liabpdpremium\",\"car$i\",\"107\"\r\n" );
		echo( "\"liablimits1\",\"car$i\",\"100\"\r\n" );
		echo( "\"liablimits2\",\"car$i\",\"300\"\r\n" );
		echo( "\"liablimits3\",\"car$i\",\"100\"\r\n" );
	}
	$varName = "vehicle".$i."Comp";
	if($row[$varName] > 0)
	{
		echo( "\"comp\",\"car$i\",\"Y\"\r\n");
		echo( "\"compded\",\"car$i\",\"".$row[$varName]."\"\r\n" ); //comprehensive
		echo( "\"comppremium\",\"car$i\",\"500\"\r\n");
	}
	else
	{
		echo( "\"comp\",\"car$i\",\"N\"\r\n");
		echo( "\"comppremium\",\"car$i\",\"0\"\r\n");
	}
	
	$varName = "vehicle".$i."Collision";
	if($row[$varName] > 0)
	{
		echo( "\"coll\",\"car$i\",\"Y\"\r\n");
		echo( "\"collded\",\"car$i\",\"".$row[$varName]."\"\r\n" ); //collision
		echo( "\"collpremium\",\"car$i\",\"500\"\r\n");
	}
	else
	{
		echo( "\"coll\",\"car$i\",\"N\"\r\n");
		echo( "\"collpremium\",\"car$i\",\"0\"\r\n");
	}

	$varName = "vehicle".$i."Med";
	if($row[$varName] > 0)
	{
		echo( "\"medpay\",\"car$i\",\"Y\"\r\n" );
		echo( "\"medpaylimit\",\"car$i\",\"".$row[$varName]."\"\r\n" );
		echo( "\"medpaypremium\",\"car$i\",\"500\"\r\n" );
	}

	$varName = "vehicle".$i."Rental";
	if($row[$varName] == "Yes")
	{
		echo( "\"rentallimit\",\"car$i\",\"15\"\r\n" );
		echo( "\"rentalpremium\",\"car$i\",\"25\"\r\n") ;
	}
	
	$varName = "vehicle".$i."Towing";
	if($row[$varName] == "Yes")
	{
		echo( "\"towinglimit\",\"car$i\",\"50\"\r\n" );
		echo( "\"towingpremium\",\"car$i\",\"25\"\r\n" );
	}
}

//Extra Information
if( $row["occupation"] != "")
{
	echo( "\"employed\",\"drv1\",\"E\"\r\n" );
}

echo( "\"milestowork\",\"drv1\",\"".$row["milesToWork"]."\"\r\n" );
echo( "\"annualmiles\",\"car1\",\"".$row["annualMileage"]."\"\r\n" );

echo( "\"priorinsurance\",\"drv1\",\"".$row["insuranceNow"]."\"\r\n" );
echo( "\"priormonthscovg\",\"drv1\",\"".$row["priorMonthsCovg"]."\"\r\n");

//prior coverages
if($row["priorLiabilityLimits"] == "25/50/25")
{
	echo( "\"priorliablim1\",\"drv1\",\"25\"\r\n" );
	echo( "\"priorliablim2\",\"drv1\",\"50\"\r\n" );
	echo( "\"priorliablim3\",\"drv1\",\"25\"\r\n" );
}
elseif($row["priorLiabilityLimits"] == "50/100/50")
{
	echo( "\"priorliablim1\",\"drv1\",\"50\"\r\n" );
	echo( "\"priorliablim2\",\"drv1\",\"100\"\r\n" );
	echo( "\"priorliablim3\",\"drv1\",\"50\"\r\n" );
}
elseif($row["priorLiabilityLimits"] == "100/300/100")
{
	echo( "\"priorliablim1\",\"drv1\",\"100\"\r\n" );
	echo( "\"priorliablim2\",\"drv1\",\"300\"\r\n" );
	echo( "\"priorliablim3\",\"drv1\",\"100\"\r\n" );
}

echo( "\"propertyinsurance\",\"drv1\",\"".$row["homeInsurance"]."\"\r\n" );
echo( "\"totalpolicypremium\",\"pol0\",\"280\"\r\n" );

?>
