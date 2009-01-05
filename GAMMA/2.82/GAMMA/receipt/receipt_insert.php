<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
connect_to();
style("white");

$first = $_POST["First"];
$last = $_POST["Last"];
$amount = $_POST["Amount"];
$reason = $_POST["Reason"];
$method = $_POST["Method"];
$checknum = $_POST["CheckNumber"];

$amount2 = $_POST["Amount2"];
$method2 = $_POST["Method2"];
$checknum2 = $_POST["CheckNumber2"];

$polnum = $_POST["PolNum"];

$email = $_POST["email"];
$uname = $_SESSION["username"];
$to = $_POST["To"];

$nowStamp = mktime(date("H")-1, date("i"), date("s"), date("m"), date("d"), date("Y"));
$now = date("Y-m-d H:i:s", $nowStamp);

$sql = "INSERT INTO `receipt` (`ReceiptID`, `FirstName`, `LastName`, `Amount`, `Date_Time`, `Reason`, `PaymentMethod`, `CheckNumber`, `PolNum`) VALUES ('', '$first', '$last', '$amount', '$now', '$reason', '$method', '$checknum', '$polnum')";

$insertresult = mysql_query($sql);

$rnum = mysql_insert_id();

$sql2 = "UPDATE `receipt` SET
`By` = '$uname', 
`Completed` = 'No', 
`To` = '$to', 
`Void` = 'No', 
`Amount2` = '$amount2', 
`CheckNumber2` = '$checknum2', 
`Method2` = '$method2', 
`group` = '$group', 
`office` = '$dbase'
WHERE `ReceiptID` = '$rnum'";

$insertresult2 = mysql_query($sql2);

if($insertresult == 1)
{
}
else
{
	log_error("Receipt Insert Failure: $sql", "receipt_insert.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure<br>" );
}

if($insertresult2 == 1)
{
}
else
{
	log_error("Receipt Update Failure: $sql2", "receipt_insert.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write2 Failure<br>" );
}

$bridge = $_POST["bridge"];
$header = "receipt_print.php?rid=$rnum&bridge=$bridge";

echo( "
<script>
<!--
location=\"".$header."\";
//-->
</script> 
" );

?>
