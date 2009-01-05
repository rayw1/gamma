<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$valid = $_SESSION["validsession"];
$dbase = $_SESSION["office"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

echo( "<h1>Results</h1>" );

$lname = mysql_real_escape_string($_POST["lname"]);
$fname = mysql_real_escape_string($_POST["fname"]);

$sql0 = "SELECT * FROM `customer_general` WHERE `Group` = '$group' AND `Last_Name` LIKE '$lname%' AND `First_Name` LIKE '$fname%' ORDER BY `Office`";
$items0 = mysql_query($sql0);
if($items0 == 0)
{
	log_error("Customer List Select Failure: $sql0", "customer_results.php", $_SESSION["username"], $_SESSION["group"]);
	die("Couldnt get list of databases");
}

$color = "#CCFFCCC";
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"75%\">" );
echo( "<tr><td><b>First</b></td><td><b>Last</b></td><td><b>Office</b></td></tr>" );
while($result0 = mysql_fetch_array($items0))
{
		$sql1 = "SELECT * FROM `statistics` WHERE `Database` = '".$result0["Office"]."'";
		$selectResult1 = mysql_query($sql1);
		$row2 = mysql_fetch_array($selectResult1);

		if($color == "white")
		{
			$color = "#CCFFCC";
		}
		else
		{
			$color = "white";
		}

		if($admin >= 3 OR $dbase == $result0["Office"])
		{
			echo( "<tr style=\"background:" );
			echo( $color );
			echo( ";\">
			<td><a href = \"customer_profile.php?id=".$result0["ID"]."&dbase=".$result0["Office"]."\">".$result0["First_Name"]."</a></td>
			<td><a href = \"customer_profile.php?id=".$result0["ID"]."&dbase=".$result0["Office"]."\">".$result0["Last_Name"]."</a></td>
			<td><a href = \"customer_profile.php?id=".$result0["ID"]."&dbase=".$result0["Office"]."\">".$row2["DisplayName"]."</a></td>
			</tr>" );
			echo( "</a>" );
		}
		else
		{
			echo( "<tr style=\"background:" );
			echo( $color );
			echo( ";\"><td>".$result0["First_Name"]."</td><td>".$result0["Last_Name"]."</td><td>".$row2["DisplayName"]."</td></tr>" );
		}
}
echo("</table>" );
?>
