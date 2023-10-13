<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> PHP Form (Lab 2) </title>
</head>
<body>
    <form method="get" action="response.php" target="_blank">
        <p>
            <label>Year: <input name="year" type="number" min="1900" max="<?=date("Y")?>"></label>
            <label>Month: <input name="month" type="number" min="1" max="12"></label>
            <label>Day: <input name="day" type="number" min="1" max="31"></label>
        </p>
        <p>
            <input type="submit" value="Submit">
        </p>
    </form>
</body>
</html>
