<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 1)
{
	die( "Admin too low" );
}

include(getcwd().'/../../includes/common.inc');

style("white");
connect_to();
$sql0 = "SELECT * FROM `statistics` WHERE `Database` = '$office'";
$selectResult0 = mysql_query($sql0);
$resultRow0 = mysql_fetch_array($selectResult0);
$icao = $resultRow0["ICAO"];

$sql1 = "SELECT * FROM `ICAO` WHERE `ICAO` = '$icao'";
$selectResult1 = mysql_query($sql1);
$resultRow1 = mysql_fetch_array($selectResult1);
$location = $resultRow1["Location"];
$country = $resultRow1["Country"];

echo( "<h1>Weather Display Options</h1>");

echo( "Your current weather station is: <b>$location</b><br>");

echo( "<form action=\"weather.php\" method=\"post\">");
echo( "<SELECT name=\"Country\" onChange=\"this.form.submit();\">");

$sql2 = "SELECT DISTINCT `Country` FROM `ICAO` ORDER BY `Country` ASC";
$selectResult2 = mysql_query($sql2);
while($resultRow2 = mysql_fetch_array($selectResult2))
{
	echo( "<option value=\"".$resultRow2["Country"]."\"" );
	
	if($resultRow2["Country"] == $_POST["Country"])
	{
		echo( " selected" );
	}
	
	echo( ">".$resultRow2["Country"]."</option>" );
}

echo( "</select>" );

if(isset($_POST["Country"]))
{
	$sql3 = "SELECT DISTINCT `State` FROM `ICAO` WHERE `Country` = '".$_POST["Country"]."' ORDER BY `State` ASC";
	$selectResult3 = mysql_query($sql3);
	if(mysql_num_rows($selectResult3) > 1)
	{
		echo( "<SELECT name=\"State\" onChange=\"this.form.submit();\">");
		while($resultRow3 = mysql_fetch_array($selectResult3))
		{
			echo( "<option value=\"".$resultRow3["State"]."\"" );

			if($resultRow3["State"] == $_POST["State"])
			{
				echo( " selected" );
			}
			elseif($_POST["State"] == "" && $resultRow3["State"] == $country)
			{
				echo( " selected" );
			}

			echo( ">".$resultRow3["State"]."</option>" );
		}
		echo( "</select>" );
	}

}

if(isset($_POST["State"]))
{
	$sql4 = "SELECT DISTINCT `Location` FROM `ICAO` WHERE `Country` = '".$_POST["Country"]."' AND `State` = '".$_POST["State"]."' ORDER BY `Location` ASC";
	$selectResult4 = mysql_query($sql4);
	if(mysql_num_rows($selectResult4) > 1)
	{
		echo( "<SELECT name=\"Location\" onChange=\"this.form.submit();\">");
		echo( "<option value=\"\"></option>" );
		while($resultRow4 = mysql_fetch_array($selectResult4))
		{
			echo( "<option value=\"".$resultRow4["Location"]."\"" );

			if($resultRow4["Location"] == $_POST["Location"])
			{
				echo( " selected" );
			}
			elseif($_POST["Location"] == "" && $resultRow4["Location"] == $country)
			{
				echo( " selected" );
			}

			echo( ">".$resultRow4["Location"]."</option>" );
		}
		echo( "</select><br>" );
	}

}

echo( "</form>");

if(isset($_POST["Location"]) && $_POST["Location"] != "")
{
	$sql5 = "SELECT `ICAO` FROM `ICAO` WHERE `Country` = '".$_POST["Country"]."' AND `State` = '".$_POST["State"]."' AND `Location` = '".$_POST["Location"]."'";
	$selectResult5 = mysql_query($sql5);
	
	$newICAO = mysql_fetch_array($selectResult5);
	$newICAO = $newICAO["ICAO"];

	if($newICAO != "")
	{
		$sql6 = "UPDATE `statistics` SET `ICAO` = '$newICAO' WHERE `Database` = '$office'";
		$selectResult6 = mysql_query($sql6);
		echo( "<br>Updated<br>" );
	}
}
?>
