<?php

class Friday13thCalculator {
    protected $day_week;
    protected $day_num;
    protected $year1;
    protected $year2;

    function __construct ($day_week, $day_num, $year1, $year2) {
        $this->day_week = $day_week;
        $this->day_num = $day_num;
        $this->year1 = $year1;
        $this->year2 = $year2;
    }

    function calcMethod() {
        $counter = 0;
        if ($year1 <= $year2) {
            for($year = $this->year1; $year <= $this->year2; $year++) {
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
        }
    }
}


?>

