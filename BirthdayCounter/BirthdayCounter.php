<?php

class BirthdayCounter {
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
        $date = date('Y-m-d H:i:s');
        $currentDate = date_create($date);

        if ($this->year == '' || $this->month == '' || $this->day == '') {
            echo "Year, month and day are must fields!";
        } elseif ($this->year < 1900 || $this->year > 2022) {
            echo $this->year. " ?? Enter the year between 1900 and 2022!";
        } elseif ($this->month < 1 || $this->month > 12) {
            echo $this->month. " ?? Enter the month again!";
        } elseif ($this->day < 1 || $this->day > 31) {
            echo $this->day. " ?? Enter the day again!";
        } else {
            $birthday = date_create("$this->day-$this->month-$this->year");
            $diff = $birthday->diff($currentDate);
            $yearsMonthsDays = $diff->y. ' years '. $diff->m. ' months '. $diff->d. ' days';
            $nextBirthday0 = date("Y-$this->month-$this->day H:i");
            $nextBirthday = date_create($nextBirthday0);
            $diffNext = $currentDate->diff($nextBirthday);
            $years = "You'll be ". ($diff->y+1). " years old";
            $l_date = date("l", mktime(0,0,0,$this->month, $this->day,$this->year));
            $l_day_echo = "In case you didn't know, you were born on a ". $l_date;
                    if ($this->hour == '' && $this->minute== '') {
                    echo "$diffNext->m months and $diffNext->d days left till your birthday! <br> $years";
                    $l_day_echo. "<br>";
                        } elseif ($this->hour == '' && !($this->minute== '')) {
                            echo "Hours are required if you enter the minutes!";
                        } elseif (!($this->hour == '') && !($this->minute == '')) {
                            if($this->minute < 0 || $this->minute > 59) {
                                echo $this->minute. " ?? Enter the minutes again! ";
                            } elseif($this->hour < 0 || $this->hour > 23) {
                                echo $this->hour. " ?? Enter the hours again! ";
                            } else {
                                $birthday = date_create("$this->day-$this->month-$this->year $this->hour:$this->minute");
                                $diff = $birthday->diff($currentDate);
                                $hours = $diff->h. ' hours ';
                                $minutes = $diff->i. ' minutes ';
                                echo $yearsMonthsDays. "<br>".
                                $hours. $minutes. "<br>".
                                $l_day_echo;
                        }
                        
                    } elseif (!($this->hour == '') && $this->minute == '') {
                        if($this->hour < 0 || $this->hour > 23) {
                            echo $this->hour. " ?? Enter the hours again! ";
                        } else {
                        $birthday = date_create("$this->day-$this->month-$this->year $this->hour:00");
                        $diff = $birthday->diff($currentDate);
                        $hours = $diff->h. ' hours ';
                        echo $yearsMonthsDays. "<br>".
                        $hours. "<br>".
                        $l_day_echo;
                    } 
                }
            }
        }
    }