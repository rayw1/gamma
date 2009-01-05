<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

echo( "<h1>Acord Forms</h1>");

$n = mysql_real_escape_string($_GET["n"]);
if($n == "")
{
	$n = "Name";
}
$a = mysql_real_escape_string($_GET["a"]);
if($a == "")
{
	$a = "ASC";
}

if($admin >= 3)
{
	echo( "<a href=\"addForm.php\"><img src=\"../../images/add.gif\" border=\"0\"></a><br>");
	echo( "<form action=\"editForm.php\" method=\"post\">" );
	echo( "<b>Edit ID:</b> <input class=\"blue\" type=\"text\" name=\"fid\" size = \"5\">");
	echo( "<input type=\"Button\" value=\"Edit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></form>" );
}

$sql1 = "SELECT * FROM `acord` ORDER BY `$n` $a";
$selectResult1 = mysql_query($sql1);

$color = "#CCFFCC";
echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">");
echo( "<tr><td>");

if($n == "Number" && $a == "ASC")
{
	echo( "<a href=\"formIndex.php?n=Number&a=DESC\">");
}
elseif($n == "Number" && $a == "DESC")
{
	echo( "<a href=\"formIndex.php?n=Number&a=ASC\">");
}
else 
{
	echo( "<a href=\"formIndex.php?n=Number&a=ASC\">");	
}

echo( "Number</a></td><td></td><td>" );

if($n == "Name" && $a == "ASC")
{
	echo( "<a href=\"formIndex.php?n=Name&a=DESC\">");
}
elseif($n == "Name" && $a == "DESC")
{
	echo( "<a href=\"formIndex.php?n=Name&a=ASC\">");
}
else 
{
	echo( "<a href=\"formIndex.php?n=Name&a=ASC\">");	
}

echo( "Name</a></td></tr>");
while($row = mysql_fetch_array($selectResult1))
{
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
	echo( ";\"><td><a href=\"showForm.php?fid=".$row["ID"]."\" target=\"_new\">".$row["Number"]."</a></td>" );
	echo( "<td width=\"10px\"></td>");
	echo( "<td><a href=\"showForm.php?fid=".$row["ID"]."\" target=\"_new\">".$row["Name"]."</a></td></tr>" );
}
echo( "</table>" );
?>
