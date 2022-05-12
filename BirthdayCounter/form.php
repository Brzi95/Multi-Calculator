<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<h1 style = color:blue; >Birthday Counter !</h1>
<h3>Please enter your birthday!</h3><br><br>

<form action="birthdayCounterPage.php" method="post">
    <input type="number" name='year' placeholder='1987'><br>
    <input type="number" name='month' placeholder='12'><br>
    <input type="number" name='day' placeholder='31'><br><br>

    <input type="submit" name="submit_button" value="Submit"/><br><br>
</form>

<p>Current time and date:</p>

<!-- atribute required HTML -->

<?php

date_default_timezone_set("Europe/Belgrade");
echo date("H:i:s"). "<br>";
echo date("d/M/Y"). "<br><br>";

$birthday = date_create("1995-10-06 18:23:42");
$date = date('Y-m-d H:i:s', time());
$currentDate = date_create($date);


?>

    
</body>
</html>