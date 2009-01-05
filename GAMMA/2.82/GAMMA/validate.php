<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/includes/common.inc');
connect_to();
$uquery = mysql_query("SELECT * FROM `users`");
$utest = mysql_real_escape_string($_POST["logonid"]);
$ptest = mysql_real_escape_string($_POST["password"]);
$atest = 0;
$gtest = mysql_real_escape_string($_POST["group"]);
$_SESSION["admin"] = 0;

// Set expiration (30 days)
$expire = time() + (86400*30);

while($row = mysql_fetch_array($uquery))
{

	if(strtoupper($row["username"]) == strtoupper($utest))
	{
		$uvalid = 1;
		$_SESSION["username"] = $utest;
		setcookie("username", $utest, $expire);

		if($row["password"] == md5($ptest))
		{
			$pvalid = 1;
			setcookie("password", md5($ptest), $expire);
			$_SESSION["office"] = $row["office"];
			$_SESSION["validsession"] = 1;
			$_SESSION["group"] = $gtest;
			setcookie("group", $gtest, $expire);
			if($row["group"] == $gtest OR $row["group"] == "All")
			{
				if($row["Admin"] >= $atest)
				{
					$avalid = 1;
					$_SESSION["admin"] = $row["Admin"];
				}
			}
		}
	}
}
if($avalid == 1)
{
	echo( "Success, changing page" );
	echo( "
	<script>
	<!--
	location=\"dashboard.php\";
	//-->
	</script> 
	" );
}
else
{
	die( "ERROR! PLEASE TRY AGAIN.");
}
?>
