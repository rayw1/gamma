<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
connect_to();
style("white");
$valid = $_SESSION["validsession"];
$id = mysql_real_escape_string($_GET["id"]);
$dbase = mysql_real_escape_string($_GET["dbase"]);
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];

if($valid != 1)
{
	die("INVALID SESSION");
}

$sql0 = "SELECT * FROM `customer_general` WHERE `ID` = '$id'";
$items0 = mysql_query($sql0);
if($items0 == 0)
{
	echo("Couldnt get customer info");
	log_error("Customer List Select Failure: $sql0", "customer_email_edit1.php", $_SESSION["username"], $_SESSION["group"]);
}
$result0 = mysql_fetch_array($items0);

$email = $result0["Email"];

echo( "<h1>Email Edit</h1>" );

echo( "<form action=\"customer_email_edit2.php\" method=\"POST\">" );
echo( "<input type=\"hidden\" name=\"id\" value=\"$id\">" );
echo( "<input type=\"hidden\" name=\"dbase\" value=\"$dbase\">" );
echo( "<input name=\"email\" value=\"$email\" size=\"30\">" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
?>
