<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
  die("INVALID SESSION");
}
if($admin < 2)
{
	die( "Admin too low" );
}

connect_to();

$yearIn = $_POST["year"];

echo( "<h1>Setting Due Dates for ".$yearIn."</h1>" );

for($i = 1; $i <= 12; $i++)
{
	$varname_year = "year".$i;
	$varname_month = "month".$i;
	$varname_day = "day".$i;
	$varname_sent = "sent".$i;

	$temp_year = $_POST[$varname_year];
	$temp_month = $_POST[$varname_month];
	$temp_day = $_POST[$varname_day];
	$temp_sent = $_POST[$varname_sent];

	$temp_due = $temp_year."-".$temp_month."-".$temp_day;
	
	echo( $temp_due."<br>" );

	$sql1 = "UPDATE `franchise_bills` SET `due` = '$temp_due', `sent` = '$temp_sent' WHERE `month` = '$i' AND `year` = '$yearIn' AND `Group` = '$group'";
	$updateResult1 = mysql_query($sql1);
}
echo( "
<script>
location=\"franchisebill.php\";
</script> 
");
?>
