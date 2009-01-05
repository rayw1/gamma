<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}


$firstDate = $_POST["year1"]."-".$_POST["month1"]."-".$_POST["day1"]." 00:00:0000";
$secondDate = $_POST["year2"]."-".$_POST["month2"]."-".$_POST["day2"]." 23:59:59";

$Algorithm = $_POST["Formula"];

if($Algorithm == "debug")
{
	echo( "First Date: $firstDate<br>" );
	echo( "Second Date: $secondDate<br>" );
}

if($Algorithm == "Logbook")
{
	echo( "<h1>" );
	echo( "$firstDate - $secondDate" );
	echo( " Policy Totals</h1>" );

	echo( "<table border=\"0\">" );

	connect_to();
	$sql0 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY 'DisplayName'";

	$items = mysql_query($sql0);

	while($result = mysql_fetch_array($items))
	{
		if($result["Database"] != "alttest")
		{
			$tempNumWritten = loggraph($result["DisplayName"], $result["Database"], $result["Color"], $firstDate, $secondDate, $group);
		}
		$numWritten = $tempNumWritten + $numWritten;
	}
	echo( "</table><br>Number of Policies total this month: <b>$numWritten</b><br>" );;
}

if($Algorithm == "Companies")
{
	echo( "<h1>Breakdown by Company for $firstDate - $secondDate" );
	echo( "</h1><table border =\"0\">" );
	companygraph($office, $firstDate, $secondDate, $group);
	echo( "</table>" );
}

if($Algorithm == "CompaniesAll")
{
	echo( "<h1>Breakdown by Company for $firstDate - $secondDate" );
	echo( "</h1><table border =\"0\">" );
	companygraphAll($firstDate, $secondDate, $group);
	echo( "</table>" );
}

if($Algorithm == "Referrals")
{
	echo( "<h1>Referral breakdown by type for $firstDate - $secondDate" );
	echo( "</h1><table border =\"0\">" );
	referralgraph($office, $firstDate, $secondDate, $group);
	echo( "</table>" );
}

if($Algorithm == "ReferralsAll")
{
	echo( "<h1>Referral breakdown by type for $firstDate - $secondDate" );
	echo( "</h1><table border =\"0\">" );
	referralgraphall($firstDate, $secondDate, $group);
	echo( "</table>" );
}

if($Algorithm == "Line")
{
	echo( "<h1>Line of business breakdown by type for $firstDate - $secondDate" );
	echo( "</h1><table border =\"0\">" );
	lineOfBusiness($office, $firstDate, $secondDate, $group);
	echo( "</table>" );
}

if($Algorithm == "LineAll")
{
	echo( "<h1>Line of business breakdown by type for $firstDate - $secondDate" );
	echo( "</h1><table border =\"0\">" );
	lineOfBusinessAll($group, $firstDate, $secondDate);
	echo( "</table>" );
}

if($Algorithm == "feesAndPremiums")
{
	echo( "<h1>Fees and Premiums for $firstDate - $secondDate</h1>");
	feesAndPremiums($group, $firstDate, $secondDate);
}

if($Algorithm == "feesAndPremiumsSingle")
{
	echo( "<h1>Fees and Premiums for $firstDate - $secondDate</h1>");
	feesAndPremiumsSingle($group, $firstDate, $secondDate, $office);
}

if($Algorithm == "PremiumPerCompanySingle")
{
	echo( "<h1>Premium Per Company For $firstDate - $secondDate</h1>");
	PremiumPerCompanySingle($group, $firstDate, $secondDate, $office);
}

if($Algorithm == "PremiumPerCompanyAll")
{
	echo( "<h1>Premium Per Company For $firstDate - $secondDate</h1>");
	PremiumPerCompanyAll($group, $firstDate, $secondDate);
}

if($Algorithm == "averagePremiumPerCompanySingle")
{
	echo( "<h1>AveragePremium Per Company For $firstDate - $secondDate</h1>");
	averagePremiumPerCompanySingle($group, $firstDate, $secondDate, $office);
}

