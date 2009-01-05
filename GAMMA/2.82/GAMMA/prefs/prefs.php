<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 1)
{
  die("ADMIN TOO LOW");
}
include(getcwd().'/../includes/common.inc');
style("white");

echo( "<h1>Preferences</h1>" );
echo( "<p><a href = \"backup/backup_logbook.php\">Backup Logbook</a></p>" );
echo( "<p><a href = \"backup/backup_receipt.php\">Backup Receipt Book</a></p>" );
echo( "<p><a href = \"logbook_struct/logbook_struct.php\">Logbook Structure</a></p>" );
echo( "<p><a href = \"rss/rss.php\">RSS Feeds</a></p>" );
echo( "<p><a href = \"stats.php\">Statistics</a></p>" );
echo( "<p><a href = \"users/switch1.php\">Switch Office</a></p>" );
echo( "<p><a href = \"users/users_search.php\">User Accounts</a></p>" );
echo( "<p><a href = \"weather/weather.php\">Weather</a></p>" );
?>
