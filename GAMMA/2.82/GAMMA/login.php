<?php
//GAMMA V2.8 CERTIFIED
include(getcwd().'/includes/common.inc');
connect_to();
style("white");

echo( "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<head>
<SCRIPT LANGUAGE=\"JavaScript\">
if (window != top) top.location.href = location.href;
</script>
<title>GAMMA Login</title>
</head>
<form method=\"post\" action=\"login2.php\">
<center><img src = \"images/gamma_Small.gif\" border = \"0\"><br>General Agency Management Modules Application<br><br>
Please enter your group code:<br>
<input class=\"blue\" name=\"group\" value=\"Alternatives\" class=\"blue\"><br>
<br><input type=\"Button\" value=\"Proceed\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></center></form>
<br><center>BETA RELEASE</center>" );
$utest = mysql_real_escape_string($_COOKIE["username"]);
if($utest != "")
{
	echo( "<center><a href=\"flashLogin.php\">Flash Login as $utest</a></center><br>" );
}
?>
