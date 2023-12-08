<?php
//ini_set('display_errors', 1);

function getPageContents($url) {
        $user_agent='Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/118.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

 

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

 

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;
        return $header;
}

 

function accuweather_id($oras) {
    $oras = strtolower($oras);
    $header = getPageContents("https://www.accuweather.com/en/search-locations?query=$oras");
    $html = $header['content'];
	
	libxml_use_internal_errors(true);
    //echo htmlspecialchars($html);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $finder = new DomXPath($doc);
    $titlu = $finder->query("/html/head/title")[0];
    if (str_contains($titlu->nodeValue,"Find Your Location")) {
        
		$sursa=explode("search-results-heading",$html);
		$rezultat_search=explode('/web-api/three-day-redirect?key=',$sursa[1]);
		$key=explode('&',$rezultat_search[1]);
		return $key[0];
    } else {
		print_r('Sunt in else!');
        $node = $finder->query("/html/head/meta[13]")[0];
        $url = $node->getAttribute("content");
        $toks = explode("/", $url);
        return (int) $toks[count($toks) - 1];
		// return 286942;
    }

 

}

function accuweather_weather($oras, $id) {
	$oras = strtolower($oras);
	print_r(strtoupper($oras).' -> '.$id.' vremea in urmatoarele zile:<br/>');
    $header = getPageContents('https://www.accuweather.com/en/ro/'.$oras.'/'.$id.'/daily-weather-forecast/'.$id);
    $html = $header['content'];
	libxml_use_internal_errors(true);
    //echo htmlspecialchars($html);
    $content_zile=explode('<a class="daily-forecast-card',$html);

for ($z=1;$z<count($content_zile);$z++)
{
    $tag_vreme=explode('<div class="info">',$content_zile[$z]);
	$tag_zi=explode('<div class="precip">','<div class="info">'.$tag_vreme[1]);
    print_r($tag_zi[0]);
}


}

$localitate='Arad';
$id=accuweather_id($localitate);
accuweather_weather($localitate,$id);
 

?>