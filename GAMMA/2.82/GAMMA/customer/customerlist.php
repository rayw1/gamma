<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}

style( "white" );
echo( "<h1>Customer Entry</h1>" );
echo( "<form action=\"customerlist_insert.php\" method=\"post\">" );
echo( "<table>" );

//======================
//=    Customer Db     =
//======================
connect_to();
$sql2 = "SELECT * FROM `customer_general` LIMIT 1";
$itemList2 = mysql_query($sql2);

if($itemList2 == 0)
{
	log_error("Customer List Select Failure: $sql2", "customerlist.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not select customers");
}

if($row2 = mysql_fetch_row($itemList2))
{
	$num = count($row2);

	for($i = 0; $i < $num; $i++)
	{
		$customfield = 0;
		$fieldname = mysql_field_name($itemList2, $i);
		
		if($fieldname == "ID" OR $fieldname == "Office" OR $fieldname == "Group")
		{
			$customfield = 1;
		}
		
		if($fieldname == "DOB")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			month_drop("", 2);
			day_drop("", 2);
			big_year_drop("1920", "", 2);
			$customfield = 1;
		}

		if($fieldname == "State")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			echo( "<input class=\"blue\" name=\"State\" size=\"3\" maxlength=\"2\">" );
			$customfield = 1;
		}
		
		if($fieldname == "Zip")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			echo( "<input class=\"blue\" name=\"Zip\" size=\"12\" maxlength=\"10\">" );
			$customfield = 1;
		}
		
		if($fieldname == "ReminderDate1")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			month_drop("", 3);
			day_drop("", 3);
			year_drop("", 3);
			$customfield = 1;
		}
		if($fieldname == "ReminderDate2")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			month_drop("", 4);
			day_drop("", 4);
			year_drop("", 4);
			$customfield = 1;
		}
		if($fieldname == "ReminderDate3")
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			month_drop("", 5);
			day_drop("", 5);
			year_drop("", 5);
			$customfield = 1;
		}
		
		if($customfield != 1)
		{
			echo( "<tr><td><b>" );
			echo(replace_chars($fieldname));
			echo( "</b></td><td>" );
			echo( "<input class=\"blue\" type=\"text\" name = \"" );
			echo( $fieldname );
			echo( "\">" );
		}

		echo("</td></tr>");
	}
}
echo( "</table>" );

echo( "<input type=\"Button\" value=\"Add\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>");
?>
