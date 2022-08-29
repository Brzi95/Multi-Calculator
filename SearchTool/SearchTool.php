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
        $subtring_length = $search_length;
        $count = 0;

        for ($start_point = 0; $start_point < $text_length; $start_point++) {
            $subtring_from_string = strtolower(substr($this->text, $start_point, $subtring_length));
            if ($subtring_from_string == strtolower($this->search_for)) {
                $count += 1;
            }
        }
        echo "There are $count <span>$this->search_for</span>'s in the following text: <br><br>";
        for ($i = 0; $i < $text_length; $i++) { 
            if (substr($this->text, $i, $subtring_length) == $this->search_for) {
                echo "<span>". substr($this->text, $i, $subtring_length) . "</span>";
            } else {
                echo substr($this->text, $i, 1);
            }
        }    

        echo "<br><br>";

        $words = str_word_count($this->text, 1);
        $num_of_words = str_word_count($this->text);

        if ($search_length < 2) {
            echo "<br> Words that contain character '$this->search_for' are: <br>";
        } else {
            echo "<br>'$this->search_for' appears $count times: <br>";
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
                if ($count_searched_char_in_single_word > 1) {
                    echo '. ';
                    for ($char = 0; $char < $word_length; $char++) {
                        if (substr($word, $char, $subtring_length) == $this->search_for) {
                            echo "<span>" . substr($word, $char, 1) . "</span>";
                        } else {
                            echo substr($word, $char, 1);
                        }
                    }
                    echo " ($count_searched_char_in_single_word". 'x)';
                    echo "<br>";
                } else {
                    echo '. ';
                    for ($char = 0; $char < $word_length; $char++) {
                        if (substr($word, $char, $subtring_length) == $this->search_for) {
                            echo "<span>" . substr($word, $char, 1) . "</span>";
                        } else {
                            echo substr($word, $char, 1);
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

