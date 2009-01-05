<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}

echo( "<form action=\"stats_custom_date2.php\" method=\"post\">
  <h1>Custom Statistics</h1>
  <p>Formula: 
    <select name=\"Formula\">
    <option value=\"averagePremiumPerCompanySingle\">Average Premium Per Company</option>
    <option value=\"Companies\">Company Breakdown</option>
    <option value=\"feesAndPremiumsSingle\">Fees and Premiums</option>
    <option value=\"Logbook\" selected>Logbook</option>
    <option value=\"PremiumPerCompanySingle\">Premium Per Company</option>
    <option value=\"Referrals\">Referrals</option>");

if($admin > 1)
{
	echo( "<option value=\"Line\">Line of Business Breakdown</option>" );
}

if($admin > 2)
{
	echo( "<option value=\"averagePremiumPerCompanyAll\">Average Premium Per Company (All)</option>" );
	echo( "<option value=\"CompaniesAll\">Company Breakdown (All)</option>" );
	echo( "<option value=\"feesAndPremiums\">Fees and Premiums (All)</option>" );
	echo( "<option value=\"LineAll\">Line of Business (All)</option>
	<option value=\"PremiumPerCompanyAll\">Premium Per Company (All)</option>" );
	echo( "<option value=\"ReferralsAll\">Referrals (All)</option>" );
}
if($admin > 3)
{
	echo( "<option value=\"debug\">Debug</option>");
}


echo( "</select><br><br>Dates: " );

month_drop("", 1);
day_drop("", 1);
year_drop("", 1);

echo( " To " );

month_drop("", 2);
day_drop("", 2);
year_drop("", 2);

echo( "<br>
    (Not necessary for every statistic)
    </p>


   <input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> 

  </p>
  </form>
");
