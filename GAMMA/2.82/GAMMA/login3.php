<head>
<SCRIPT LANGUAGE="JavaScript">
if (window != top) top.location.href = location.href;
</script>
<title>GAMMA Login</title>
</head>

<?php
//GAMMA V2.8 CERTIFIED
include(getcwd().'/includes/common.inc');
style("white");
connect_to();

$groupIn = mysql_real_escape_string($_GET["group"]);

if($groupIn == "")
{
	die("No Group");
}

$query = mysql_query("SELECT DISTINCT `username` FROM `users` WHERE `Group` = '$groupIn' OR `Group` = 'All' ORDER BY username");

echo( "<form method=\"post\" action=\"validate.php\">" );
echo( "<input type=\"hidden\" name=\"group\" value=\"".$groupIn."\">" );
echo( "<center><img src = \"images/gamma_Small.gif\" border = \"0\"><br>General Agency Management Modules Application<br><br>" );
echo( "<table border=\"0\"><tr><td>" );
echo( "<center>Username: <br><select name=\"logonid\" size=\"10\">");


while($row = mysql_fetch_array($query)) 
{
  echo("<option value=\"".$row["username"]."\">".$row["username"]."</option>");
}

echo( "</select></center></td><td>" );
echo( "<center>Password:<br><input class=\"blue\" name=\"password\" type=\"password\" size=\"16\" maxlength=\"16\"><br><input type=\"Button\" value=\"Login\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"></center></td></tr></table></form><br>" );
$utest = $_COOKIE["username"];
if($utest != "")
{
	echo( "<center><a href=\"flashLogin.php\">Flash Login as $utest</a></center><br>" );
}
?>
