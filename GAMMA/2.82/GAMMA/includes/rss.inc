<?php
class GAMMA_RSS
{
	var $rss_data;

	function fetch($host, $location)
	{
		$this->rss_data = "";
		//Caching (we want to update the cache every 15 minutes)
		$md5 = md5($host.$location);
		$filename = getcwd()."/cache/RSS_$md5.cache";
		$now = date("YmdGis",mktime(date("G"),date("i"),date("s"),date("m"),date("d"),date("Y")));
		$fifteenAgo = date("YmdGis",mktime(date("G"),date("i")-15,date("s"),date("m"),date("d"),date("Y")));

		//Does the file exist?
		if(!file_exists($filename))
		{
			//echo( "FILE DID NOT EXIST<br>" );
			//No.  Create file, get contents
			$this->http_request($host, $location);
			$fh = fopen($filename, 'w');
			fputs($fh, $now);
			fputs($fh, "\r\n");
			fputs($fh, $this->rss_data);
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
				$this->http_request($host, $location);
				$fh = fopen($filename, 'w');
				fputs($fh, $now);
				fputs($fh, "\r\n");
				fputs($fh, $this->rss_data);
				fclose($fh);
			}
			else
			{
				//echo( "FILE WAS CURRENT<br>" );
				//No, its current.  Lets read the cache into memory
				$fh = fopen($filename, 'r');
				$readTo = filesize($filename);
				$this->rss_data = fread($fh, $readTo);
				fclose($fh);
			}
		}
	}

	function http_request($host, $location)
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

		if ($fp)
		{
			fputs($fp, $request);
			while($output = fgets($fp))
			{
				$this->rss_data .= $output;
			}
		}
	}

	function display($append, $annex)
	{
		include_once("common.inc");

		$rss_title = "";
		$rss_items = "";
		$rdf = false;
		$rss = false;

		$rss_title = return_xml($this->rss_data, "title");
		
		if(stristr($this->rss_data, "<rdf") != "")
		{
			$rdf = true;
		}
		else
		{
			$rss = true;
		}
		
		//this is where we need to make a distinction between RSS and RDF
		if($rss)
		{
			$rss_items = return_xml_array($this->rss_data, "item");

			if(count($rss_items) == 0)
			{
				echo( "No items could be found for $rss_title.  Host returned:<br>" );
				echo( $this->rss_data."<br>" );
			}
		}
		elseif($rdf)
		{
			$haystack = $this->rss_data;
			$i = 0;
			$first = true;

			do
			{
				//make sure we start with 0
				if(!$first)
				{
					$i++;
				}
				$haystack = stristr($haystack, "<item rdf:about");
				$goodLen = strlen($haystack) - strlen(stristr($haystack, "</item>"));
				$haystack = strtrunc_array($haystack, $goodLen);
				$goodLen = strlen($haystack[0]) - strlen("<$needle>");
				$returnstack[$i] = strrev(strtrunc(strrev($haystack[0]), $goodLen));
				$haystack = $haystack[1];
				$first = false;
			}while ($returnstack[$i] != "");
			unset($returnstack[$i]);
			
			$rss_items = $returnstack;
		}
		else
		{
			echo( "Could not determine feed type" );
		}

		foreach($rss_items as $item)
		{
			$link = return_xml($item, "link");
			$title = return_xml($item, "title");

			$title = dequote($title);
			if(strlen($title) > 100 || strlen($link) > 100)
			{
				$title = "";
				$link = "";
			}

			if($title != "" && $title[0] != "<")
			{
				if($append == "myScroller1.addItem(\"")
				{
					echo( "$append$rss_title: <a href=\'$link\' target=\'_new\'>$title</a>$annex" );
				}
				else
				{
					echo( "$append$rss_title: <a href=\"$link\" target=\"_new\">$title</a>$annex" );
				}
			}
		}
	}
}
?>