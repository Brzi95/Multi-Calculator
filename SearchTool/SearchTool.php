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
        echo "There are $count $this->search_for's in the following text: <br> '$this->text'";
        echo "<br>";

        $words = str_word_count($this->text, 1);
        $num_of_words = str_word_count($this->text);

        if ($search_length < 2) {
            echo "<br> Words that contain character '$this->search_for' are: <br>";
        } else {
            echo "<br>'$this->search_for' appears $count times: <br>";
        }

        $row_count = 0;
        $count_search_in_single_word = 0;
        foreach ($words as $word) {
            $word_length = strlen($word);
            $substring_length = strlen($this->search_for);
            if (str_contains(strtolower($word), strtolower($this->search_for))) {
                echo $row_count += 1;
                for ($start_point = 0; $start_point < $word_length; $start_point++) {
                    $subtring_from_word = strtolower(substr($word, $start_point, $substring_length));
                    if ($subtring_from_word == strtolower($this->search_for)) {
                        $count_search_in_single_word += 1;
                    }
                }
                if ($count_search_in_single_word > 1) {
                    echo '. '. "$word". " ($count_search_in_single_word". 'x)'. '<br>';
                } else {
                    echo '. '. $word. '<br>';
                }
            }
            $count_search_in_single_word = 0; // reseting the counter so that counting for the next word starts from zero again
        }

        }
    }

