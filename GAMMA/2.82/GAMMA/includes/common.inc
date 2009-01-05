<?php
function big_year_drop($startVal, $selected, $number)
{
	echo("<select name=\"year".$number."\">");

	if($selected == "")
	{
		$curyear = date("Y");
	}
	else
	{
		$curyear = $selected;
	}

	if($startVal == "")
	{
		$startVal = date("Y");
	}

	for($i = $startVal; $i <= date("Y"); $i++)
	{
		echo( "<option value=\"".$i."\"" );
		if($i == $curyear)
		{
			echo( " selected");
		}
		echo( ">".$i."</option>");
	}
	echo("</select>");
}

function browser_detection( $which_test ) {

	// initialize the variables
	$browser = '';
	$dom_browser = '';

	// set to lower case to avoid errors, check to see if http_user_agent is set
	$navigator_user_agent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) ? strtolower( $_SERVER['HTTP_USER_AGENT'] ) : '';

	// run through the main browser possibilities, assign them to the main $browser variable
	if (stristr($navigator_user_agent, "opera")) 
	{
		$browser = 'opera';
		$dom_browser = true;
	}

	elseif (stristr($navigator_user_agent, "msie 4")) 
	{
		$browser = 'msie4'; 
		$dom_browser = false;
	}

	elseif (stristr($navigator_user_agent, "msie")) 
	{
		$browser = 'msie'; 
		$dom_browser = true;
	}

	elseif ((stristr($navigator_user_agent, "konqueror")) || (stristr($navigator_user_agent, "safari"))) 
	{
		$browser = 'safari'; 
		$dom_browser = true;
	}

	elseif (stristr($navigator_user_agent, "gecko")) 
	{
		$browser = 'mozilla';
		$dom_browser = true;
	}
	
	elseif (stristr($navigator_user_agent, "mozilla/4")) 
	{
		$browser = 'ns4';
		$dom_browser = false;
	}
	
	else 
	{
		$dom_browser = false;
		$browser = false;
	}

	// return the test result you want
	if ( $which_test == 'browser' )
	{
		return $browser;
	}
	elseif ( $which_test == 'dom' )
	{
		return $dom_browser;
		//  note: $dom_browser is a boolean value, true/false, so you can just test if
		// it's true or not.
	}
}

function check_chars($stringin)
{
	$size = strlen($stringin);
	for($i = 0; $i < $size; $i++)
	{
		if($stringin[$i] == " ")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == ".")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "/")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "`")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "~")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "-")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "=")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "?")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == ">")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "<")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == ",")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "|")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "{")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "}")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "*")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "&")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "^")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "%")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "$")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "#")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "@")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == "!")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == ";")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
		if($stringin[$i] == ":")
		{
			die("BAD CHARACTER \"".$stringin[$i]."\" FOUND!");
		}
	}
}

function connect_to()
{
	include_once("configuration.php");
	$connection = @mysql_connect($db_host, $db_user, $db_pass) or die ("Could not connect to   mysql<br>");
	$select = @mysql_select_db($db_name, $connection) or die ("Could not select database<br>");
	return $connection;
}

function convertDate($dateIn)
{
	$year = substr($dateIn, 0, 4);
	$month = substr($dateIn, 5, 2);
	$day = substr($dateIn, 8,2);

	$dateOut = $month."-".$day."-".$year;

	return $dateOut;
}

function day_drop($inval, $selectNum)
{
	echo("<select name=\"day".$selectNum."\">");
	if($inval == "")
	{
		$curday = date("d");
	}
	else
	{
		$curday = $inval;
	}

	for($i = 1; $i <= 31; $i++)
	{
		if($i < 10)
		{
			echo( "<option value=\"0".$i."\"" );
		}
		else
		{
			echo( "<option value=\"".$i."\"" );
		}
		if($i == $curday)
		{
			echo( " selected" );
		}
		echo( ">".$i."</option>");
	}
	echo("</select>");
}

