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
        $date = date('Y-m-d H:i');
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

        $birthday = date_create("$this->year-$this->month-$this->day H:i");
        $diff = $birthday->diff($currentDate);

        $nextBirthday_0 = date("Y-$this->month-$this->day H:i");
        $nextBirthday_CurrentYear = date_create($nextBirthday_0);
        $diffNext_CurrentYear = $currentDate->diff($nextBirthday_CurrentYear);

        $nextYear = date("Y") + 1;
        $nextBirthday_1 = date("$nextYear-$this->month-$this->day H:i");
        $nextBirthday_NextYear = date_create($nextBirthday_1);
        $diffNext_NextYear = $currentDate->diff($nextBirthday_NextYear);
        $age = date("Y") - $this->year;

        if ($diffNext->m > 0) {
            if ($diffNext->d == 0) {
                echo "$diffNext->m months left till your birthday! <br> 
                You'll be ". $age. " years old";
            } else {
                echo "$diffNext->m months and ". ($diffNext->d). " days left till your birthday! <br> 
                You'll be ". $age. " years old";
            }
        }
        elseif ($diffNext->m == 0) {
            if ($diffNext->d > 0) {
                echo ($diffNext->d). " days left till your birthday! <br> 
                You'll be ". $age. " years old --diff->m /---->>". ($diff->m). ' '. ($diffNext->m). $nextYear;
            } elseif ($diffNext->d == 0) {
                echo "HAPPY BIRTHDAY!!! <br> 
                We wish you all the best for your ". $age. '.'. " birthday! <br>
                $diff->m ". " $diffNext->m";                
            }
        }
    }
}

?>
