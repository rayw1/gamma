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
$recipIn = $_POST["recip"];

echo( "<b>Updating ".$recipIn."...</b><br>" );

connect_to();
$selectResult1 = mysql_query("SELECT `DisplayName`, `Database` FROM `statistics` WHERE `Group` = '$group' ORDER BY `DisplayName`");

connect_to();
while($row = mysql_fetch_array($selectResult1))
{
	echo( "Updates for the ".$row["Database"]." database<br>" );

	$database = $row["Database"];
	
	for($i = 1; $i <= 12; $i++)
	{
		$varName = $i."_".$row["Database"];
		$test = $_POST[$varName];
		
		if($test != "yes")
		{
			$test = "no";
		}		
		
		$sql2 = "SELECT `received` FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
		$selectResult2 = mysql_query($sql2);
		$tempRow = mysql_fetch_array($selectResult2);
				
		if($tempRow["received"] != "")
		{
			if($tempRow["received"] != $test)
			{
				echo( "Month ".$i." received value was: ".$tempRow["received"]." and should be: ".$test."<br>" );
				$sql3 = "UPDATE `franchise_bills` SET `received` = '$test' WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
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
