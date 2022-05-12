<?php

include 'BirthdayCounter.php';

if ($_POST) {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    
    $birthdayCounter = new BirthdayCounter($year, $month, $day);
    echo $birthdayCounter->calcMethod();
} else {
    echo "HOW MUCH TIME IS LEFT TILL YOUR BIRTHDAY ???";
}


?>