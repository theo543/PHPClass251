<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Weather</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="weather_box">
        <?php
            function handle_form_submit() {
                require(dirname(__FILE__) . "/functions.php");
                if(!isset($_GET["search"])) {
                    echo "Niciun rezultat.";
                    return;
                }
                $weather_data = get_weather_data($_GET["search"]);
                if($weather_data === false) {
                    echo "Niciun rezultat.";
                    return;
                }
                $name = $weather_data["name"];
                $weather_json = $weather_data["weather_json"];
                ?><span class="weather_city"><?= $name ?></span><?php
                render_weather_data($weather_json, "temperature_2m", "Temperatură");
                render_weather_data($weather_json, "apparent_temperature", "Temperatură Aparentă");
                render_weather_data($weather_json, "rain", "Ploaie");
            }
            handle_form_submit();
        ?>
        <a href="../Lab6" class="back">Back</a>
    </div>
</body>
