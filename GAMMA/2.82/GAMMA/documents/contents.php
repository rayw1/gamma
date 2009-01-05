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

echo( "
<img src=\"../images/tableofcontents.jpg\" border=\"0\"><br>
<p><a href = \"acord/formIndex.php\">Acord Forms</a></p>
<p><a href = \"companyAddress/companyAddress_search.php\">Company Address List</a></p>
<p><a href = \"companyNumbers/companyNumbers_view.php\">Company Numbers</a></p>
<p><a href = \"farmerslist/farmerslist_search.php\">Farmers List</a></p>
<p><a href = \"keychain/keychain_search.php\">Keychain</a></p>
<p><a href = \"leinholders/leinholders_search.php\">Leinholders List</a></p>
<p><a href = \"mortgagee/mortgagee_search.php\">Mortgagee List</a></p>
<p><a href = \"rss.php\">My RSS Feeds</a></p>
<p><a href = \"routingNumbers/routingNumbers_view.php\">Routing Numbers</a></p>
");
?>
