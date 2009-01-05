<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}
include(getcwd().'/../includes/common.inc');
style("white");

echo( "<img src=\"../images/administrativetasks.jpg\" border=\"0\"><br>" );

if($admin >= 99)
{
	echo( "<p><a href = \"create1.php\">Create office</a></p>" );
	echo( "<p><a href = \"functions1.php\">Dashboard Functions</a></p>" );	
}

echo( "<p><a href = \"backup/backup_acord.php\">Backup Acord Documents</a></p>" );
echo( "<p><a href = \"backup/backup_calendar.php\">Backup Calendar</a></p>" );
echo( "<p><a href = \"backup/backup_companies.php\">Backup Companies</a></p>" );
echo( "<p><a href = \"backup/backup_companyAddress.php\">Backup Company Addresses</a></p>" );
echo( "<p><a href = \"backup/backup_companyNumbers.php\">Backup Company Numbers</a></p>" );
echo( "<p><a href = \"backup/backup_farmers.php\">Backup Farmers</a></p>" );
echo( "<p><a href = \"backup/backup_keychain.php\">Backup Keychain</a></p>" );
echo( "<p><a href = \"backup/backup_leinholders.php\">Backup Leinholders</a></p>" );
echo( "<p><a href = \"backup/backup_mortgagee.php\">Backup Mortgagee</a></p>" );
echo( "<p><a href = \"messages/messages1.php\">Dashboard Messages</a></p>" );
echo( "<p><a href = \"switch1.php\">Switch office (This session only)</a></p>" );
?>
