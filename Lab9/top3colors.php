<?php

if(!(php_sapi_name() == "cli" && isset($argv[1]) && isset($argv[2]))) {
    echo "Program must be run from CLI. Usage: php top3colors.php <input.png> <output.png>\n";
    exit(1);
}
$filename = $argv[1];
$output = $argv[2];
$img = imagecreatefrompng($filename);
if($img === false) {
    echo "Unable to open image\n";
    exit(1);
}

$width = imagesx($img);
$height = imagesy($img);
$colors = array();
for($i = 0; $i < $width; $i++) {
    for($j = 0; $j < $height; $j++) {
        $pixel = imagecolorsforindex($img, imagecolorat($img, $i, $j));
        $pixel = ($pixel['red'] << 16) | ($pixel['green'] << 8) | $pixel['blue'];
        if(isset($colors[$pixel])) {
            $colors[$pixel]++;
        } else {
            $colors[$pixel] = 1;
        }
    }
}
arsort($colors);

const scaling = 60;
function reduce_rgb_precision($rgb) {
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    $r = intdiv($r, scaling) * scaling;
    $g = intdiv($g, scaling) * scaling;
    $b = intdiv($b, scaling) * scaling;
    return ($r << 16) | ($g << 8) | $b;
}

$colors_picked = array();
foreach($colors as $rgb => $count) {
    $rgb = reduce_rgb_precision($rgb);
    if(!isset($colors_picked[$rgb])) {
        array_push($colors_picked, $rgb);
    }
    if(count($colors_picked) == 3) {
        break;
    }
}

$alloc_color = function($rgb) use(&$img) {
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    return imagecolorallocate($img, $r, $g, $b);
};

$img = imagecreatetruecolor(100, 300);
$c1 = $alloc_color($colors_picked[0]);
$c2 = $alloc_color($colors_picked[1]);
$c3 = $alloc_color($colors_picked[2]);
imagefilledrectangle($img, 0, 0, 100, 100, $c1);
imagefilledrectangle($img, 0, 100, 100, 200, $c2);
imagefilledrectangle($img, 0, 200, 100, 300, $c3);
imagepng($img, $output);
imagedestroy($img);
