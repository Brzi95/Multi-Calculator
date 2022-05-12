<?php

class BirthdayCounter {
    protected $year;
    protected $month;
    protected $day;

    function __construct($year, $month, $day) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
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
                    echo "$diffNext->m months and ". ($diffNext->d+1). " days left till your birthday! <br> $years";
        }
    }
}