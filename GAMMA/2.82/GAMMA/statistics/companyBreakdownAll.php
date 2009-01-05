<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}

$company = $_GET["company"];

$year = substr($_GET["date1"], 0, 4);
$month = substr($_GET["date1"], 5, 2);
$day = substr($_GET["date1"], 8,2);

$timestamp = mktime(0,0,0,$month,$day,$year);
$Tdate = getdate($timestamp);
$todayWestern = $Tdate["month"]." ".$Tdate["year"];
		
$FirstofM = $_GET["date1"];
$LastofM = $_GET["date2"];

echo( "<h1>Breakdown for $company</h1>" );

//get list of dbs------------------------------------------------------------------
connect_to();
$sql0 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY 'DisplayName'";

$items = mysql_query($sql0);

if($items == 0)
{	
	log_error("Could not select from statistics: $sql0", "companyBreakdownAll.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not get list of databases");
}

$x = 0;
while($result = mysql_fetch_array($items))
{
	if($result["Database"] != "alttest")
	{
		$databases[$x] = $result["Database"];
		$x++;
	}
}
//-----------------------------------------------------------------------------------

echo("<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">");

//Start at the company and search the first database logbook for it
foreach($databases as $individualDatabase)
{
	$sql0 = "SELECT * FROM `statistics` WHERE `Database` = '$individualDatabase'";
	$items = mysql_query($sql0);
	$row = mysql_fetch_array($items);
	
	$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$FirstofM' AND `Date` <= '$LastofM' AND `Company` = '$company' AND `office` = '$individualDatabase' AND `group` = '$group'";
	$selectResult = mysql_query($sql);
	if(mysql_num_rows($selectResult) != 0)
	{
		$x = mysql_num_rows($selectResult);
		echo("<tr><td>".$row["DisplayName"].": </td>");
		echo( "<td><img src=\"images/blackl.jpg\" border=\"0\">" );
		
		for($i = 0; $i < $x; $i++)
		{
			if($i >= 100)
			{
				echo( "<img src = \"images/break.jpg\" border = \"0\">" );
				$i = $i+100;
			}
			else 
			{
				echo( "<img src = \"images/black.jpg\" border = \"0\">" );
			}
		}
		
		echo( "<img src=\"images/blackr.jpg\" border=\"0\"> $x</td></tr>" );
	}
}
//-----------------------------------------------------------------------------------

echo( "</table>" );
?>
