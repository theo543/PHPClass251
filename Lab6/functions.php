<?php
function get_weather_data($location) {
    $api_geocoding = "https://geocoding-api.open-meteo.com/v1/search?name=" . urlencode($location) . "&count=1&language=rp&format=json";
    $geocoding_json = json_decode(file_get_contents($api_geocoding), true);
    if((!isset($geocoding_json["results"])) || (count($geocoding_json["results"]) == 0)) {
        return false;
    }
    $geocoding_json = $geocoding_json["results"][0];
    $name = $geocoding_json["name"];
    $api_forecast  = "https://api.open-meteo.com/v1/forecast?latitude=" . $geocoding_json["latitude"] . "&longitude=" . urlencode($geocoding_json["longitude"]) . "&current=temperature_2m,apparent_temperature,rain";
    $forecast_json = json_decode(file_get_contents($api_forecast), true);
    return array("name"=>$name, "weather_json"=>$forecast_json);
}

function render_weather_data($data, $varname, $name) {
    $value = $data["current"][$varname];
    $value_units = $data["current_units"][$varname];
    ?>
    <div class="weather_info">
        <span class="weather_name"><?= $name ?>:</span> <span class="weather_value"><?= $value ?> <?= $value_units ?></span>
    </div>
    <?php
}
