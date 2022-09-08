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
        $count = 0;

        for ($start_point = 0; $start_point < $text_length; $start_point++) {
            $subtring_from_string = strtolower(substr($this->text, $start_point, $search_length));
            if ($subtring_from_string == strtolower($this->search_for)) {
                $count += 1;
            }
        }
        // message how many characters in text
        echo "There are $count <span>$this->search_for</span>'s in the following text: <br><br>";
        for ($i = 0; $i < $text_length; $i++) { 
            if (strtolower(substr($this->text, $i, $search_length)) == strtolower($this->search_for)) {
                echo "<span>". substr($this->text, $i, $search_length) . "</span>";
                $i += $search_length -1;
            } else {
                echo substr($this->text, $i, 1);
            }
        }

        echo "<br><br>";

        $words = str_word_count($this->text, 1);
        $num_of_words = str_word_count($this->text);

        echo "Text contains " . '<b>' . str_word_count($this->text) . '</b>' . " words.";
        if ($search_length < 2) { // if one single character is searched
            echo "<br> Words that contain character '$this->search_for' are: <br>";
        } else {
            echo "<br>'<span>$this->search_for</span>' appears $count times: <br>";
        }

        $row_count = 1;
        $count_searched_char_in_single_word = 0;
        foreach ($words as $word) {
            $word_length = strlen($word);
            $search_length = strlen($this->search_for);
            if (str_contains(strtolower($word), strtolower($this->search_for))) {
                echo $row_count++ . '. ';
                for ($start_point = 0; $start_point < $word_length; $start_point++) {
                    $subtring_from_word = strtolower(substr($word, $start_point, $search_length));
                    if ($subtring_from_word == strtolower($this->search_for)) {
                        $count_searched_char_in_single_word += 1;
                    }
                }
                if ($count_searched_char_in_single_word > 1) { // in this case the counter will be printed
                    for ($i = 0; $i < $word_length; $i++) {
                        if (strtolower(substr($word, $i, $search_length)) == strtolower($this->search_for)) {
                            echo "<span>" . strtolower($this->search_for) . "</span>";
                            $i += strlen($this->search_for) - 1;
                        } else {
                            echo substr($word, $i, 1);
                        }
                    }
                    echo " ($count_searched_char_in_single_word". 'x)'; // counter
                    echo "<br>";
                } else {
                    echo '. ';
                    for ($i = 0; $i < $word_length; $i++) {
                        if (strtolower(substr($word, $i, $search_length)) == strtolower($this->search_for)) {
                            echo "<span>" . strtolower($this->search_for) . "</span>";
                            $i += strlen($this->search_for) - 1;
                        } else {
                            echo substr($word, $i + $search_length - 1, 1);
                        }
                    }
                    echo "<br>";
                }
            }
            $count_searched_char_in_single_word = 0; // reseting the counter so that counting for the next word starts from zero again
        }

        }
    }
