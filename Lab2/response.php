<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Form Response (Lab 2) </title>
</head>
<body>
    <p>
        <?php
            $err = false;
            $get_int = function(string $name, int $min, int $max) use(&$err) {
                $result = filter_input(INPUT_GET, $name, FILTER_VALIDATE_INT);
                if($result === false || $result === null || $result < $min || $result > $max) {
                    $err = true;
                }
                return $result;
            };
            $day = $get_int("day", 1, 31);
            $month = $get_int("month", 1, 12);
            $year = $get_int("year", 1900, date('Y'));
            if($err) {
                echo "Invalid date.";
            } else {
                $date = DateTimeImmutable::createFromFormat("!Y-m-j", "$year-$month-$day");
                $current = new DateTimeImmutable();
                $interval = $date->diff($current);
                echo $interval->format("Born %Y years, %M months and %D days ago.");
            }
        ?>
    </p>
</body>
</html>
