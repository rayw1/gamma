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

if($admin < 1)
{
	die("NOT AN ADMIN");
}

include(getcwd().'/../includes/common.inc');
connect_to();

$first = $_POST["First"];
$last = $_POST["Last"];
$amount = $_POST["Amount"];
$amount2 = $_POST["Amount2"];
$reason = $_POST["Reason"];
$method = $_POST["Method"];
$method2 = $_POST["Method2"];
$checknum = $_POST["CheckNumber"];
$checknum2 = $_POST["CheckNumber2"];
$to = $_POST["To"];
$complete = $_POST["Complete"];
$void = $_POST["Void"];
$rnum = $_POST["rnum"];
$polnum = $_POST["PolNum"];

$sql = "UPDATE `receipt` SET `FirstName` = '$first', `LastName` = '$last', `Amount` = '$amount', `Reason` = '$reason', `PolNum` = '$polnum' WHERE `ReceiptID` = '$rnum'";

$insertresult = mysql_query($sql);

$sql2 = "UPDATE `receipt` SET
`PaymentMethod` = '$method', 
`CheckNumber` = '$checknum', 
`To` = '$to', 
`Void` = '$void', 
`Completed` = '$complete', 
`Amount2` = '$amount2', 
`CheckNumber2` = '$checknum2', 
`Method2` = '$method2' 
WHERE `ReceiptID` = '$rnum'";

$insertresult2 = mysql_query($sql2);


if($insertresult == 1)
{
	echo( "Update 1 Success<br>" );
}
else
{
	log_error("Receipt Update Failure: $sql", "receipt_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Update 1 Failure<br>" );
}

if($insertresult2 == 1)
{
	echo( "Update 2 Success<br>" );
}
else
{
	log_error("Receipt Update Failure: $sql2", "receipt_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Update 2 Failure<br>" );
}

echo( "
<script>
location=\"receipt_search.php\";
</script> 
");
?>
