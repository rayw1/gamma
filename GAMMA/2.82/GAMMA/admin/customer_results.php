<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
style("white");
session_start();
$valid = $_SESSION["validsession"];
$dbase = $_SESSION["office"];
$admin = $_SESSION["admin"];
$group = mysql_real_escape_string($_SESSION["group"]);
if($valid != 1)
{
	die("INVALID SESSION");
}

echo( "<h1>Results</h1>" );

$lname = mysql_real_escape_string($_POST["lname"]);

connect_to();
$sql0 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY 'DisplayName'";
$items0 = mysql_query($sql0);
if($items0 == 0)
{
	log_error("Statistic Select Failure: $sql0", "customer_results.php", $_SESSION["username"], $_SESSION["group"]);
	die("Couldnt get list of databases");
}

$color = "#CCFFCCC";
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"75%\">" );
echo( "<th>First<th>Last<th>Office" );
while($result0 = mysql_fetch_array($items0))
{
	if($result0["Database"] != "alttest")
	{
		$database = $result0["Database"];
		$sql1 = "SELECT * FROM `logbook` WHERE `LastName` = \"$lname\"";

		$items1 = mysql_query($sql1);

		while($result1 = mysql_fetch_array($items1))
		{
			if($color == "white")
			{
				$color = "#CCFFCC";
			}
			else
			{
				$color = "white";
			}

			if($dbase == $database || $admin > 2)
			{
				echo( "<tr style=\"background:".$color.";\">" );
				echo( "<td>" );
				echo( $result1["FirstName"]."</td><td>".$result1["LastName"]."</td><td>".$result0["DisplayName"]."</td></tr>" );
			}
			else
			{
				echo( "<tr style=\"background:".$color.";\">" );
				echo( "<td>".$result1["FirstName"]."</td><td>".$result1["LastName"]."</td><td>".$result0["DisplayName"]."</td></tr>" );
			}
		}
	}
}
echo("</table>" );
?>
