<?php

class Friday13thCalculator {
    protected $day_week;
    protected $day_num;
    protected $start_year;
    protected $end_year;

    function __construct ($day_week, $day_num, $start_year, $end_year) {
        $this->day_week = $day_week;
        $this->day_num = $day_num;
        $this->start_year = $start_year;
        $this->end_year = $end_year;
    }

    function calcMethod() {
        $counter = 0;
        if ($this->start_year > 999 && $this->end_year > 999) {
            for($year = $this->start_year; $year <= $this->end_year; $year++) {
                for($month = 1; $month <= 12; $month++) {
                    $date = date_create("$year-$month-$this->day_num");
                    $x_th = date_format($date, "$this->day_num/M/Y");
                    $l_day = date('l', mktime(0,0,0,$month,$this->day_num,$year)); 
                        if($l_day == $this->day_week) {
                        echo $l_day. " the ". $x_th. " ". "<br>";
                        $counter += 1;
                        }
                }
                echo $counter . "x $this->day_week" . "s in $year" . "<br>";
                $counter = 0;
                echo "<br>";
            }
        } else {
            echo "Please enter years from 1000 and above!";
        }
    }
}


?>

