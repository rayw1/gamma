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

$yearIn = $_GET["year"];
$officeIn = $_GET["office"];
$lastYear = $yearIn - 1;
$nextYear = $yearIn +1;

connect_to();

$sql0 = "SELECT `DisplayName` FROM `statistics` WHERE `Database` = '$officeIn'";
$selectResult0 = mysql_query($sql0);

$tempRow = mysql_fetch_array($selectResult0);

echo( "<h1>".$tempRow["DisplayName"]." for ".$yearIn."</h1>" );
echo( "<h3>View this in <a href=\"officePayments1.php?office=".$officeIn."&year=".$lastYear."\">".$lastYear."</a> or <a href=\"officePayments1.php?office=".$officeIn."&year=".$nextYear."\">".$nextYear."</a></h3>" );

echo( "<form action=\"officePayments2.php\" method=\"POST\">" );

echo( "<input type=\"hidden\" name=\"year\" value=\"".$yearIn."\">" );
echo( "<input type=\"hidden\" name=\"office\" value=\"".$officeIn."\">" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
$color = "#CCFFCC";

echo( "<tr><td><b>Recipient</b></td>
<td><b>Jan</b></a></td>
<td><b>Feb</b></a></td>
<td><b>March</b></a></td>
<td><b>April</b></a></td>
<td><b>May</b></a></td>
<td><b>June</b></a></td>
<td><b>July</b></a></td>
<td><b>Aug</b></a></td>
<td><b>Sept</b></a></td>
<td><b>Oct</b></a></td>
<td><b>Nov</b></a></td>
<td><b>Dec</b></a></td>
</tr>" );


$selectResult1 = mysql_query("SELECT DISTINCT `reason` FROM `franchise_bills` WHERE `Group` = '$group'");

while($row = mysql_fetch_array($selectResult1))
{
	$recipient = $row["reason"];

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
	echo( ";\"><td>".$recipient."</td>" );
	for($i = 1; $i <= 12; $i++)
	{
		$sql3 = "SELECT `received` FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `office` = '$officeIn' AND `reason` = '$recipient'";
		$selectResult3 = mysql_query($sql3);
		$checkRow = mysql_fetch_array($selectResult3);
		$checkRowVal = $checkRow["received"];

		if($checkRowVal != "")
		{
			//There is a yes or no value for received
			echo( "<td><center><input class=\"blue\" name=\"".$i."_".despace($row["reason"])."\" type=\"checkbox\" value=\"yes\"" );

			if($checkRowVal == 'yes')
			{
				echo( " checked" );
			}
			echo( "></center></td>" );
		}
		else
		{
			//There is no entry, so there is no point in asking for a checkmark
			echo( "<td></td>" );
		}

	}
}

echo( "</table>" );
echo( "A checkmark indicates the payment has been received.  No checkbox indicates that the item was never billed.<br>");
echo( "<br><input type=\"Button\" value=\"Update\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form> ");
?>
