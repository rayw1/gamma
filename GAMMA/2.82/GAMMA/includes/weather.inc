<?php
function get_metar($station, &$wxInfo)
{
	$host = 'weather.noaa.gov';
	$location = "/pub/data/observations/metar/stations/$station.TXT";

	//Caching (we want to update the cache every 15 minutes)
	$filename = getcwd()."/cache/Weather_$station.cache";
	$now = date("YmdGis",mktime(date("G"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	$fifteenAgo = date("YmdGis",mktime(date("G"),date("i")-15,date("s"),date("m"),date("d"),date("Y")));

	//Does the file exist?
	if(!file_exists($filename))
	{
		//echo( "FILE DID NOT EXIST<br>" );
		//No.  Create file, get contents
		$metar = fetch($host, $location);
		$fh = fopen($filename, 'w');
		fputs($fh, $now);
		fputs($fh, "\r\n");
		fputs($fh, $metar);
		fclose($fh);
	}
	else
	{
		//echo( "FILE DID EXIST<br>" );
		//File does exist... but is it current?
		$fh = fopen($filename, 'r');
		$lastCached = fread($fh, 14);
		//echo("LAST CACHED: $lastCached<br>");
		fclose($fh);

		//is it older than 15 min ago?
		if($lastCached < $fifteenAgo)
		{
			//echo( "FILE WAS OLD<br>" );
			//Yes.  Redownload data and store.
			$metar = fetch($host, $location);
			$fh = fopen($filename, 'w');
			fputs($fh, $now);
			fputs($fh, "\r\n");
			fputs($fh, $metar);
			fclose($fh);
		}
		else
		{
			//echo( "FILE WAS CURRENT<br>" );
			//No, its current.  Lets read the cache into memory
			$fh = fopen($filename, 'r');
			$readTo = filesize($filename);
			$metar = fread($fh, $readTo);
			fclose($fh);
		}
	}
	return $metar;
}

function fetch($host, $location)
{
	$request = "HTTP/1.1\r\n";// .
	//"If-Modified-Since: Sat, 29 Oct 1994 09:00:00 GMT\r\n" .
	//"Pragma: no-cache\r\n".
	//"Cache-Control: no-cache\r\n";

	$fp = fsockopen($host, 80);
	$request = "GET $location $request" .
	"Host: $host\r\n" .
	"Content-Type: text/html\r\n" .
	"Connection: Close\r\n\r\n";

	$data = false;

	if ($fp) {
		fputs($fp, $request);
		/* We check the status line */
		if (strpos(fgets($fp, 1024), '200 ')) {
			/* Then we seek until we find the empty line between the
			* headers and the contents.
			*/
			do {
				$line = fgets($fp, 1024);
			} while ($line != "\r\n");

			/* We know now, that the following lines are the contents. */
			while ($line = fgets($fp, 1024)) {
				$fileData[] = $line;
			}
			fclose($fp);
		}
	};

	$metar = '';
	if ($fileData != false) {
		list($i, $date) = each($fileData);
		$utc = strtotime(trim($date));
		set_time_data($utc,$wxInfo);
		while (list($i, $line) = each($fileData)) {
			$metar .= ' ' . trim($line);
		}
		$metar = trim(str_replace('  ', ' ', $metar));
	}
	return $metar;
}

function set_time_data($utc, &$wxInfo) {
	// This function formats observation time in the local time zone of server, the
	// current local time on server, and time difference since observation. $utc is a
	// UNIX timestamp for Universal Coordinated Time (Greenwich Mean Time or Zulu Time).
	$timeZoneOffset = date('Z');
	$local = $utc + $timeZoneOffset;
	$wxInfo['OBSERVED'] = date('D M j, H:i T',$local);
	$now = time();
	$wxInfo['NOW'] = date('D M j, H:i T',$now);
	$timeDiff = floor(($now - $local) / 60);
	if ($timeDiff < 91) $wxInfo['AGE'] = "$timeDiff min ago";
	else {
		$min = $timeDiff % 60;
		if ($min < 10) $min = '0' . $min;
		$wxInfo['AGE'] = floor($timeDiff / 60) . ":$min hr ago";
	}
}

function process_metar($metar, &$wxInfo) {
	//   This function directs the examination of each group of the METAR. The problem
	// with a METAR is that not all the groups have to be there. Some groups could be
	// missing. Fortunately, the groups must be in a specific order. (This function
	// also assumes that a METAR is well-formed, that is, no typographical mistakes.)
	//   This function uses a function variable to organize the sequence in which to
	// decode each group. Each function checks to see if it can decode the current
	// METAR part. If not, then the group pointer is advanced for the next function
	// to try. If yes, the function decodes that part of the METAR and advances the
	// METAR pointer and group pointer. (If the function can be called again to
	// decode similar information, then the group pointer does not get advanced.)
	if ($metar != '') {
		$metarParts = explode(' ',$metar);
		$groupName = array('get_station','get_time','get_station_type','get_wind','get_var_wind','get_visibility','get_runway','get_conditions','get_cloud_cover','get_temperature','get_altimeter');
		$metarPtr = 1;  // get_station identity is ignored
		$group = 1;
		while ($group < count($groupName)) {
			$part = $metarParts[$metarPtr];
			$groupName[$group]($part,$metarPtr,$group,$wxInfo);  // $groupName is a function variable
		}
	}
	else $wxInfo['ERROR'] = 'Data not available';
}

function get_station($part, &$metarPtr, &$group, &$wxInfo) {
	// Ignore station code. Script assumes this matches requesting $station.
	// This function is never called. It is here for completeness of documentation.
	if (strlen($part) == 4 and $group == 0) {
		$group++;
		$metarPtr++;
	}
}

function get_time($part, &$metarPtr, &$group, &$wxInfo) {
	// Ignore observation time. This information is found in the first line of the NWS file.
	// Format is ddhhmmZ where dd = day, hh = hours, mm = minutes in UTC time.
	if (substr($part,-1) == 'Z') $metarPtr++;
	$group++;
}

function get_station_type($part, &$metarPtr, &$group, &$wxInfo) {
	// Ignore station type if present.
	if ($part == 'AUTO' || $part == 'COR') $metarPtr++;
	$group++;
}

function get_wind($part, &$metarPtr, &$group, &$wxInfo) {
	// Decodes wind direction and speed information.
	// Format is dddssKT where ddd = degrees from North, ss = speed, KT for knots,
	// or dddssGggKT where G stands for gust and gg = gust speed. (ss or gg can be a 3-digit number.)
	// KT can be replaced with MPH for meters per second or KMH for kilometers per hour.

	function speed($part, $unit) {
		// Convert wind speed into miles per hour.
		// Some other common conversion factors (to 6 significant digits):
		//   1 mi/hr = 1.15080 knots  = 0.621371 km/hr = 2.23694 m/s
		//   1 ft/s  = 1.68781 knots  = 0.911344 km/hr = 3.28084 m/s
		//   1 knot  = 0.539957 km/hr = 1.94384 m/s
		//   1 km/hr = 1.852 knots    = 3.6 m/s
		//   1 m/s   = 0.514444 knots = 0.277778 km/s
		if ($unit == 'KT') $speed = round(1.1508 * $part);         // from knots
		elseif ($unit == 'MPS') $speed = round(2.23694 * $part);   // from meters per second
		else $speed = round(0.621371 * $part);                     // from km per hour
		$speed = "$speed mph";
		return $speed;
	}

	if (ereg('^([0-9G]{5,10}|VRB[0-9]{2,3})(KT|MPS|KMH)$',$part,$pieces)) {
		$part = $pieces[1];
		$unit = $pieces[2];
		if ($part == '00000') {
			$wxInfo['WIND'] = 'calm';  // no wind
		}
		else {
			ereg('([0-9]{3}|VRB)([0-9]{2,3})G?([0-9]{2,3})?',$part,$pieces);
			if ($pieces[1] == 'VRB') $direction = 'varies';
			else {
				$angle = (integer) $pieces[1];
				$compass = array('N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW');
				$direction = $compass[round($angle / 22.5) % 16];
			}
			if ($pieces[3] == 0) $gust = '';
			else $gust = ', gusting to ' . speed($pieces[3], $unit);
			$wxInfo['WIND'] = $direction . ' at ' . speed($pieces[2], $unit) . $gust;
		}
		$metarPtr++;
	}
	$group++;
}

function get_var_wind($part, &$metarPtr, &$group, &$wxInfo) {
	// Ignore variable wind direction information if present.
	// Format is fffVttt where V stands for varies from fff degrees to ttt degrees.
	if (ereg('([0-9]{3})V([0-9]{3})',$part,$pieces)) $metarPtr++;
	$group++;
}

function get_visibility($part, &$metarPtr, &$group, &$wxInfo) {
	// Decodes visibility information. This function will be called a second time
	// if visibility is limited to an integer mile plus a fraction part.
	// Format is mmSM for mm = statute miles, or m n/dSM for m = mile and n/d = fraction of a mile,
	// or just a 4-digit number nnnn (with leading zeros) for nnnn = meters.
	static $integerMile = '';
	if (strlen($part) == 1) {  // visibility is limited to a whole mile plus a fraction part
		$integerMile = $part . ' ';
		$metarPtr++;
	}
	elseif (substr($part,-2) == 'SM') {  // visibility is in miles
		$part = substr($part,0,strlen($part)-2);
		if (substr($part,0,1) == 'M') {
			$prefix = 'less than ';
			$part = substr($part, 1);
		}
		else $prefix = '';
		if (($integerMile == '' && ereg('[/]',$part,$pieces)) || $part == '1') $unit = ' mile';
		else $unit = ' miles';
		$wxInfo['VISIBILITY'] = $prefix . $integerMile . $part . $unit;
		$metarPtr++;
		$group++;
	}
	elseif (substr($part,-2) == 'KM') {  // unknown (Reported by NFFN in Fiji)
		$metarPtr++;
		$group++;
	}
	elseif (ereg('^([0-9]{4})$',$part,$pieces)) {  // visibility is in meters
		$distance = round($part/ 621.4, 1);          // convert to miles
		if ($distance > 5) $distance = round($distance);
		if ($distance <= 1) $unit = ' mile';
		else $unit = ' miles';
		$wxInfo['VISIBILITY'] = $distance . $unit;
		$metarPtr++;
		$group++;
	}
	elseif ($part == 'CAVOK') {  // good weather
		$wxInfo['VISIBILITY'] = 'greater than 7 miles';  // or 10 km
		$wxInfo['CONDITIONS'] = '';
		$wxInfo['CLOUDS'] = 'clear skies';
		$metarPtr++;
		$group += 4;  // can skip the next 3 groups
	}
	else {
		$group++;
	}
}

function get_runway($part, &$metarPtr, &$group, &$wxInfo) {
	// Ignore runway information if present. Maybe called a second time.
	// Format is Rrrr/vvvvFT where rrr = runway number and vvvv = visibility in feet.
	if (substr($part,0,1) == 'R') $metarPtr++;
	else $group++;
}

function get_conditions($part, &$metarPtr, &$group, &$wxInfo) {
	// Decodes current weather conditions. This function maybe called several times
	// to decode all conditions. To learn more about weather condition codes, visit section
	// 12.6.8 - Present Weather Group of the Federal Meteorological Handbook No. 1 at
	// www.nws.noaa.gov/oso/oso1/oso12/fmh1/fmh1ch12.htm
	static $conditions = '';
	static $wxCode = array(
	'VC' => 'Nearby',
	'MI' => 'Shallow',
	'PR' => 'Partial',
	'BC' => 'Patches of',
	'DR' => 'Low Drifting',
	'BL' => 'Blowing',
	'SH' => 'Showers',
	'TS' => 'Thunderstorm',
	'FZ' => 'Freezing',
	'DZ' => 'Drizzle',
	'RA' => 'Rain',
	'SN' => 'Snow',
	'SG' => 'Snow Grains',
	'IC' => 'Ice Crystals',
	'PE' => 'Ice Pellets',
	'GR' => 'Hail',
	'GS' => 'Small Hail',  // and/or snow pellets
	'UP' => 'Unknown',
	'BR' => 'Mist',
	'FG' => 'Fog',
	'FU' => 'Smoke',
	'VA' => 'Volcanic Ash',
	'DU' => 'Widespread Dust',
	'SA' => 'Sand',
	'HZ' => 'Haze',
	'PY' => 'Spray',
	'PO' => 'Well-Developed Dust/Sand Whirls',
	'SQ' => 'Squalls',
	'FC' => 'Funnel Cloud, Tornado, or Waterspout',
	'SS' => 'Sandstorm/Duststorm');
	if (ereg('^(-|\+|VC)?(TS|SH|FZ|BL|DR|MI|BC|PR|RA|DZ|SN|SG|GR|GS|PE|IC|UP|BR|FG|FU|VA|DU|SA|HZ|PY|PO|SQ|FC|SS|DS)+$',$part,$pieces)) {
		if (strlen($conditions) == 0) $join = '';
		else $join = ' &amp; ';
		if (substr($part,0,1) == '-') {
			$prefix = 'light ';
			$part = substr($part,1);
		}
		elseif (substr($part,0,1) == '+') {
			$prefix = 'heavy ';
			$part = substr($part,1);
		}
		else $prefix = '';  // moderate conditions have no descriptor
		$conditions .= $join . $prefix;
		// The 'showers' code 'SH' is moved behind the next 2-letter code to make the English translation read better.
		if (substr($part,0,2) == 'SH') $part = substr($part,2,2) . substr($part,0,2). substr($part, 4);
		while ($code = substr($part,0,2)) {
			$conditions .= $wxCode[$code] . ' ';
			$part = substr($part,2);
		}
		$wxInfo['CONDITIONS'] = $conditions;
		$metarPtr++;
	}
	else {
		$wxInfo['CONDITIONS'] = $conditions;
		$group++;
	}
}

function get_cloud_cover($part, &$metarPtr, &$group, &$wxInfo) {
	// Decodes cloud cover information. This function maybe called several times
	// to decode all cloud layer observations. Only the last layer is saved.
	// Format is SKC or CLR for clear skies, or cccnnn where ccc = 3-letter code and
	// nnn = altitude of cloud layer in hundreds of feet. 'VV' seems to be used for
	// very low cloud layers. (Other conversion factor: 1 m = 3.28084 ft)
	static $cloudCode = array(
	'SKC' => 'Clear Skies',
	'CLR' => 'Clear Skies',
	'FEW' => 'Partly Cloudy',
	'SCT' => 'Scattered Clouds',
	'BKN' => 'Mostly Cloudy',
	'OVC' => 'Overcast',
	'VV'  => 'Vertical Visibility');
	if ($part == 'SKC' || $part == 'CLR') {
		$wxInfo['CLOUDS'] = $cloudCode[$part];
		$metarPtr++;
		$group++;
	}
	else {
		if (ereg('^([A-Z]{2,3})([0-9]{3})',$part,$pieces)) {  // codes for CB and TCU are ignored
			$wxInfo['CLOUDS'] = $cloudCode[$pieces[1]];
			if ($pieces[1] == 'VV') {
				$altitude = (integer) 100 * $pieces[2];  // units are feet
				$wxInfo['CLOUDS'] .= " to $altitude ft";
			}
			$metarPtr++;
		}
		else {
			$group++;
		}
	}
}

function get_temperature($part, &$metarPtr, &$group, &$wxInfo) {
	// Decodes temperature and dew point information. Relative humidity is calculated. Also,
	// depending on the temperature, Heat Index or Wind Chill Temperature is calculated.
	// Format is tt/dd where tt = temperature and dd = dew point temperature. All units are
	// in Celsius. A 'M' preceeding the tt or dd indicates a negative temperature. Some
	// stations do not report dew point, so the format is tt/ or tt/XX.

	function get_heat_index($tempF, $rh, &$wxInfo) {
		// Calculate Heat Index based on temperature in F and relative humidity (65 = 65%)
		if ($tempF > 79 && $rh > 39) {
			$hiF = -42.379 + 2.04901523 * $tempF + 10.14333127 * $rh - 0.22475541 * $tempF * $rh;
			$hiF += -0.00683783 * pow($tempF, 2) - 0.05481717 * pow($rh, 2);
			$hiF += 0.00122874 * pow($tempF, 2) * $rh + 0.00085282 * $tempF * pow($rh, 2);
			$hiF += -0.00000199 * pow($tempF, 2) * pow($rh, 2);
			$hiF = round($hiF);
			$hiC = round(($hiF - 32) / 1.8);
			$wxInfo['HEAT INDEX'] = "$hiF&deg;F";
		}
	}

	function get_wind_chill($tempF, &$wxInfo) {
		// Calculate Wind Chill Temperature based on temperature in F and
		// wind speed in miles per hour
		if ($tempF < 51 && $wxInfo['WIND'] != 'calm') {
			$pieces = explode(' ', $wxInfo['WIND']);
			$windspeed = (integer) $pieces[2];   // wind speed must be in miles per hour
			if ($windspeed > 3) {
				$chillF = 35.74 + 0.6215 * $tempF - 35.75 * pow($windspeed, 0.16) + 0.4275 * $tempF * pow($windspeed, 0.16);
				$chillF = round($chillF);
				$chillC = round(($chillF - 32) / 1.8);
				$wxInfo['WIND CHILL'] = "$chillF&deg;F";
			}
		}
	}

	if (ereg('^(M?[0-9]{2})/(M?[0-9]{2}|[X]{2})?$',$part,$pieces)) {
		$tempC = (integer) strtr($pieces[1], 'M', '-');
		$tempF = round(1.8 * $tempC + 32);
		$wxInfo['TEMP'] = "$tempF&deg;F";
		get_wind_chill($tempF, $wxInfo);
		if (strlen($pieces[2]) != 0 && $pieces[2] != 'XX') {
			$dewC = (integer) strtr($pieces[2], 'M', '-');
			$dewF = round(1.8 * $dewC + 32);
			$wxInfo['DEWPT'] = "$dewF&deg;F";
			$rh = round(100 * pow((112 - (0.1 * $tempC) + $dewC) / (112 + (0.9 * $tempC)), 8));
			$wxInfo['HUMIDITY'] = $rh . '%';
			get_heat_index($tempF, $rh, $wxInfo);
		}
		$metarPtr++;
		$group++;
	}
	else {
		$group++;
	}
}

function get_altimeter($part, &$metarPtr, &$group, &$wxInfo) {
	// Decodes altimeter or barometer information.
	// Format is Annnn where nnnn represents a real number as nn.nn in inches of Hg,
	// or Qpppp where pppp = hectoPascals.
	// Some other common conversion factors:
	//   1 millibar = 1 hPa
	//   1 in Hg = 0.02953 hPa
	//   1 mm Hg = 25.4 in Hg = 0.750062 hPa
	//   1 lb/sq in = 0.491154 in Hg = 0.014504 hPa
	//   1 atm = 0.33421 in Hg = 0.0009869 hPa
	if (ereg('^(A|Q)([0-9]{4})',$part,$pieces)) {
		if ($pieces[1] == 'A') {
			$pressureIN = substr($pieces[2],0,2) . '.' . substr($pieces[2],2);  // units are inches Hg
			$pressureHPA = round($pressureIN / 0.02953);                        // convert to hectoPascals
		}
		else {
			$pressureHPA = (integer) $pieces[2];              // units are hectoPascals
			$pressureIN = round(0.02953 * $pressureHPA,2);    // convert to inches Hg
		}
		$wxInfo['BAROMETER'] = "$pressureHPA hPa ($pressureIN in Hg)";
		$metarPtr++;
		$group++;
	}
	else {
		$group++;
	}
}

function print_wxInfo($wxInfo) {
	// Prints each piece of information stored in the array.
	// If an error occurs in retrieving a METAR file, check for index called 'ERROR'.
	// (Modify this function to fit your needs.)
	//$dots = '...............';

	include_once("common.inc");
	connect_to();
	$icao = $wxInfo['STATION'];
	$sql0 = "SELECT `Location` FROM `ICAO` WHERE `ICAO` = '$icao'";
	$selectResult0 = mysql_query($sql0);
	$resultRow0 = mysql_fetch_array($selectResult0);
	$location = $resultRow0["Location"];
	echo( "Currently at $location: ".$wxInfo['TEMP']." ".$wxInfo['CLOUDS']." ".$wxInfo['CONDITIONS'] );
	/*
	foreach($wxInfo As $wxIndex => $wx)
	{
	if (strlen($wx) != 0) echo $wxIndex . substr($dots,0,strlen($dots)-strlen($wxIndex)) . " $wx<BR>\n";
	}
	*/
}
?>