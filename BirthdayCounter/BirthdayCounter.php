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
            return false;
        } elseif (!in_array($this->year, range(1900, 2022))) {
            echo $this->year. " ?? Enter the year between 1900 and 2022!";
            return false;
        } elseif (!in_array($this->month, range(1, 12))) {
            echo $this->month. " ?? Enter the month again!";
            return false;
        } elseif (!in_array($this->day, range(1, 31))) {
            echo $this->day. " ?? Enter the day again!";
            return false;
        }

        $birthday = date_create("$this->day-$this->month-$this->year");
        $diff = $birthday->diff($currentDate);
        $nextBirthday0 = date("Y-$this->month-$this->day H:i");
        $nextBirthday = date_create($nextBirthday0);
        $diffNext = $currentDate->diff($nextBirthday);

        if ($diffNext->m == 0 && $diffNext->d == 0) {
            echo "Happy birthday! Congratulations to your ". ($diff->y) . " birthday!";
        } elseif ($diffNext->m !== 0 && $diffNext->d !== 0) {
            echo "$diffNext->m months and ". ($diffNext->d+1). " days left till your birthday! <br> You'll be ". ($diff->y+1). " years old";
        }
        elseif ($diffNext->m == 0 && $diffNext->d > 0) {
            echo ($diffNext->d). " days left till your birthday! <br> You'll be ". ($diff->y+1). " years old";
        }
    }
}

?>
