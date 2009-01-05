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
style("white");
echo( "<form action=\"stats_custom2.php\" method=\"post\">
  <h1>Custom Statistics</h1>
  <p>Formula: 
    <select name=\"Formula\">
    <option value=\"averagePremiumPerCompanySingle\">Average Premium Per Company</option>
	<option value=\"customerAge\">Customer Birth Years</option>
    <option value=\"Companies\">Company Breakdown</option>
    <option value=\"feesAndPremiumsSingle\">Fees and Premiums</option>
    <option value=\"Logbook\" selected>Logbook</option>
    <option value=\"PremiumPerCompanySingle\">Premium Per Company</option>
    <option value=\"Referrals\">Referrals</option>
	<option value=\"trendformonth\">Trend: Logbook</option>");

if($admin > 1)
{
	echo( "<option value=\"Line\">Line of Business Breakdown</option>" );
}

if($admin > 2)
{
	echo( "<option value=\"averagePremiumPerCompanyAll\">Average Premium Per Company (All)</option>" );
	echo( "<option value=\"CompaniesAll\">Company Breakdown (All)</option>" );
	echo( "<option value=\"CompaniesAllYear\">Company Breakdown for the Year (All)</option>" );
	echo( "<option value=\"feesAndPremiums\">Fees and Premiums (All)</option>" );
	echo( "<option value=\"LineAll\">Line of Business (All)</option>
	<option value=\"PremiumPerCompanyAll\">Premium Per Company (All)</option>" );
	echo( "<option value=\"ReferralsAll\">Referrals (All)</option>" );
}


echo( "    </select>
    </p>
  <p>Month:" );
month_drop("", "");
echo("Year:");
year_drop("", "");

echo("
    <br>
    (Not necessary for every statistic)
    </p>


   <input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> 

  </p>
  </form>
  <a href=\"stats_custom_date.php\">Find statistics using a custom date range</a><br>
");
