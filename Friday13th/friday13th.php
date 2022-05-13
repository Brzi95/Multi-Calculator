<?php

class Friday13thCalculator {
    protected $startYear;
    protected $endYear;

    function __construct ($startYear, $endYear) {
        $this->startYear = $startYear;
        $this->endYear = $endYear;
    }

    function calcMethod() {
        if ($this->startYear > 999 && $this->endYear > 999) {
            for($year = $this->startYear; $year <= $this->endYear; $year++) {
                for($month = 1; $month <= 12; $month++) {
                    $date = date_create("$year-$month-01");
                    $_13th = date_format($date, '13/M/Y');
                    $l_day = date('l', mktime(0,0,0,$month,13,$year)); 
                        if($l_day == 'Friday') {
                        echo $l_day. " the ". $_13th. " ". "<br>";
                        }
                }
                echo "<br>";
            }
        } else {
            echo "Please enter years from 1000 and above!";
        }
    }
}


?>

