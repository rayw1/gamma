<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
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

$monthIn = mysql_real_escape_string($_POST["month"]);
$yearIn = mysql_real_escape_string($_POST["year"]);
$recipIn = mysql_real_escape_string($_POST["recip"]);
$payIn = mysql_real_escape_string($_POST["payableTo"]);

//echo( "<b>Updating ".$recipIn."...</b><br>" );

$selectResult1 = mysql_query("SELECT `DisplayName`, `Database` FROM `statistics` WHERE `Group` = '$group' ORDER BY `DisplayName`");

while($row = mysql_fetch_array($selectResult1)) 
{
	//echo( "Updates for the ".$row["Database"]." database<br>" );
	
	$varName = "amount_".$row["Database"];
	$cost = mysql_real_escape_string($_POST[$varName]);
	$database = $row["Database"];
	//echo( "Amount is ".$cost."<br>" );
	
	for($i = 1; $i <= 12; $i++)
	{		
		if($i != $monthIn)
		{
			$varName = $i."_".$row["Database"];
			$test = mysql_real_escape_string($_POST[$varName]);
			
			if( $test == "replicate" )
			{
				//echo( "Month ".$i." requires updating...<br>" );
				//check to see if a row exists already.  this determines if we UPDATE or INSERT
				$sql3 = "SELECT * FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
				$selectResult3 = mysql_query($sql3);
				
				$arows = mysql_numrows($selectResult3);
				
				if($arows == 0)
				{
					if($cost != 0)
					{
						//echo( "Month ".$i." doesnt exist, creating...<br>" );
						//TODO CREATE
						$sql4 = "INSERT INTO `franchise_bills` (`ID`, `office`, `month`, `year`, `due`, `reason`, `amount`, `payableTo`, `received`, `Group`) VALUES ('', '$database', '$i', '$yearIn', '0000-00-00', '$recipIn', '$cost', '$payIn', 'no', '$group')";
						$insertResult4 = mysql_query($sql4);
					}
					else 
					{
						//echo( "$0 amount.  Will not create row<br>" );
					}
				}
				else 
				{
					if($cost != 0)
					{
						//echo( "Month ".$i." exists, updating...<br>" );
						//TODO UPDATE
						$sql5 = "UPDATE `franchise_bills` SET `amount` = '$cost', `payableTo` = '$payIn' WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
						$updateResult5 = mysql_query($sql5);
					}
					else 
					{
						//echo( "$0 amount, deleting row<br>" );
						//TODO DELETE
						$sql8 = "DELETE FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
						$deleteResult8 = mysql_query($sql8);
					}
				}
			}
			else 
			{
				//echo( "Month ".$i." indicated that it did not need updating<br>" );
				//TODO NOTHING
			}
		}
		else 
		{
			//this was the text field month, did we enter a new value?
			//echo( "Month ".$i." was freetext field...<br>" );
			$sql2 = "SELECT * FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
			$selectResult2 = mysql_query($sql2);
			
			$arows = mysql_numrows($selectResult2);
			
			if($arows == 0)
			{
				if($cost != 0)
				{
					//echo( "Month ".$i." doesnt exist, creating... <br>" );
					//TODO CREATE
					$sql7 = "INSERT INTO `franchise_bills` (`ID`, `office`, `month`, `year`, `due`, `reason`, `amount`, `payableTo`, `received`, `Group`) VALUES ('', '$database', '$i', '$yearIn', '0000-00-00', '$recipIn', '$cost', '$payIn', 'no', '$group')";
					$insertResult7 = mysql_query($sql7);
				}
				else 
				{
					//echo( "$0 amount.  Will not create row for month ".$i."<br>" );
					//TODO NOTHING
				}
			}
			else 
			{
				//yes, it exists, but is the value the same?
				$row2 = mysql_fetch_array($selectResult2);
				if($row2["amount"] != $cost)
				{
					//the amounts are not the same, update
					if($cost != 0)
					{
						//echo( "Month ".$i." exists, updating...<br>" );
						//TODO UPDATE
						$sql6 = "UPDATE `franchise_bills` SET `amount` = '$cost', `payableTo` = '$payIn' WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
						$updateResult6 = mysql_query($sql6);
					}
					else 
					{
						//echo( "$0 amount, deleting row for month ".$i."<br>" );
						//TODO DELETE
						$sql9 = "DELETE FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$database' AND `reason` = '$recipIn'";
						$deleteResult9 = mysql_query($sql9);
					}
				}
				else 
				{
					//echo( "Data on record is the same as data being pushed<br>" );
					//TODO NOTHING
				}
			}
		}
	}
}


//Run a cleanup script that removes anything with a zero balance... This WILL delete the key row
$sql10 = "DELETE FROM `franchise_bills` WHERE `amount` = '0'";
$deleteResult10 = mysql_query($sql10);

//Run a cleanup script that fixes any 0000-00-00 due dates
$sql11 = "SELECT * FROM `franchise_bills` WHERE `due` = '0000-00-00'";
$selectResult11 = mysql_query($sql11);

while($row3 = mysql_fetch_array($selectResult11))
{
	$id = $row3["ID"];
	$month = $row3["month"];
	$year = $row3["year"];
	
	$sql12 = "SELECT `due` FROM `franchise_bills` WHERE `month` = '$month' AND `year` = '$year' AND `due` <> '0000-00-00' AND `Group` = '$group'";
	$selectResult12 = mysql_query($sql12);
	
	$row4 = mysql_fetch_array($selectResult12);
	
	$due = $row4["due"];
	
	$sql13 = "UPDATE `franchise_bills` SET `due` = '$due' WHERE `ID` = '$id'";
	$updateResult13 = mysql_query($sql13);
}

//Go back to a different page


echo( "
<script>
location=\"franchisebill.php\";
</script> 
");

?>