function dequote($stringIn)
{
	$stringOut = "";

	$size = strlen($stringIn);
	for($i = 0; $i < $size; $i++)
	{
		if(ord($stringIn[$i]) == "34")
		{
			//echo( "I FOUND A QUOTE");
		}
		else
		{
			//echo( ord($stringIn[$i])." ".$stringIn[$i]."<br>");
			$stringOut .= $stringIn[$i];
		}
	}

	return $stringOut;
}

function despace($stringin)
{
	$size = strlen($stringin);
	$stringout = "";
	for($i = 0; $i < $size; $i++)
	{
		if($stringin[$i] == " ")
		{
			$stringout[$i] = "_";
		}
		else
		{
			$stringout[$i] = $stringin[$i];
		}

	}
	return $stringout;
}

function list_dbs()
{
	include_once("configuration.php");
	$connection = @mysql_connect($db_host, $db_user, $db_pass) or die ("Could not connect to   mysql<br>");
	$result = mysql_list_dbs($connection);
	while( $data = mysql_fetch_row($result) )
	{
		$array[] = $data[0];
	}
	return $array;
}

function log_error($error, $page, $user, $group)
{
	include_once("configuration.php");
	$connection = @mysql_connect($db_host, $db_user, $db_pass) or die ("Could not connect to   mysql<br>");
	mysql_select_db($db_name, $connection) or die ("Unable to log error: step 2<br>");

	$error = mysql_real_escape_string($error);
	
	$sql1 = "INSERT INTO `error_log` (`id`, `error`, `page`, `user`, `group`) VALUES ('', '$error', '$page', '$user', '$group')";
	$insertResult1 = mysql_query($sql1);
	
	if($insertResult1 != 1)
	{
		echo("Unable to log error: step 3<br>$sql1");
	}
	
	echo("An error has occured and a log of this error has been created<br>");
}

function month_drop($inval, $selectNum)
{
	echo("<select name=\"month".$selectNum."\">");
	if($inval == "")
	{
		$curmonth = date("m");
	}
	else
	{
		$curmonth = $inval;
	}
	for($i = 1; $i <= 12; $i++)
	{
		if($i < 10)
		{
			echo( "<option value=\"0".$i."\"" );
		}
		else
		{
			echo( "<option value=\"".$i."\"" );
		}
		if($i == $curmonth)
		{
			echo( " selected" );
		}
		echo( ">".$i."</option>");
	}
	echo("</select>");
}

function replace_chars($stringin)
{
	$size = strlen($stringin);
	$stringout = " ";
	for($i = 0; $i < $size; $i++)
	{
		if($stringin[$i] == "_")
		{
			$stringout[$i] = " ";
		}
		elseif($stringin[$i] == "'")
		{
			$stringout[$i] = " ";
		}
		elseif($stringin[$i] == chr(34))
		{
			$stringout[$i] = "";
		}
		else
		{
			$stringout[$i] = $stringin[$i];
		}

	}
	return $stringout;
}

function respace($stringin)
{
	$size = strlen($stringin);
	$stringout = "";
	for($i = 0; $i < $size; $i++)
	{
		if($stringin[$i] == "_")
		{
			$stringout[$i] = " ";
		}
		else
		{
			$stringout[$i] = $stringin[$i];
		}

	}
	return $stringout;
}

function return_xml($haystack, $needle)
{
	//discard data up to <$needle>
	$haystack = stristr($haystack, "<$needle>");
	//get number of chars up to </$needle>
	$goodLen = strlen($haystack) - strlen(stristr($haystack, "</$needle>"));
	//truncate </$needle> and everything past it
	$haystack = strtrunc($haystack, $goodLen);
	//now get rid of <$needle>
	$goodLen = strlen($haystack) - strlen("<$needle>");
	$haystack = strrev(strtrunc(strrev($haystack), $goodLen));
	//and return
	return $haystack;
}

