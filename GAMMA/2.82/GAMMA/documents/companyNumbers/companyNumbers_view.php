<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$sql1 = "SELECT * FROM `companynumbers` ORDER BY `Name`";

echo( "<html>" );

echo( "<h1>Company Numbers</h1>" );

$itemList = mysql_query($sql1);

if($itemList == 0)
{
	log_error("Company Number Select Failure: $sql1", "companyNumbers_view.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain Company Numbers");
}

echo( "<a href = \"companyNumbers_add.php\"><img src=\"../../images/add.gif\" border=\"0\"></a><br>" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );

$i = 0;
$item = 0;
$color = "#CCFFCC";
while($row = mysql_fetch_row($itemList))
{
	$item++;
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

	$num = count($row);
	if($i == 0)
	{
		for($i = 0; $i < $num; $i++)
		{
			if(replace_chars(mysql_field_name($itemList, $i)) != "ID")
			{
				echo( "<td><b>" );
				echo(replace_chars(mysql_field_name($itemList, $i)));
				echo( "</b></td>" );
			}
		}
		echo ("<td><b>Edit</b></td><td><b>Delete</b></td></tr><tr>");
	}

	$i = 0;
	for($i = 0 ; $i < $num; $i++)
	{
		if(replace_chars(mysql_field_name($itemList, $i)) != "ID")
		{
			echo( "<td>" );
			echo( $row[$i] );
			echo( "</td>" );
		}
	}
	echo( "<td><a href=\"companyNumbers_edit.php?nid=".$row[0]."\"><img src=\"../../images/edit.gif\" border=\"0\"></a></td><td><a href=\"companyNumbers_delete.php?nid=".$row[0]."\"><img src=\"../../images/delete.gif\" border=\"0\"></a></td></tr>" );
}
echo( "</table>" );
?>