if($Algorithm == "averagePremiumPerCompanyAll")
{
	echo( "<h1>Average Premium Per Company For $firstDate - $secondDate</h1>");
	averagePremiumPerCompanyAll($group, $firstDate, $secondDate);
}


function loggraph($oname, $dbase, $gcol, $d1, $d2, $group)
{
	connect_to();
	$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group'";

	echo( "<tr><td>" );
	echo( $oname );
	echo( ":</td><td>" );

	$itemList = mysql_query($sql);
	$i = 0;

	echo("<img src=\"images/" );
	echo( $gcol );
	echo( "l.jpg\" border=\"0\">" );
	$i = mysql_num_rows($itemList);

	for($b = 0; $b <= $i; $b++)
	{
		if($b >= 150)
		{
			echo("<img src=\"images/break.jpg\" border=\"0\">" );
			$b = $b + 700;
		}
		else
		{
			echo("<img src=\"images/" );
			echo( $gcol );
			echo( ".jpg\" border=\"0\">" );
		}
	}


	echo("<img src=\"images/" );
	echo( $gcol );
	echo( "r.jpg\" border=\"0\">" );

	echo( " <b>" );
	echo( $i );
	echo( "</b></td></tr>" );
	return $i;
}

function companygraph($dbase, $d1, $d2, $group)
{
	connect_to();
	$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group'";
	$logList = mysql_query($sql);
	if($logList == 0)
	{
		log_error("Could not select from logbook for company graph: $sql", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
		die("Could not obtain logbook info");
	}

	$i = 0;
	while($row = mysql_fetch_array($logList))
	{
		$itemList[$i] = $row["Company"];
		$i++;
	}

	$sql2 = "SELECT * FROM `companies` ORDER BY `Name`";
	$companyList = mysql_query($sql2);

	if($companyList == 0)
	{
		log_error("Could not select from companies for company graph: $sql2", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
		die("Could not get companies");
	}

	$x = 0;
	$y = 0;
	while($row = mysql_fetch_array($companyList))
	{
		for($x = 0; $x < $i; $x++)
		{
			if($row["Name"] == $itemList[$x])
			{
				$y++;
			}
		}
		if($y > 0)
		{
			echo( "<tr><td>".$row["Name"]."</td><td>" );
			echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
			for($x = 0; $x < $y; $x++)
			{
				echo( "<img src = \"images/black.jpg\" border = \"0\">" );
			}
			echo( "<img src=\"images/blackr.jpg\" border=\"0\">" );
			echo( " ".$y."</td></tr>" );
			$y = 0;
		}
	}
}

function referralgraph($dbase, $d1, $d2, $group)
{
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/common.inc');
	connect_to();
	$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group'";
	$logList = mysql_query($sql);
	if($logList == 0)
	{
		log_error("Could not select from logbook for referral graph: $sql", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
		die("Could not obtain logbook info");
	}

	$i = 0;
	while($row = mysql_fetch_row($logList))
	{
		if($i==0)
		{
			$num = count($row);
			for($inum = 0; $inum < $num; $inum++)
			{
				if(mysql_field_name($logList, $inum) == "Referred")
				{
					$inumResult = $inum;
				}
			}
		}
		$itemList[$i] = $row[$inumResult];
		$i++;
	}

	$filename = $_SERVER['DOCUMENT_ROOT']."/XML/referral.xml";
	$fh = fopen($filename, 'r');
	$readTo = filesize($filename);
	$rawReferrals = fread($fh, $readTo);
	fclose($fh);

	$referralArray = return_xml_array($rawReferrals, "referral");
	
	$referralNum = 1;
	foreach($referralArray as $singleReferral)
	{
		$referral[$referralNum] = return_xml($singleReferral, "name");
		$referralNum++;
	}

	$y = 0;

	for($x = 1; $x < $referralNum; $x++)
	{
		for($z = 0; $z < $i; $z++)
		{
			if($itemList[$z] == $referral[$x])
			{
				$y++;
			}
		}


		echo( "<tr><td>".$referral[$x]."</td><td>" );
		echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
		for($xy = 0; $xy < $y; $xy++)
		{
			echo( "<img src = \"images/black.jpg\" border = \"0\">" );
		}
		echo( "<img src=\"images/blackr.jpg\" border=\"0\">" );
		echo( " ".$y."</td></tr>" );
		$y = 0;

	}

}

function referralgraphall($d1, $d2, $group)
{
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/common.inc');
	connect_to();
	$sql0 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY 'DisplayName'";

	$items = mysql_query($sql0);

	if($items == 0)
	{
		log_error("Could not select from statistics for referral graph all: $sql0", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
		die("Could not get list of databases");
	}

	$i = 0;

	while($result = mysql_fetch_array($items))
	{
		if($result["Database"] != "alttest")
		{
			$dbase = $result["Database"];
			$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group'";
			$logList = mysql_query($sql);
			if($logList == 0)
			{
				log_error("Could not select from logbook for referral graph all: $sql", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
				die("Could not obtain logbook info");
			}


			while($row = mysql_fetch_row($logList))
			{
				$num = count($row);
				for($inum = 0; $inum < $num; $inum++)
				{
					if(mysql_field_name($logList, $inum) == "Referred")
					{
						$inumResult = $inum;
					}
				}

				$itemList[$i] = $row[$inumResult];
				$i++;
			}
		}
	}


	$filename = $_SERVER['DOCUMENT_ROOT']."/XML/referral.xml";
	$fh = fopen($filename, 'r');
	$readTo = filesize($filename);
	$rawReferrals = fread($fh, $readTo);
	fclose($fh);

	$referralArray = return_xml_array($rawReferrals, "referral");
	
	$referralNum = 1;
	foreach($referralArray as $singleReferral)
	{
		$referral[$referralNum] = return_xml($singleReferral, "name");
		$referralNum++;
	}

	$y = 0;

	for($x = 1; $x < $referralNum; $x++)
	{
		for($z = 0; $z < $i; $z++)
		{
			if($itemList[$z] == $referral[$x])
			{
				$y++;
			}
		}


		echo( "<tr><td>".$referral[$x]."</td><td>" );
		echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
		for($xy = 0; $xy < $y; $xy++)
		{
			if($xy > 100)
			{
				echo( "<img src = \"images/break.jpg\" border = \"0\">" );
				$xy = $xy+100;
			}
			else
			{
				echo( "<img src = \"images/black.jpg\" border = \"0\">" );
			}
		}
		echo( "<img src=\"images/blackr.jpg\" border=\"0\">" );
		echo( " ".$y."</td></tr>" );
		$y = 0;

	}

}

function companygraphAll($d1, $d2, $group)
{
	connect_to();
	$sql0 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY 'DisplayName'";

	$items = mysql_query($sql0);

	if($items == 0)
	{
		log_error("Could not select from statistics for company graph all: $sql0", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
		die("Could not get list of databases");
	}

	$i = 0;

	while($result = mysql_fetch_array($items))
	{
		if($result["Database"] != "alttest")
		{
			$dbase = $result["Database"];
			$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group'";
			$logList = mysql_query($sql);
			if($logList == 0)
			{
				log_error("Could not select from logbook for company graph all: $sql", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
				die("Could not obtain logbook info");
			}


			while($row = mysql_fetch_array($logList))
			{
				$itemList[$i] = $row["Company"];
				$i++;
			}
		}
	}

	$sql2 = "SELECT * FROM `companies` ORDER BY `Name`";
	$companyList = mysql_query($sql2);

	if($companyList == 0)
	{
		log_error("Could not select from companies for company graph all: $sql2", "stats_custom2.php", $_SESSION["username"], $_SESSION["group"]);
		die("Could not get companies");
	}

	$x = 0;
	$y = 0;
	while($row = mysql_fetch_array($companyList))
	{
		for($x = 0; $x < $i; $x++)
		{
			if($row["Name"] == $itemList[$x])
			{
				$y++;

			}
		}
		if($y > 0)
		{
			echo( "<tr><td><a href=\"companyBreakdownAll.php?company=".$row["Name"]."&date1=$d1&date2=$d2\">".$row["Name"]."</a></td><td>" );
			echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
			for($x = 0; $x < $y; $x++)
			{
				if($x > 100)
				{
					echo( "<img src = \"images/break.jpg\" border = \"0\">" );
					$x = $x+100;
				}
				else
				{
					echo( "<img src = \"images/black.jpg\" border = \"0\">" );
				}
			}
			echo( "<img src=\"images/blackr.jpg\" border=\"0\">" );
			echo( " ".$y."</td></tr>" );
			$y = 0;
		}
	}
}

function lineOfBusiness($dbase, $d1, $d2, $group)
{
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/common.inc');
	connect_to();
	$filename = $_SERVER['DOCUMENT_ROOT']."/XML/type.xml";
	$fh = fopen($filename, 'r');
	$readTo = filesize($filename);
	$rawTypes = fread($fh, $readTo);
	fclose($fh);

	$typeArray = return_xml_array($rawTypes, "type");

	foreach ($typeArray as $singleType)
	{
		$searchType = return_xml($singleType, "name");
		$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group' AND `Type` = '$searchType'";
		$selectResult = mysql_query($sql);

		$numType = mysql_numrows($selectResult);
		echo( "<tr><td>".$searchType.": </td><td>" );
		echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
		for($x = 0; $x <= $numType; $x++)
		{
			if($x > 100)
			{
				$x = $x+100;
				echo( "<img src=\"images/break.jpg\" border=\"0\">" );
			}
			else 
			{
				echo( "<img src=\"images/black.jpg\" border=\"0\">" );
			}	
		}
		echo( "<img src=\"images/blackr.jpg\" border=\"0\"> <b>".$numType."</b></td></tr>" );
	}
}

function lineOfBusinessAll($group, $d1, $d2)
{
	include_once($_SERVER['DOCUMENT_ROOT'].'/includes/common.inc');
	connect_to();
	$filename = $_SERVER['DOCUMENT_ROOT']."/XML/type.xml";
	$fh = fopen($filename, 'r');
	$readTo = filesize($filename);
	$rawTypes = fread($fh, $readTo);
	fclose($fh);

	$typeArray = return_xml_array($rawTypes, "type");

	foreach ($typeArray as $singleType)
	{
		$searchType = return_xml($singleType, "name");
		$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `group` = '$group' AND `Type` = '$searchType'";
		$selectResult = mysql_query($sql);

		$numType = mysql_numrows($selectResult);
		echo( "<tr><td>".$searchType.": </td><td>" );
		echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
		for($x = 0; $x <= $numType; $x++)
		{
			if($x > 100)
			{
				$x = $x+100;
				echo( "<img src=\"images/break.jpg\" border=\"0\">" );			
			}
			else 
			{
				echo( "<img src=\"images/black.jpg\" border=\"0\">" );
			}
		}
		echo( "<img src=\"images/blackr.jpg\" border=\"0\"> <b>".$numType."</b></td></tr>" );
	}

}

function feesAndPremiums($group, $d1, $d2)
{
	$totalNumPolicies = 0;
	$totalPremiumWritten = 0;
	$totalFeesCollected = 0;
	connect_to();
	$sql0 = "SELECT * FROM `statistics` WHERE `group` = '$group'";
	$selectResult0 = mysql_query($sql0);
	$totalNumDatabases = mysql_num_rows($selectResult0);
	while($row0 = mysql_fetch_array($selectResult0))
	{
		//ok, so now we have a list of all the offices in $row0, lets query each one and tally our totals
		$office = $row0["Database"];
		$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$office' AND `group` = '$group'";
		$selectResult1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($selectResult1))
		{
			$totalNumPolicies = $totalNumPolicies + 1;
			$totalPremiumWritten = $totalPremiumWritten + $row1["Premium"];
			$totalFeesCollected = $totalFeesCollected + $row1["Fee"];
		}
	}
	
	if($totalNumPolicies != 0)
	{
		$averagePremiumWritten = ceil($totalPremiumWritten / $totalNumPolicies);
		$averageFeesCollected = ceil($totalFeesCollected / $totalNumPolicies);
	}
	$averagePoliciesWritten = ceil($totalNumPolicies / $totalNumDatabases);
	
	echo( "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\">" );
	
	echo("<tr><td>Total Number of Policies Written: </td><td><b> $totalNumPolicies</b></td></tr>" );
	echo("<tr><td>Total Premium Written: </td><td><b> $totalPremiumWritten</b></td></tr>" );
	echo("<tr><td>Total Fees Collected: </td><td><b> $totalFeesCollected</b></td></tr>" );
	echo("<tr><td>Average Number of Policies Written: </td><td><b> $averagePoliciesWritten</b></td></tr>");
	echo("<tr><td>Average Premium Written: </td><td><b> $averagePremiumWritten</b></td></tr>" );
	echo("<tr><td>Average Fees Collected: </td><td><b> $averageFeesCollected</b></td></tr>" );
	
	echo( "</table>" );
}

function feesAndPremiumsSingle($group, $d1, $d2, $office)
{
	$totalNumPolicies = 0;
	$totalPremiumWritten = 0;
	$totalFeesCollected = 0;
	connect_to();
	$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$office' AND `group` = '$group'";
	$selectResult1 = mysql_query($sql1);
	while($row1 = mysql_fetch_array($selectResult1))
	{
		$totalNumPolicies = $totalNumPolicies + 1;
		$totalPremiumWritten = $totalPremiumWritten + $row1["Premium"];
		$totalFeesCollected = $totalFeesCollected + $row1["Fee"];
	}

	if($totalNumPolicies != 0)
	{
		$averagePremiumWritten = ceil($totalPremiumWritten / $totalNumPolicies);
		$averageFeesCollected = ceil($totalFeesCollected / $totalNumPolicies);
	}
	echo( "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\">" );
	
	echo("<tr><td>Total Number of Policies Written: </td><td><b> $totalNumPolicies</b></td></tr>" );
	echo("<tr><td>Total Premium Written: </td><td><b> $totalPremiumWritten</b></td></tr>" );
	echo("<tr><td>Total Fees Collected: </td><td><b> $totalFeesCollected</b></td></tr>" );
	echo("<tr><td>Average Premium Written: </td><td><b> $averagePremiumWritten</b></td></tr>" );
	echo("<tr><td>Average Fees Collected: </td><td><b> $averageFeesCollected</b></td></tr>" );
	
	echo( "</table>" );
}

function PremiumPerCompanySingle($group, $d1, $d2, $office)
{
	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
	connect_to();
	//ok, first lets get an array of companies
	$sql0 = "SELECT * FROM `companies` ORDER BY `Name`";
	$selectResult0 = mysql_query($sql0);
	while($row0 = mysql_fetch_array($selectResult0))
	{
		$tempPremium = 0;
		$company = $row0["Name"];
		//then lets search this office's logbook for policies written for that company during that time
		$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `Company` = '$company' AND `office` = '$office' AND `group` = '$group'";
		$selectResult1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($selectResult1))
		{
			$tempPremium = $tempPremium + $row1["Premium"];
		}
		//display the company name and the results, loop back to the next company
		if($tempPremium != 0)
		{
			echo( "<tr><td>$company</td><td>" );

			echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
			
			for($i = 0; $i <= $tempPremium; $i = $i + 100)
			{
				if($i < 10000)
				{
					echo( "<img src=\"images/black.jpg\" border=\"0\">" );
				}
				else 
				{
					echo( "<img src=\"images/break.jpg\" border=\"0\">" );
					$i = $i + 1000;
				}
			}

			echo( "<img src=\"images/blackr.jpg\" border=\"0\"> <b>$tempPremium</b></td></tr>");
		}
	}
	echo( "</table>" );
}

function PremiumPerCompanyAll($group, $d1, $d2)
{
	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
	connect_to();
	//ok, first lets get an array of companies
	$sql0 = "SELECT * FROM `companies` ORDER BY `Name`";
	$selectResult0 = mysql_query($sql0);
	while($row0 = mysql_fetch_array($selectResult0))
	{
		$tempPremium = 0;
		$company = $row0["Name"];
		//then lets search this office's logbook for policies written for that company during that time
		$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `Company` = '$company' AND `group` = '$group'";
		$selectResult1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($selectResult1))
		{
			$tempPremium = $tempPremium + $row1["Premium"];
		}
		//display the company name and the results, loop back to the next company
		if($tempPremium != 0)
		{
			echo( "<tr><td>$company</td><td>" );

			echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
			
			for($i = 0; $i <= $tempPremium; $i = $i + 100)
			{
				if($i < 10000)
				{
					echo( "<img src=\"images/black.jpg\" border=\"0\">" );
				}
				else 
				{
					echo( "<img src=\"images/break.jpg\" border=\"0\">" );
					$i = $i + 1000;
				}
			}

			echo( "<img src=\"images/blackr.jpg\" border=\"0\"> <b>$tempPremium</b></td></tr>");
		}
	}
	echo( "</table>" );
}

function averagePremiumPerCompanySingle($group, $d1, $d2, $office)
{
	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
	connect_to();
	//ok, first lets get an array of companies
	$sql0 = "SELECT * FROM `companies` ORDER BY `Name`";
	$selectResult0 = mysql_query($sql0);
	while($row0 = mysql_fetch_array($selectResult0))
	{
		$tempPremium = 0;
		$numPolicies = 0;
		$company = $row0["Name"];
		//then lets search this office's logbook for policies written for that company during that time
		$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `Company` = '$company' AND `office` = '$office' AND `group` = '$group'";
		$selectResult1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($selectResult1))
		{
			$numPolicies = $numPolicies + 1;
			$tempPremium = $tempPremium + $row1["Premium"];
		}
		if($numPolicies != 0)
		{
			$tempPremium = $tempPremium / $numPolicies;
		}
		//display the company name and the results, loop back to the next company
		if($tempPremium != 0)
		{
			echo( "<tr><td>$company</td><td>" );

			echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
			
			for($i = 0; $i <= $tempPremium; $i = $i + 100)
			{
				if($i < 10000)
				{
					echo( "<img src=\"images/black.jpg\" border=\"0\">" );
				}
				else 
				{
					echo( "<img src=\"images/break.jpg\" border=\"0\">" );
					$i = $i + 1000;
				}
			}

			$tempPremium = sprintf("%01.2f", $tempPremium);
			
			echo( "<img src=\"images/blackr.jpg\" border=\"0\"> <b>$tempPremium</b></td></tr>");
		}
	}
	echo( "</table>" );
}

function averagePremiumPerCompanyAll($group, $d1, $d2)
{
	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
	connect_to();
	//ok, first lets get an array of companies
	$sql0 = "SELECT * FROM `companies` ORDER BY `Name`";
	$selectResult0 = mysql_query($sql0);
	while($row0 = mysql_fetch_array($selectResult0))
	{
		$tempPremium = 0;
		$numPolicies = 0;
		$company = $row0["Name"];
		//then lets search this office's logbook for policies written for that company during that time
		$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `Company` = '$company' AND `group` = '$group'";
		$selectResult1 = mysql_query($sql1);
		while($row1 = mysql_fetch_array($selectResult1))
		{
			$numPolicies = $numPolicies + 1;
			$tempPremium = $tempPremium + $row1["Premium"];
		}
		if($numPolicies != 0)
		{
			$tempPremium = $tempPremium / $numPolicies;
		}
		//display the company name and the results, loop back to the next company
		if($tempPremium != 0)
		{
			echo( "<tr><td>$company</td><td>" );

			echo( "<img src=\"images/blackl.jpg\" border=\"0\">" );
			
			for($i = 0; $i <= $tempPremium; $i = $i + 100)
			{
				if($i < 10000)
				{
					echo( "<img src=\"images/black.jpg\" border=\"0\">" );
				}
				else 
				{
					echo( "<img src=\"images/break.jpg\" border=\"0\">" );
					$i = $i + 1000;
				}
			}

			$tempPremium = sprintf("%01.2f", $tempPremium);
			
			echo( "<img src=\"images/blackr.jpg\" border=\"0\"> <b>$tempPremium</b></td></tr>");
		}
	}
	echo( "</table>" );
}
?>