function return_xml_array($haystack, $needle)
{
	//set it up
	$i = 0;
	$first = true;
	
	do
	{
		//make sure we start with 0
		if(!$first)
		{
			$i++;
		}
		//discard data up to <$needle>
		$haystack = stristr($haystack, "<$needle>");
		//get number of chars up to </$needle>
		$goodLen = strlen($haystack) - strlen(stristr($haystack, "</$needle>"));
		//truncate </$needle> and everything past it in array place 0, put overflow in 1
		$haystack = strtrunc_array($haystack, $goodLen);
		//now get rid of <$needle>
		$goodLen = strlen($haystack[0]) - strlen("<$needle>");
		$returnstack[$i] = strrev(strtrunc(strrev($haystack[0]), $goodLen));
		//throw the remainder into $haystack
		$haystack = $haystack[1];
		//make sure next time i iterates		
		$first = false;
		//and validate the loop
	}while ($returnstack[$i] != "");
	
	//that last one is going to be a blank.  lets just unset it
	unset($returnstack[$i]);

	//send it back
	return $returnstack;
}

function strfind($haystack, $needle)
{
	for($i = 0; $i <= strlen($haystack); $i++)
	{
		if($haystack[$i] == $needle)
		{
			return true;
		}
	}
	return false;
}

function strgetto($haystack, $needle)
{
	//get everything up to needle
	for($i = 0; $i <= strlen($haystack); $i++)
	{
		if($haystack[$i] == $needle)
		{
			$i = strlen($haystack) + 10;
		}
		else 
		{
			$strtoreturn .= $haystack[$i];
		}
	}
	return $strtoreturn;
}

function strtrunc($stringIn, $number)
{
	//push out the jive, return the love
	for($i = 0; $i < $number; $i++)
	{
		$tempString .= $stringIn[$i];
	}
	return $tempString;
}

function strtrunc_array($stringIn, $number)
{
	$totalLen = strlen($stringIn);
	//put the good in position 0
	for($i = 0; $i < $number; $i++)
	{
		$tempString[0] .= $stringIn[$i];
	}
	
	//put the rest in position 1
	for($i; $i <= $totalLen; $i++)
	{
		$tempString[1] .= $stringIn[$i];
	}
	return $tempString;
}

function style($back)
{
	echo( "
	<STYLE type=\"text/css\"> 
  	A{text-decoration: none; color : blue;}
  	A:visited, A:plain, A:active{text-decoration: none; color : blue;} 
  	A:hover{text-decoration: none; color: red;} ");
  	echo( "body{background-color: $back;}");
  	
	if(browser_detection("browser") == "mozilla")
	{  	
		echo( "
  		input.blue{background-color: #ffffff; border-color:#a7a6aa; border-style:solid; border-width:thin;}
		input.blue:focus{background-color: #ebf5ff; border-color:#002276; border-style:solid; border-width:thin;}
		");
	}
	echo( "</STYLE>" );
}

function style_image($back)
{
		echo( "
	<STYLE type=\"text/css\"> 
  	A{text-decoration: none; color : blue;}
  	A:visited, A:plain, A:active{text-decoration: none; color : blue;} 
  	A:hover{text-decoration: none; color: red;} ");
  	echo( "body{background-color: $back;}");
  	
	if(browser_detection("browser") == "mozilla")
	{  	
		echo( "
  		input.blue{background-color: #ffffff; border-color:#a7a6aa; border-style:solid; border-width:thin;}
		input.blue:focus{background-color: #ebf5ff; border-color:#002276; border-style:solid; border-width:thin;}
		");
	}
	echo( "</STYLE>" );
	echo( "<body background=\"".$back."\">");
}

function year_drop($inval, $selectNum)
{
	echo("<select name=\"year".$selectNum."\">");
	$curyear = date("Y");
	$curyear++;

	if($inval == "")
	{
		$inval = date("Y");
	}

	for($i = 2004; $i <= $curyear; $i++)
	{
		echo( "<option value=\"".$i."\"" );
		if($i == $inval)
		{
			echo( " selected");
		}
		echo( ">".$i."</option>");
	}
	echo("</select>");
}
?>