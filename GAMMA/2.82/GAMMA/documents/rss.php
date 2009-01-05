<?php
//GAMMA V2.7 CERTIFIED
session_start();
$dbase = $_SESSION["office"];
include(getcwd().'/../includes/rss.inc');
include(getcwd().'/../includes/common.inc');

connect_to();

//News
$sql5 = "SELECT `RSS` FROM `statistics` WHERE `Database` = '$dbase'";
$selectResult5 = mysql_query($sql5);
$resultRow5 = mysql_fetch_array($selectResult5);
$rss_xml = $resultRow5["RSS"];

$rss_feeds = return_xml_array($rss_xml, "feed");
$feed = new GAMMA_RSS();
foreach ($rss_feeds as $single_feed)
{
	$rss_host = return_xml($single_feed, "host");
	$rss_location = return_xml($single_feed, "location");
	$feed->fetch($rss_host, $rss_location);
	$feed->display("","<br>");
}
?>
