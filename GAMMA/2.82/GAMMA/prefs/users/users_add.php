<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$uname = $_SESSION["username"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
  die("Admin level too low");
}
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

echo( "

<h1>User Entry</h1>
<form action=\"users_insert.php\" method=\"post\">
<p>Name: 
    <input class=\"blue\" type=\"text\" name=\"name\">
</p>

<p>
<table><tr><td>
Password: </td><td><input class=\"blue\" type=\"password\" name=\"pass1\"></td></tr>
<tr><td>Verify: </td><td><input class=\"blue\" type=\"password\" name=\"pass2\"></td></tr>
</table>
</p>


<p>
Admin Level: 
<select name=\"adminlevel\">

" );

for($i = 0; $i <= $admin; $i++)
{
	echo( "<option value=\"".$i."\">".$i."</option>" );
}

echo( "
</select>
</p>

<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> 

</form>

");
?>
