<?php

include 'AgeCalculator.php';

// za domaci
// ??
// ?:
// asocijativni nizovi
// [ 'key' => 'value' ]

// if $_POST proveravamo da li je submit uopste kliknut... dakle, ako nije, tj kada otvorimo page, nece biti nikakvi errori prikazani, a kada kliknemo, bice poznava funkcija calcMethod

if ($_POST) {
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    
    $ageCalculator = new AgeCalculator($year, $month, $day, $hour, $minute);
    echo $ageCalculator->calcMethod();
} else {
    echo "HOW OLD ARE YOU ???";
}


?>
