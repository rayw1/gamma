<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
echo( "Are you SURE you want to delete this quote?
<form action=\"quotesheet_delete2.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"".$_POST["id"]."\">
<input type=\"button\" value=\"Yes\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">
<input type=\"button\" onclick=\"javascript:location='quotesheet_search.php';this.disabled=1\" value=\"No\">
</form>
");
?>
