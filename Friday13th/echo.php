<?php

include 'friday13th.php';

if ($_POST) {
    $startYear = $_POST['startYear'];
    $endYear = $_POST['endYear'];
    
    $friday13thCalculator = new Friday13thCalculator($startYear, $endYear);
    echo $friday13thCalculator->calcMethod();
} else {
    echo "How many Fridays the 13th are there?";
}


?>