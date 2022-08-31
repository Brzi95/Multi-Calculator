<?php

include 'Friday13th.php';

if ($_POST) {
    $day_week = $_POST['day_week'];
    $day_num = $_POST['day_num'];
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    
    $friday13thCalculator = new Friday13thCalculator($day_week, $day_num, $start_year, $end_year);
    echo $friday13thCalculator->calcMethod();
} else {
    echo "How many Fridays the 13th exist in 2020?";
}


?>
