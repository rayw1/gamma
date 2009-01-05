<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
	die("NOT AN ADMIN");
}

$date1 = $_POST["year1"];
$date1 .= "-";
$date1 .= $_POST["month1"];
$date1 .= "-";
$date1 .= $_POST["day1"];
$date1 .= " 00:00:00";

$date2 = $_POST["year2"];
$date2 .= "-";
$date2 .= $_POST["month2"];
$date2 .= "-";
$date2 .= $_POST["day2"];
$date2 .= " 23:59:59";

$mname1 = "Cash";
$mname2 = "Check (Deposited)";
$mname3 = "Check (Mailed)";
$mname4 = "Check (Online)";
$mname5 = "Money Order";
$mname6 = "Credit Card (Office)";
$mname7 = "Credit Card (Online)";

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `receipt` WHERE `Date_Time` >= '$date1' AND `Date_Time` <= '$date2' AND `office` = '$dbase' AND `group` = '$group'";

echo( "<html>" );
echo( "<img src=\"../images/totals.jpg\" border=\"0\"><br>" );
echo( "Results for dates from " );
echo( $date1 );
echo( " to " );
echo( $date2 );
echo( "<br>" );

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Receipt Select Failure: $sql", "rsearch_company.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain receipts");
}

echo( "<table border = \"1\">" );
echo( "<tr><td>" );
echo( "Type" );
echo( "</td><td>" );
echo( "Money Deposited" );
echo( "</td><td>" );
echo( "Money Dispersed" );
echo( "</td></tr>" );

while($row = mysql_fetch_array($itemList))
{
	if($row["PaymentMethod"] == "Check")
	{
		$oldCheck = $oldCheck + 1;
	}

	if($row["PaymentMethod"] == $mname1)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue1 = $mvalue1 + $row["Amount"];
			}
		}
	}
	if($row["PaymentMethod"] == $mname2)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue2 = $mvalue2 + $row["Amount"];
			}
		}
	}
	if($row["PaymentMethod"] == $mname3)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue3 = $mvalue3 + $row["Amount"];
			}
		}
	}
	if($row["PaymentMethod"] == $mname4)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue4 = $mvalue4 + $row["Amount"];
			}
		}
	}
	if($row["PaymentMethod"] == $mname5)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue5 = $mvalue5 + $row["Amount"];
			}
		}
	}
	if($row["PaymentMethod"] == $mname6)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue6 = $mvalue6 + $row["Amount"];
			}
		}
	}
	if($row["PaymentMethod"] == $mname7)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue7 = $mvalue7 + $row["Amount"];
			}
		}
	}

	//Split Payments
	if($row["Method2"] == $mname1)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue1 = $mvalue1 + $row["Amount2"];
			}
		}
	}
	if($row["Method2"] == $mname2)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue2 = $mvalue2 + $row["Amount2"];
			}
		}
	}
	if($row["Method2"] == $mname3)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue3 = $mvalue3 + $row["Amount2"];
			}
		}
	}
	if($row["Method2"] == $mname4)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue4 = $mvalue4 + $row["Amount2"];
			}
		}
	}
	if($row["Method2"] == $mname5)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue5 = $mvalue5 + $row["Amount2"];
			}
		}
	}
	if($row["Method2"] == $mname6)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue6 = $mvalue6 + $row["Amount2"];
			}
		}
	}
	if($row["Method2"] == $mname7)
	{
		if($row["Completed"] == "Yes")
		{
			if($row["Void"] == "No")
			{
				$mvalue7 = $mvalue7 + $row["Amount2"];
			}
		}
	}
}

$mvalue1 = sprintf("%01.2f", $mvalue1);
$mvalue2 = sprintf("%01.2f", $mvalue2);
$mvalue3 = sprintf("%01.2f", $mvalue3);
$mvalue4 = sprintf("%01.2f", $mvalue4);
$mvalue5 = sprintf("%01.2f", $mvalue5);
$mvalue6 = sprintf("%01.2f", $mvalue6);
$mvalue7 = sprintf("%01.2f", $mvalue7);

$tdeposit = $mvalue1 + $mvalue2 + $mvalue5;
$tdisperse = $mvalue3 + $mvalue4 + $mvalue6 + $mvalue7;

$tdeposit = sprintf("%01.2f", $tdeposit);
$tdisperse = sprintf("%01.2f", $tdisperse);

echo( "<tr><td>Cash</td><td>$" );
echo( $mvalue1 );
echo( "</td><td></td></tr>" );
echo( "<tr><td>Check (Deposited)</td><td>$" );
echo( $mvalue2 );
echo( "</td><td></td></tr>" );
echo( "<tr><td>Money Order</td><td>$" );
echo( $mvalue5 );
echo( "</td><td></td></tr>" );
echo( "<tr><td>Check (Mailed)</td><td></td><td>$" );
echo( $mvalue3 );
echo( "</td></tr>" );
echo( "<tr><td>Check (Online)</td><td></td><td>$" );
echo( $mvalue4 );
echo( "</td></tr>" );
echo( "<tr><td>Credit Card (Office)</td><td></td><td>$" );
echo( $mvalue6 );
echo( "</td></tr>" );
echo( "<tr><td>Credit Card (Online)</td><td></td><td>$" );
echo( $mvalue7 );
echo( "</td></tr>" );
echo( "<tr><td><b>Totals:</b></td><td><b>$" );
echo( $tdeposit );
echo( "</b></td><td><b>$" );
echo( $tdisperse );
echo( "</b></td></tr>" );



echo( "</table><br>");
if( $oldCheck > 1 )
{
	echo( $oldCheck );
	echo(" old check record(s) omitted, please update<br>");
}
?>
<form action="totals.php" method="POST">
<table border="1">
  <tr>
    <td>&nbsp;</td>
    <td>Month</td>
    <td>Day</td>
    <td>Year</td>
  </tr>
  <tr>
    <td>Starting Date:</td>
    <td><select name="month1">
        <option value="<?php $now = date("m"); echo($now); ?>"><?php $now = date("m"); echo($now); ?></option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select></td>
    <td><select name="day1">
	<option value="<?php $now = date("d"); echo($now); ?>"><?php $now = date("d"); echo($now); ?></option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
      </select></td>
    <td><select name="year1">
    <?php
    for( $i = date("Y"); $i >= 2003; $i--)
    {
    	echo( "<option value=\"$i\">$i</option>" );
    }

    ?>
      </select></td>
  </tr>
  <tr>
    <td>Ending Date:</td>
    <td><select name="month2">
	<option value="<?php $now = date("m"); echo($now); ?>"><?php $now = date("m"); echo($now); ?></option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select></td>
    <td><select name="day2">
	<option value="<?php $now = date("d"); echo($now); ?>"><?php $now = date("d"); echo($now); ?></option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
      </select></td>
    <td><select name="year2">
    <?php
    for( $i = date("Y"); $i >= 2003; $i--)
    {
    	echo( "<option value=\"$i\">$i</option>" );
    }

    ?>
      </select></td>
  </tr>
</table>
<?php echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " ); ?>
</form>
<br>

