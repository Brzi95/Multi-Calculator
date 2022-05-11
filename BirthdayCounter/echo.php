<?php

include 'BirthdayCounter.php';

if ($_POST) {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    
    $birthdayCounter = new BirthdayCounter($year, $month, $day, $hour, $minute);
    echo $birthdayCounter->calcMethod();
} else {
    echo "HOW MUCH TIME IS LEFT TILL YOUR BIRTHDAY ???";
}


?>