<?php

class AgeCalculator {
    protected $year;
    protected $month;
    protected $day;
    protected $hour;
    protected $minute;

    function __construct($year, $month, $day, $hour, $minute) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
    }

    function calcMethod() {
        date_default_timezone_set("Europe/Belgrade");
        $date = date('Y-m-d H:i:s'); // string type date
        $currentDate = date_create($date); // DateTime type date, the type that is needed for the diff function
        $_hour = $this->hour === '' ? '0' : $this->hour;
        $_minute = $this->minute === '' ? '0' : $this->minute;

        if ($this->year == '' || $this->month == '' || $this->day == '') {
            echo "Year, month and day are must fields!";
            return false;
        } elseif (!in_array($this->year, range(1900, date("Y")))) {
            echo $this->year. " ?? Enter the year between 1900 and 2022!";
            return false;
        } elseif (!in_array($this->month, range(1, 12))) {
            echo $this->month. " ?? Enter the month again!";
            return false;
        } elseif (!in_array($this->day, range(1, 31))) {
            echo $this->day. " ?? Enter the day again!";
            return false;
        } elseif (!in_array($_hour, range(0, 23))) {
            echo $_hour. " ?? Enter the hours again!";
            return false;
        } elseif (!in_array($_minute, range(0, 59))) {
            echo $_minute. " ?? Enter the minutes again!";
            return false;
        }

        $birthday = date_create("$this->day-$this->month-$this->year $_hour:$_minute");
        $diff = $birthday->diff($currentDate);
        $yearsMonthsDays = $diff->y. ' years '. $diff->m. ' months '. $diff->d. ' days';
        $hours = $diff->h. ' hours ';
        $minutes = $diff->i. ' minutes ';
        $l_date = date("l", mktime(0,0,0,$this->month, $this->day,$this->year));
        $l_day_echo = "In case you didn't know, you were born on a ". $l_date;

        if ($this->hour == '' && $this->minute == '') {
            if ($this->month == date("m") && $this->day == date("d")) {
                echo "HAPPY BIRTHDAY!!! YOU TURNED " . date("Y")-$this->year . " TODAY! :)";
            } else {
                echo $yearsMonthsDays. "<br>".
                $l_day_echo. "<br>";
            }
        } elseif ($this->hour == '' && $this->minute !== '') {
            echo "Hours are required if you enter the minutes!";
        } else { 
            if ($this->hour !== '' && $this->minute == '') {
                echo $yearsMonthsDays. "<br>".
                $hours. "<br>".
                $l_day_echo;
            } elseif ($this->hour !== '' && $this->minute !== '') {
                echo $yearsMonthsDays. "<br>".
                $hours. $minutes. "<br>".
                $l_day_echo;
            } 
        }
    }
}


?>
