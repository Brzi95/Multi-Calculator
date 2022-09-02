<?php

include 'Friday13th.php';

if ($_POST) {
    $day_week = $_POST['day_week'];
    $day_num = $_POST['day_num'];
    $year1 = $_POST['year1'];
    $year2 = $_POST['year2'];
    
    $friday13thCalculator = new Friday13thCalculator($day_week, $day_num, $year1, $year2);
    echo $friday13thCalculator->calcMethod();
} else {
    echo "How many Fridays the 13th exist in 2020?";
}


?>
