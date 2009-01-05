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

$monthIn = $_GET["month"];
$yearIn = $_GET["year"];
$recipIn = $_GET["recip"];
$lastYear = $yearIn - 1;
$nextYear = $yearIn +1;

echo( "<h1>".$recipIn." for ".$yearIn."</h1>" );

echo( "<h3>View this bill for: <a href=\"recipient1.php?year=".$lastYear."&month=".$monthIn."&recip=".$recipIn."\">".$lastYear."</a> or <a href=\"recipient1.php?year=".$nextYear."&month=".$monthIn."&recip=".$recipIn."\">".$nextYear."</a></h3>" );

echo( "<form action=\"recipient_update.php\" method=\"POST\">" );



echo( "<input type=\"hidden\" name=\"month\" value=\"".$monthIn."\">" );
echo( "<input type=\"hidden\" name=\"year\" value=\"".$yearIn."\">" );
echo( "<input type=\"hidden\" name=\"recip\" value=\"".$recipIn."\">" );




echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
$color = "#CCFFCC";

echo( "<tr><td><b>Office</b></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=01&recip=".$recipIn."\"><b>Jan</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=02&recip=".$recipIn."\"><b>Feb</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=03&recip=".$recipIn."\"><b>March</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=04&recip=".$recipIn."\"><b>April</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=05&recip=".$recipIn."\"><b>May</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=06&recip=".$recipIn."\"><b>June</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=07&recip=".$recipIn."\"><b>July</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=08&recip=".$recipIn."\"><b>Aug</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=09&recip=".$recipIn."\"><b>Sept</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=10&recip=".$recipIn."\"><b>Oct</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=11&recip=".$recipIn."\"><b>Nov</b></a></td>
<td><a href=\"recipient1.php?year=".$yearIn."&month=12&recip=".$recipIn."\"><b>Dec</b></a></td>
</tr>" );

connect_to();
$selectResult1 = mysql_query("SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY `OfficeNumber`");

while($row = mysql_fetch_array($selectResult1))
{
	$database = $row["Database"];
	if($database != "alttest")
	{
		connect_to();

		$sql2 = "SELECT `amount` FROM `franchise_bills` WHERE `office` = '$database' AND `month` = '$monthIn' AND `year` = '$yearIn' AND `reason` = '$recipIn'";
		$selectResult2 = mysql_query($sql2);
		$tempRow = mysql_fetch_array($selectResult2);
		$cost = $tempRow["amount"];
		$cost = sprintf("%01.2f", $cost);
		if($color == "white")
		{
			$color = "#CCFFCC";
		}
		else
		{
			$color = "white";
		}
		echo( "<tr style=\"background:" );
		echo( $color );
		echo( ";\"><td>".$row["OfficeNumber"]." - ".$row["DisplayName"]."</td>" );
		for($i = 1; $i <= 12; $i++)
		{
			if($i == $monthIn)
			{
				echo( "<td bgcolor=\"yellow\"><center>$<input class=\"blue\" name=\"amount_".$row["Database"]."\" size=\"6\" value=\"".$cost."\"></center></td>" );
			}
			else
			{
				//Sketcy code, keep an eye on it
				echo( "<td><center><input class=\"blue\" name=\"".$i."_".$row["Database"]."\" type=\"checkbox\" value=\"replicate\"" );
				$sql3 = "SELECT `amount` FROM `franchise_bills` WHERE `office` = '$database' AND `month` = '$i' AND `year` = '$yearIn' AND `reason` = '$recipIn'";
				$selectResult3 = mysql_query($sql3);
				$tempRow = mysql_fetch_array($selectResult3);
				$tempCost = $tempRow["amount"];
				$tempCost = sprintf("%01.2f", $tempCost);
				if($tempCost == $cost)
				{
					echo( " checked" );
				}
				echo( "></center></td>" );
				//-------------------------------
				
			}
		}
	}
}

echo( "</table>" );
echo( "A checkmark indicates the value for that month is the same as the value for this month.  Changing the value for this month will update the value for all checked months.<br>");
connect_to();
$sql4 = "SELECT * FROM `franchise_bills` WHERE `reason` = '$recipIn' AND `Group` = '$group'";
$selectResult4 = mysql_query($sql4);
$row2 = mysql_fetch_array($selectResult4);

$payable = $row2["payableTo"];
if($payable == "")
{
	$payable = "Alternatives Insurance Group";
}

echo( "Payable To: <input class=\"blue\" name=\"payableTo\" value=\"".$payable."\" size=\"36\"><br>" );
echo( "<br><input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form> ");
?>
