<?php
function list_companies($inval, $selectNum)
{
  connect_to();
  $sql = "SELECT * FROM `companies` ORDER BY `Name`";
  $result = mysql_query($sql);
  echo("<select name=\"Company$selectNum\">");
  while($row = mysql_fetch_array($result))
  {
    echo( "<option value=\"".$row["Name"]."\"" );
    if($row["Name"] == $inval)
    {
      echo( " selected" );
    }
    echo( ">".$row["Name"]."</option>" );
  }
  echo("</select>");
}
function list_agents($office, $inval)
{
  connect_to();
  $sql = "SELECT * FROM `users` WHERE `office` = '";
  $sql .= $office;
  $sql .= "'";
  $result = mysql_query($sql);
  echo("<select name=\"Agent\">");
  while($row = mysql_fetch_array($result))
  {
    echo( "<option value=\"".$row["username"]."\"" );
    if($row["username"] == $inval)
    {
      echo( " selected" );
    }
    echo( ">".$row["username"]."</option>" );
  }
  echo("</select>");
}

function referralDrop($inval)
{
	include_once('common.inc');
	$filename = getcwd()."/../XML/referral.xml";
	$fh = fopen($filename, 'r');
	$readTo = filesize($filename);
	$rawReferrals = fread($fh, $readTo);
	fclose($fh);

	$referralArray = return_xml_array($rawReferrals, "referral");
	
	echo( "<select name=\"Referred\">" );

	foreach ($referralArray as $singleReferral)
	{
		$referralName = return_xml($singleReferral, "name");
		echo("<option value=\"$referralName\"");
		
		if($inval == $referralName)
		{
			echo(" selected");
		}
		
		echo(">$referralName</option>");
	}
	
	echo( "</select>" );
}

function polTypeDrop($inval)
{
	
	
	include_once('common.inc');
	$filename = getcwd()."/../XML/type.xml";
	$fh = fopen($filename, 'r');
	$readTo = filesize($filename);
	$rawTypes = fread($fh, $readTo);
	fclose($fh);

	$typeArray = return_xml_array($rawTypes, "type");
	
	echo( "<select name=\"Type\">" );

	foreach ($typeArray as $singleType)
	{
		$typeName = return_xml($singleType, "name");
		echo("<option value=\"$typeName\"");
		
		if($inval == $typeName)
		{
			echo(" selected");
		}
		
		echo(">$typeName</option>");
	}
	
	echo( "</select>" );
}
?>