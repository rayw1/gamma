<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$yPass = $_GET["yPass"];
if($yPass == "")
{
	$yPass = $_POST["year"];
}

$mPass = $_GET["mPass"];
if($mPass == "")
{
	$mPass = $_POST["month"];
}

$date1 = $yPass;
$date1 .= "-";
$date1 .= $mPass;
$date1 .= "-01";

$date2 = $yPass;
$date2 .= "-";
$date2 .= $mPass;
$date2 .= "-";
$date2 .= "31";

if($date1 == "--01")
{
	$date1 = date("Y");
	$yPass = date("Y");
	$date1 .= "-";
	$date1 .= date("m");
	$mPass = date("m");
	$date1 .= "-01";
}
if($date2 == "--31")
{
	$date2 = date("Y");
	$date2 .= "-";
	$date2 .= date("m");
	$date2 .= "-31";
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `logbook_struct` WHERE `office` = '$dbase' AND `group` = '$group'";

echo( "<html>" );

echo( "<img src=\"../images/logbook.jpg\" border=\"0\"><br>" );
echo( "Results for dates from " );
$day = substr($date1, 8, 2);
$month = substr($date1, 5, 2);
$year = substr($date1, 0, 4);
echo( $month."-".$day."-".$year );
echo( " to " );
$day = substr($date2, 8, 2);
$month = substr($date2, 5, 2);
$year = substr($date2, 0, 4);
echo( $month."-".$day."-".$year );
echo( "<br>" );

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Logbook Structure Select Failure: $sql", "logbook_search.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain logbook structure");
}

echo( "<form action=\"logbook_update_commission.php\" method=\"post\">" );
echo( "<input type=\"hidden\" name=\"date1\" value=\"".$date1."\">" );
echo( "<input type=\"hidden\" name=\"date2\" value=\"".$date2."\">" );
echo( "<input type=\"hidden\" name=\"yPass\" value=\"".$yPass."\">" );
echo( "<input type=\"hidden\" name=\"mPass\" value=\"".$mPass."\">" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );

//Get all the fieldnames, put them into an array
$n = 0;
$row = mysql_fetch_array($itemList);
for($i = 0; $i < mysql_num_fields($itemList); $i++)
{
	if($row[$i] != "N")
	{
		$fieldname[$n] = mysql_field_name($itemList, $i);
		$n++;
	}
}

$n--;

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\"><tr>" );
for($a = 0; $a < $n; $a++)
{
	if($fieldname[$a] != "ID" && $fieldname[$a] != "office" && $fieldname[$a] != "group")
	{
		echo( "<td><b>" );
		echo(replace_chars($fieldname[$a]));
		echo( "</b></td>" );
	}
}
echo( "</tr>" );

$color = "#CCFFCC";
$sql2 = "SELECT * FROM `logbook` WHERE `Date` >= '$date1' AND `Date` <= '$date2' AND `office` = '$dbase' AND `group` = '$group' ORDER BY `Date`";
$selectResult2 = mysql_query($sql2);

$rowNumber = 0;

while($row = mysql_fetch_array($selectResult2))
{
	$rowNumber++;
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
	echo( ";\">" );

	for($a = 0; $a < $n; $a++)
	{
		if($fieldname[$a] == "Number")
		{
			$rowID = $row[$fieldname[$a]];
			echo( "<td><a href = \"logbook_edit.php?lid=$rowID&yPass=".$yPass."&mPass=".$mPass."\">" );
			echo( "$rowNumber");
			echo( "</a></td>" );
		}
		elseif($fieldname[$a] == "Date")
		{
			$day = substr($row[$fieldname[$a]], 8, 2);
			$month = substr($row[$fieldname[$a]], 5, 2);
			$year = substr($row[$fieldname[$a]], 0, 4);
			echo( "<td>$month-$day-$year</td>");
		}
		elseif($fieldname[$a] == "Commission_Paid" && $admin >= 2)
		{
			echo( "<td><input type=\"checkbox\" name=\"commission".$rowID."\" value=\"yes\" " );
			if($row[$fieldname[$a]] == "yes")
			{
				echo( "checked" );
			}
			echo( "></td>" );
		}
		elseif($fieldname[$a] != "ID" && $fieldname[$a] != "office" && $fieldname[$a] != "group")
		{
			echo( "<td>" );
			echo($row[$fieldname[$a]]);
			echo( "</td>" );
		}
	}
	echo( "</tr>");
}

echo( "</table>" );
if( $admin >= 2)
{
	echo ("<input type=\"Button\" value=\"Update Commissions\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">" );
}

echo( "</form>" );
echo( "<br><a href = \"logbook.php?yPass=".$yPass."&mPass=".$mPass."\">New Entry</a><br>
" );

//==================================
//=       Broker Fee Code          =
//==================================
echo( "<p><a href = \"fees/fees.php\">Determine Broker Gross Payroll</a></p>" );

echo( "
<form action=\"logbook_search.php\" method=\"POST\">
<table border=\"1\">
  <tr>
    <td>&nbsp;</td>
    <td>Month</td>
    <td>Year</td>
  </tr>
  <tr>
    <td>Date</td>
    <td>"); 
month_drop("", "");
echo( "</td><td>" );
year_drop("", "");
echo( "</td></tr>  
</table>
<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[1].submit()\"> 
</form>
<br>" );
?>
