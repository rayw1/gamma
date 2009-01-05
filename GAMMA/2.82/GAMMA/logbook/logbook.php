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
include(getcwd().'/../includes/common.inc');
include(getcwd().'/../includes/insurance.inc');
style("white");
connect_to();
$sql1 = "SELECT * FROM `logbook_struct` WHERE `office` = '$dbase' AND `group` = '$group'";
$itemList1 = mysql_query($sql1);

if($itemList1 == 0)
{
	log_error("Logbook Structure Select Failure: $sql1", "logbook.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not select logbook structure");
}

echo( "<h1>Log Book Entry</h1>" );
echo( "<form action=\"logbook_insert.php\" method=\"post\">" );

echo( "<input type = \"hidden\" name = \"mPass\" value = \"".$_GET["mPass"]."\">" );
echo( "<input type = \"hidden\" name = \"yPass\" value = \"".$_GET["yPass"]."\">" );

echo( "<table>" );

if($row1 = mysql_fetch_row($itemList1))
{
	$num = count($row1);

	for($i = 0; $i < $num; $i++)
	{
		if($row1[$i] == "Y" || $row1[$i] == "R")
		{
			$customfield = 0;
			$fieldname = mysql_field_name($itemList1, $i);

			if($fieldname == "Type")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				polTypeDrop("");
				$customfield = 1;
			}
			if($fieldname == "Date")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				month_drop("", 1);
				day_drop("", 1);
				year_drop("", 1);
				$customfield = 1;
			}
			if($fieldname == "Company")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				list_companies("", "");
				$customfield = 1;
			}
			if($fieldname == "Referred")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				referralDrop("");
				$customfield = 1;
			}
			if($fieldname == "Agent")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				list_agents($dbase, "");
				$customfield = 1;
			}
			if($fieldname == "Commission_Paid")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>
    		<input class=\"blue\" name=\"Commission_Paid\" type=\"checkbox\" value=\"yes\">" );
				$customfield = 1;
			}
			if($fieldname == "Number")
			{
				$customfield = 1;
			}
			if($fieldname == "LastName")
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				echo( "<input class=\"blue\" type=\"text\" name = \"" );
				echo( $fieldname );
				echo( "\" value=\"" );
				echo( $_POST[$fieldname] );
				echo( "\"> (Commercial: Input Company Name Here)" );
				$customfield = 1;
			}

			if($customfield != 1)
			{
				echo( "<tr><td><b>" );
				echo(replace_chars($fieldname));
				echo( "</b></td><td>" );
				echo( "<input class=\"blue\" type=\"text\" name = \"" );
				echo( $fieldname );
				echo( "\" value=\"" );
				echo( $_POST[$fieldname] );
				echo( "\">" );
			}

			echo("</td></tr>");
		}
	}
}

//======================
//=    Customer Db     =
//======================
$sql2 = "SELECT * FROM `customer_general` LIMIT 1";
$itemList2 = mysql_query($sql2);

if($itemList2 == 0)
{
	log_error("Customer Select Failure: $sql2", "logbook.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not select customers");
}

if($row2 = mysql_fetch_row($itemList2))
{
	$num = count($row2);

	for($i = 0; $i < $num; $i++)
	{
		$customfield = 0;
		$fieldname = mysql_field_name($itemList2, $i);

		if($fieldname == "ID" OR $fieldname == "First_Name" OR $fieldname == "Last_Name" OR $fieldname == "Office" OR $fieldname == "Group")
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

