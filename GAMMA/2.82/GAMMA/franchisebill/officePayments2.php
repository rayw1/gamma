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
if($admin < 3)
{
	die( "Admin too low" );
}

$yearIn = $_POST["year"];
$officeIn = $_POST["office"];

echo( "<b>Updating ".$officeIn."...</b><br>" );

connect_to();
$selectResult1 = mysql_query("SELECT DISTINCT `reason` FROM `franchise_bills` WHERE `Group` = '$group'");

while($row = mysql_fetch_array($selectResult1))
{
	echo( "Updates for ".$row["reason"]."<br>" );

	$reason = $row["reason"];
	
	for($i = 1; $i <= 12; $i++)
	{
		$varName = $i."_".despace($row["reason"]);
		$test = $_POST[$varName];
		//echo( "Value for ".$row["reason"]." position ".$i." is ".$test."<br>" );
		
		if($test != "yes")
		{
			$test = "no";
		}		
		
		$sql2 = "SELECT * FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$officeIn' AND `reason` = '$reason'";
		$selectResult2 = mysql_query($sql2);
		$tempRow = mysql_fetch_array($selectResult2);
				
		if($tempRow["received"] != "")
		{
			if($tempRow["received"] != $test)
			{
				echo( "Month ".$i." received value was: ".$tempRow["received"]." and should be: ".$test."<br>" );
				$sql3 = "UPDATE `franchise_bills` SET `received` = '$test' WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$officeIn' AND `reason` = '$reason'";
				$updateResult3 = mysql_query($sql3);
			}
		}
		
	}
}

//Go back to a different page


echo( "
<script>
location=\"franchisebill.php\";
</script> 
");


?>
