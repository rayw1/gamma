<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');

style("white");
connect_to();

echo( "<h1>RSS Feed Selection</h1>" );

$sql0 = "SELECT `RSS` FROM `statistics` WHERE `Database` = '$office'";
$selectResult0 = mysql_query($sql0);
$resultRow0 = mysql_fetch_array($selectResult0);
$rss_xml = $resultRow0["RSS"];

$i = 0;
//load our feeds into arrays
$rss_feeds = return_xml_array($rss_xml, "feed");
foreach ($rss_feeds as $single_feed)
{
	$host[$i] = return_xml($single_feed, "host");
	$location[$i] = return_xml($single_feed, "location");
	$i++;
}

//load our list of feeds from an actual xml file, and give us a checkbox list of feeds.
//this list will submit to another page which will generate the xml data to be stored in the database

$myFile = "feeds.xml";
$fh = fopen($myFile, 'r');
$readTo = filesize($myFile);
$xmlFeeds = fread($fh, $readTo);
fclose($fh);

$masterList = return_xml_array($xmlFeeds, "feed");
$masterNumber = 0;
echo( "<form action=\"rss_update.php\" method=\"post\">" );
foreach ($masterList as $masterEntry)
{
	//pull our data out
	$masterName = return_xml($masterEntry, "name");
	$masterHost = return_xml($masterEntry, "host");
	$masterLocation = return_xml($masterEntry, "location");
	//display our checkbox
	echo( "<input type=\"hidden\" name=\"host$masterNumber\" value=\"$masterHost\">" );
	echo( "<input type=\"hidden\" name=\"location$masterNumber\" value=\"$masterLocation\">" );
	echo( "<input type=\"checkbox\" value=\"checked\" name=\"name$masterNumber\"" );
	//check to see if this entry is already being used for this office
	for($a = 0; $a < $i; $a++)
	{
		if($host[$a] == $masterHost && $location[$a] == $masterLocation)
		{
			echo( " checked");
		}
	}
	echo( ">$masterName<br>");
	$masterNumber++;
}
$masterNumber--;
echo( "<input type=\"hidden\" name=\"masterNumber\" value=\"$masterNumber\">" );
echo( "<input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
?>
