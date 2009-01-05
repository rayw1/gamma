<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$searchBy = $_GET["searchBy"];
$doSearch = $_POST["doSearch"];

if($searchBy == "")
{
	$searchBy = $_POST["searchBy"];
	if($searchBy == "")
	{
		$searchBy = "pending";
	}
}

if($searchBy == "pending")
{
	$sql0 = "SELECT * FROM `quotes` WHERE (`office` = '$office' OR `office` = 'alttest') AND `group` = '$group' AND `completed` = 'no'";
}
elseif($searchBy == "lname" && $doSearch == "true")
{
	$sql0 = "SELECT * FROM `quotes` WHERE (`office` = '$office' OR `office` = 'alttest') AND `group` = '$group' AND `lastName` = '".$_POST["lname"]."'";
}
elseif($searchBy == "date" && $doSearch == "true")
{
	$date1 = $_POST["year1"];
	$date1 .= "-";
	$date1 .= $_POST["month1"];
	$date1 .= "-";
	$date1 .= $_POST["day1"];
	$date1 .= " 00:00:00";

	$date2 = $_POST["year2"];
	$date2 .= "-";
	$date2 .= $_POST["month2"];
	$date2 .= "-";
	$date2 .= $_POST["day2"];
	$date2 .= " 23:59:59";
	$sql0 = "SELECT * FROM `quotes` WHERE (`office` = '$office' OR `office` = 'alttest') AND `group` = '$group' AND `originTime` >= '$date1' AND `originTime` <= '$date2'";
}

$selectResult0 = mysql_query($sql0);

if($searchBy == "pending")
{
	echo( "<img src=\"../images/pendingquotes.jpg\" border=\"0\"><br><br>" );
}
else
{
	echo( "<img src=\"../images/quotes.jpg\" border=\"0\"><br><br>");
}

echo( "<a href=\"quotesheet.php\"><img src=\"../images/add.gif\" border=\"0\"></a><br>");

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">");
echo( "<tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Address</b></td><td><b>Vehicle 1 Year</b></td><td><b>Vehicle 1 Make</b></td><td><b>Vehicle 1 Model</b></td><td><b>Created</b></td></tr>");

$color = "#CCFFCC";
if($selectResult0 > 0)
{
	while($row = mysql_fetch_array($selectResult0))
	{
		if($color == "white")
		{
			$color = "#CCFFCC";
		}
		else
		{
			$color = "white";
		}

		$month = substr($row["originTime"], 5, 2);
		$day = substr($row["originTime"], 8, 2);
		$year = substr($row["originTime"], 0, 4);

		echo( "<tr style=\"background:" );
		echo( $color );
		echo( ";\">" );
		echo( "
	<td><a href=\"quotesheet_details.php?id=".$row["ID"]."\">".$row["firstName"]."</a></td>
	<td><a href=\"quotesheet_details.php?id=".$row["ID"]."\">".$row["lastName"]."</a></td>
	<td><a href=\"quotesheet_details.php?id=".$row["ID"]."\">".$row["address"]."</a></td>
	<td><a href=\"quotesheet_details.php?id=".$row["ID"]."\">".$row["vehicle1Year"]."</a></td>
	<td><a href=\"quotesheet_details.php?id=".$row["ID"]."\">".$row["vehicle1Make"]."</a></td>
	<td><a href=\"quotesheet_details.php?id=".$row["ID"]."\">".$row["vehicle1Model"]."</td>
	<td>$month-$day-$year</a></td></tr>");
		echo( "</a>");
	}
}
else
{
	echo( "<td colspan=\"7\">No Quotes</td>" );
}
echo( "</table>" );

echo( "<br>Search Options: ");
if($searchBy != "pending")
{
	echo( "<a href=\"quotesheet_search.php?searchBy=pending\">Pending Quotes</a> / ");
}
else 
{
	echo( "Pending Quotes / ");
}
if($searchBy != "lname")
{
	echo( "<a href=\"quotesheet_search.php?searchBy=lname\">Last Name</a> / ");
}
else 
{
	echo( "Last Name / ");
}
if($searchBy != "date")
{
	echo( "<a href=\"quotesheet_search.php?searchBy=date\">Date</a>");
}
else
{
	echo("Date");
}


if($searchBy == "lname")
{
	echo("
	<form name=\"quoteSearchPending\" method=\"post\" action=\"quotesheet_search.php\">
	<input type=\"hidden\" name=\"doSearch\" value=\"true\">
	<input type=\"hidden\" name=\"searchBy\" value=\"lname\">
	<input class=\"blue\" name=\"lname\">
	<input type=\"Button\" value=\"Search By Name\" onclick=\"javascript:this.value='Submit';this.disabled=1;document.forms[0].submit()\">
	</form>");
}
elseif($searchBy == "date")
{
	echo("
	<form name=\"quoteSearchPending\" method=\"post\" action=\"quotesheet_search.php\">
<input type=\"hidden\" name=\"doSearch\" value=\"true\">
	<input type=\"hidden\" name=\"searchBy\" value=\"date\">
<table border=\"0\" cellspacing=\"4\" cellpadding=\"0\">
  <tr>
    <td>&nbsp;</td>
    <td>Month</td>
    <td>Day</td>
    <td>Year</td>
  </tr>
  <tr>
    <td>Starting Date:</td>
    <td>" ); 
	month_drop(date("m"), 1);
echo( "</td><td>" );
	day_drop(date("d"), 1);
echo( "</td><td>" );
	year_drop(date("Y"), 1);
echo( "
</td></tr>
  <tr>
    <td>Ending Date:</td>
    <td>" );
    month_drop(date("m"), 2);
echo("    
    </td>
    <td>" );
    day_drop(date("d"), 2);
echo( "</td>
    <td>" );
    year_drop(date("Y"), 2);
    echo( "</td>
  </tr>
</table>
<input type=\"Button\" value=\"Search By Date\" onclick=\"javascript:this.value='Submit';this.disabled=1;document.forms[0].submit()\">
</form>");
}

?>
