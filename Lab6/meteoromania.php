<?php
$url = "https://www.meteoromania.ro/vremea/prognoza-meteo/";
$page = file_get_contents($url);
$regex = "#<li id=\".*?\" style=\"width:275px; float: left; display: block\">.*?</li>#";
$matches = null;
preg_match_all($regex, $page, $matches);
$matches = $matches[0];
foreach($matches as $key => $value) {
    $get_match = function($pattern, $default = "NOT FOUND") use($value) {
        $local_matches = null;
        if(preg_match($pattern, $value, $local_matches) == false) {
            return $default;
        }
        return $local_matches[1];
    };
    $name = $get_match("#li id=\"(.*?)\" style#");
    $temperature = $get_match("#</b>:(.*?)C#") . "C";
    $fenomen = $get_match("#Fenomen</b>.*?: (.*?)<br>#", "Niciun fenomen");
    ?>
    <p><?=$name?> => <?=$temperature?> (<?=$fenomen?>)</p>
    <?php
}
