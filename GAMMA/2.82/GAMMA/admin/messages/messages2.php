<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die("ADMIN TOO LOW");
}
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$date = mysql_real_escape_string($_POST["Date"]);
$goback = mysql_real_escape_string($_POST["comeback"]);
//Figure out which messages we need to update
//perform the update on them
//redirect

for($i = 0; $i <= 3; $i++)
{
	$activePost = "active$i";
	$active = mysql_real_escape_string($_POST[$activePost]);
	if($active == "yes")
	{
		$messagePost = "message$i";
		$messageUpdate = mysql_real_escape_string($_POST[$messagePost]);
		$messageUpdate = nl2br($messageUpdate);
		$stickyPost = "sticky$i";
		$sticky = mysql_real_escape_string($_POST[$stickyPost]);
		if($messageUpdate == '')
		{
			$sql2 = "DELETE FROM `messages` WHERE `level` = '$i' AND `group` = '$group' AND `Date` = '$date'";
		}
		else 
		{
			$sql2 = "UPDATE `messages` SET `Message` = '$messageUpdate', `Sticky` = '$sticky' WHERE `level` = '$i' AND `group` = '$group' AND `Date` = '$date'";
		}
		$updateResult = mysql_query($sql2);
		//echo( $sql2."<br>" );

		if($updateResult)
		{
			//echo( "Updated level $i<br>" );
		}
		else
		{
			log_error("Message Update Failure: $sql2", "messages2.php", $_SESSION["username"], $_SESSION["group"]);
			echo( "Updated failed on level $i<br>" );
		}
	}
	else 
	{
		//echo("no update required on level $i.<br>");
	}
}


echo( "<script>
<!--
location=\"messages1.php?date=$goback\";
//-->
</script> ");

?>
