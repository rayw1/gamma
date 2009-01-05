<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
include(getcwd().'/../includes/insurance.inc');
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}

style("white");
echo( "<h1>Search for Customer</h1>" );
if($admin >= 3)
{
	echo( "<a href = \"dupes.php\"><img src=\"dupe_email.gif\" border=\"0\"></a> " );
}

echo( "<a href = \"massemail.php\"><img src=\"mass_email.gif\" border=\"0\"></a> " );
echo( "<a href = \"customerlist.php\"><img src=\"../images/add.gif\" border=\"0\"></a> " );
echo( "<form action=\"customer_results.php\" method=\"POST\">" );
echo( "<table border=\"0\">");
echo( "<tr><td>First Name:</td><td>" );
echo( "<input class=\"blue\" type=\"text\" name=\"fname\"></td></tr><br>" );
echo( "<tr><td>Last Name:</td><td>" );
echo( "<input class=\"blue\" type=\"text\" name=\"lname\"></td></tr></table><br>" );  
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );

echo( "-OR-<br>" );

echo( "<form action=\"customer_company_results.php\" method=\"POST\">" );
echo( "Company: " );
list_companies("", "");
echo( "<br><input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[1].submit()\"> " );
echo( "</form>" );

echo( "<a href = \"customer_bdays.php\">Customer Birthdays</a><br>" );
echo( "<a href = \"customer_reminders.php\">Customer Reminders</a><br>" );
echo( "<a href = \"customer_renewals.php\">Customer Renewals</a><br>" );
echo( "<a href=\"mailmerge.php\">Get Data for a Mail Merge</a><br>");
if($admin >= 2)
{
	echo( "<a href = \"massemail_myOffice.php\">Mass Email for My Customers</a><br>" );
}

?>
