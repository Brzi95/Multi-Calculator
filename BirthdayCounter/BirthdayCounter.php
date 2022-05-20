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
        } elseif (!in_array($this->year, range(1900, date("Y")))) {
            echo $this->year. " ?? Enter the year between 1900 and 2022!";
            return false;
        } elseif (!in_array($this->month, range(1, 12))) {
            echo $this->month. " ?? Enter the month again!";
            return false;
        } elseif (!in_array($this->day, range(1, 31))) {
            echo $this->day. " ?? Enter the day again!";
            return false;
        }

        $birthday = date_create("$this->year-$this->month-$this->day");
        $diff_CurrentDate = $birthday->diff($currentDate);
        $nextBirthday_0 = date("Y-$this->month-$this->day H:i");
        $nextBirthday_CurrentYear = date_create($nextBirthday_0);
        $diff_Next_CurrentYear = $currentDate->diff($nextBirthday_CurrentYear);

        $nextYear = date("Y") + 1;
        $nextBirthday_1 = date("$nextYear-$this->month-$this->day H:i");
        $nextBirthday_NextYear = date_create($nextBirthday_1);
        $diff_Next_NextYear = $currentDate->diff($nextBirthday_NextYear);
        $age = date("Y") - $this->year;

        if (date("m") < $this->month) {
            echo $diff_Next_CurrentYear->m . ' months and ' . $diff_Next_CurrentYear->d+1 . ' days left till your birthday! <br>
            You turn ' . $age . '!';
        } elseif (date("m") > $this->month) {
            echo $diff_Next_NextYear->m . ' months and ' . $diff_Next_NextYear->d+1 . ' days left till your birthday! <br>
            You turn ' . $age+1 . '!'; 
        } else {
            if (date("d") < $this->day) {
                echo $diff_Next_CurrentYear->m . ' months and ' . $diff_Next_CurrentYear->d+1 . ' days left till your birthday! <br>
                You turn ' . $age . '!';
            } elseif (date("d") > $this->day) {
                echo $diff_Next_NextYear->m . ' months and ' . $diff_Next_NextYear->d . ' days left till your birthday! <br>
                You turn ' . $age+1 . '!'; 
            } else {
                echo "HAPPY BIRTHDAY!!! YOU TURNED " . $age . " TODAY! :)";
            }
        }
    }
}


?>
