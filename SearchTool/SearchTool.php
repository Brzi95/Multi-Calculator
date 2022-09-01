<?php

class SearchTool {
    protected $search_for;
    protected $text;

    function __construct($search_for, $text) {
        $this->search_for = $search_for;
        $this->text = $text;
    }

    function calcMethod() {
        $text_length = strlen($this->text);
        $search_length = strlen($this->search_for);
        $substring_length = $search_length;
        $count = 0;

        for ($start_point = 0; $start_point < $text_length; $start_point++) {
            $subtring_from_string = strtolower(substr($this->text, $start_point, $substring_length));
            if ($subtring_from_string == strtolower($this->search_for)) {
                $count += 1;
            }
        }
        // message how many characters in text
        echo "There are $count <span>$this->search_for</span>'s in the following text: <br><br>";
        for ($i = 0; $i < $text_length; $i++) { 
            if (substr($this->text, $i, $substring_length) == $this->search_for) {
                echo "<span>". substr($this->text, $i, $substring_length) . "</span>";
                $i += $substring_length -1;
            } else {
                echo substr($this->text, $i, 1);
            }
        }    

        echo "<br><br>";

        $words = str_word_count($this->text, 1);
        $num_of_words = str_word_count($this->text);

        if ($search_length < 2) { // if one single character is searched
            echo "<br> Words that contain character '$this->search_for' are: <br>";
        } else {
            echo "<br>'<span>$this->search_for</span>' appears $count times: <br>";
        }

        $row_count = 0;
        $count_searched_char_in_single_word = 0;
        foreach ($words as $word) {
            $word_length = strlen($word);
            $substring_length = strlen($this->search_for);
            if (str_contains(strtolower($word), strtolower($this->search_for))) {
                echo $row_count += 1;
                for ($start_point = 0; $start_point < $word_length; $start_point++) {
                    $subtring_from_word = strtolower(substr($word, $start_point, $substring_length));
                    if ($subtring_from_word == strtolower($this->search_for)) {
                        $count_searched_char_in_single_word += 1;
                    }
                }
                if ($count_searched_char_in_single_word > 1) { // in this case the counter will be printed
                    echo '. ';
                    for ($i = 0; $i < $word_length; $i++) {
                        if (substr($word, $i, $substring_length) == $this->search_for) {
                            echo "<span>" . substr($word, $i + $substring_length - 1, $substring_length) . "</span>";
                        } else {
                            echo substr($word, $i, 1);
                        }
                    }
                    echo " ($count_searched_char_in_single_word". 'x)'; // counter
                    echo "<br>";
                } else {
                    echo '. ';
                    for ($i = 0; $i < $word_length; $i++) {
                        if (substr($word, $i, $substring_length) == $this->search_for) {
                            echo "<span>" . substr($word, $i, $substring_length) . "</span>";
                        } else {
                            echo substr($word, $i + $substring_length - 1, 1);
                        }
                    }
                    echo "<br>";
                }
            }
            $count_searched_char_in_single_word = 0; // reseting the counter so that counting for the next word starts from zero again
        }

        }
    }
//  . " ($count_searched_char_in_single_word". 'x)'

/*

echo "<span style='margin:0; color:black; background-color: yellow; width:fit-content;'>" . substr($word, $char, 1) . "</span>";

*/

