<?php
//GAMMA V2.7 CERTIFIED
session_start();
if($_SESSION["validsession"] != 1)
{
	die( "Invalid Session" );
}
$admin = $_SESSION["admin"];
$uname = $_SESSION["username"];
$group = $_SESSION["group"];
$office = $_SESSION["office"];

if($admin == "" || $uname == "" || $group == "" || $office == "")
{
	die( "
	<script>
	location=\"logoff.php\";
	</script> 
	");
}

include(getcwd().'/includes/common.inc');
echo( "
<head>
<STYLE type=\"text/css\"> 
	P{color: white; font-family: \"Lucida Sans Unicode\", \"Lucida Grande\", sans-serif; font-size: .9em;}
  	A{text-decoration: none; color:white; font-family: \"Lucida Sans Unicode\", \"Lucida Grande\", sans-serif; font-size: .9em;}
  	A:visited, A:plain, A:active{text-decoration: none; color:white; font-family: \"Lucida Sans Unicode\", \"Lucida Grande\", sans-serif; font-size: .9em;} 
  	A:hover{text-decoration: none; color: red; font-family: \"Lucida Sans Unicode\", \"Lucida Grande\", sans-serif;} body{background-color: white; font-size: .9em;}
  		input.blue{background-color: #ffffff; border-color:#a7a6aa; border-style:solid; border-width:thin;}
		input.blue:focus{background-color: #ebf5ff; border-color:#002276; border-style:solid; border-width:thin;}
		</STYLE>
<body background=\"images/dashback.jpg\">" );
echo( " <META HTTP-EQUIV=\"Refresh\" CONTENT=\"60; URL=dashboardl.php\"></head>" );
echo( "<font size = 3>" );
echo( "<center>" );
connect_to();
$sqln1 = "SELECT `DisplayName` FROM `statistics` WHERE `Database` = '$office'";
$SelectResultn1 = mysql_query($sqln1);
$rown1 = mysql_fetch_array($SelectResultn1);
$dname = $rown1["DisplayName"];

echo( "<p><b>$dname</b></p>");
echo( "<a href = \"dashboardr.php\" target = \"right\"><img src = \"images/gamma_Tiny.gif\" border = \"0\"></a><br><br>" );

$sql0 = "SELECT * FROM `functions` WHERE `Group` = '$group' OR `Group` = 'All' AND `Admin` <= '$admin' ORDER BY `Name`";
$selectResult0 = mysql_query($sql0);

while($row = mysql_fetch_array($selectResult0))
{
	if($row["Name"] == "Calendar")
	{
		$hour = date("H")-1;
		$todayStart = date("Y")."-".date("m")."-".date("d")." ".$hour.":".date("i").":00";
		$todayEnd = date("Y")."-".date("m")."-".date("d")." 23:59:59";
		$todayStart = $todayStart;
		$todayEnd = $todayEnd;
		$sql1 = "SELECT * FROM `calendar` WHERE `date_time` >= '$todayStart' AND `date_time` <= '$todayEnd' AND `visibility` LIKE '%$uname%' AND `Group` = '$group'";
		$selectResult1 = mysql_query($sql1);
		$numOfResults = mysql_numrows($selectResult1);

		echo( "<a href = \"calendar/calendar.php?month=".date("m")."&day=".date("d")."&year=".date("Y")."&hour=".date("H")."&min=".date("i")."\" target = \"right\">Calendar (<b>".$numOfResults."</b>)</a><br>" );
	}
	elseif($row["Name"] == "Quoting")
	{
		$sql1 = "SELECT * FROM `quotes` WHERE `completed` = 'no' AND (`office` = '$office' OR `office` = 'alttest')";
		$selectResult1 = mysql_query($sql1);
		$numOfResults = mysql_numrows($selectResult1);

		echo( $row["Link"] );
		echo( $row["Name"] );
		echo( " (<b>".$numOfResults."</b>)</a><br>" );
	}
	elseif($row["Name"] == "ErrorLog")
	{
		$sql1 = "SELECT * FROM `error_log` WHERE `status` = 'open'";
		$selectResult1 = mysql_query($sql1);
		$numOfResults = mysql_numrows($selectResult1);
		
		echo( "<a href=\"errorlog/error_search.php\" target=\"right\">Errors (<b>$numOfResults</b>)</a><br>");
	}
	else 
	{
		echo( $row["Link"].$row["Name"]."</a><br>" );
	}
}

echo( "<a href=\"logoff.php\">Log Off</a></center>" );

//==================================
//=          Backup Code           =
//==================================

if(!file_exists("backup.dat"))
{
	$myFile = "backup.dat";
	$fh = fopen($myFile, 'w');
	fputs($fh, date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y"))));
	fclose($fh);
}

$myFile = "backup.dat";
$fh = fopen($myFile, 'r');
$lastBackupDate = fread($fh, 8);
fclose($fh);

$today = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));

if($lastBackupDate == "")
{
	$myFile = "backup.dat";
	$fh = fopen($myFile, 'w');
	fputs($fh, date("Ymd",mktime(0,0,0,date("m"),date("d")-1,date("Y"))));
	fclose($fh);
}
elseif ($lastBackupDate < $today)
{
	echo( "<center><font color=\"red\"><b>Backing<br>Up</b></font></center><br>" );

	$myFile = "backup.dat";
	$fh = fopen($myFile, 'w');
	fputs($fh, date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y"))));
	fclose($fh);

	include('phpBackup/backup.php');
	backup();
}
?>
