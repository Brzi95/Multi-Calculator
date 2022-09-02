<?php

// player_pairs table columns
$player_pairs = 'player_pairs'; // table name
$pair_id_column = 'pair_id';
$first_player_id_column = 'first_player_id';
$second_player_id_column = 'second_player_id';

// game_results table columns
$game_results_table = 'game_results'; // table name
$pair_id_column = 'pair_id';
$date_of_game = 'date_of_game';
$first_player_score = 'first_player_score';
$second_player_score = 'second_player_score';
$game_id = 'game_id';

// after submiting the form, following code starts 
if ($_POST && $_POST['action'] == 'insertScore') {
    $current_date = date('Y-m-d');
    $first_player_id_input = $_POST['first_player_id'];
    $second_player_id_input = $_POST['second_player_id'];
    $first_player_score_input = $_POST['win1'];
    $second_player_score_input = $_POST['win2'];

    // checking if the players played with each other (if a pair_id exist with their player_id's)
    $sql_does_pair_id_exist = "SELECT $pair_id_column
    FROM $player_pairs
    WHERE (
          ($first_player_id_column = '$first_player_id_input' AND $second_player_id_column = '$second_player_id_input')
          OR
          ($first_player_id_column = '$second_player_id_input' AND $second_player_id_column = '$first_player_id_input')
      )
    ;";

    $does_exist = mysqli_query($conn, $sql_does_pair_id_exist);
    $does_pair_id_exist = null;
    while ($row_pair_id_exist = mysqli_fetch_assoc($does_exist)) {
        $does_pair_id_exist = $row_pair_id_exist["$pair_id_column"];
    }

    // if they've never played with each other (pair_id doesn't exist)
    // creating a pair_id for them
    if ($does_pair_id_exist == NULL) {
        if ($first_player_id_input < $second_player_id_input) {
            $sql_insert_new_pair_id = "INSERT INTO $player_pairs (`$first_player_id_column`, `$second_player_id_column`) VALUES ($first_player_id_input, $second_player_id_input);";
            mysqli_query($conn, $sql_insert_new_pair_id);
        } elseif ($first_player_id_input > $second_player_id_input) {
            $sql_insert_new_pair_id = "INSERT INTO $player_pairs (`$first_player_id_column`, `$second_player_id_column`) VALUES ($second_player_id_input, $first_player_id_input);";
            mysqli_query($conn, $sql_insert_new_pair_id);
        }
        echo "Score has been updated!";
    }
    

    // getting the pairID with their unique player_ids
    $sql_get_pair_id = "SELECT DISTINCT $pair_id_column
    FROM $player_pairs
    WHERE (
          ($first_player_id_column = '$first_player_id_input' AND $second_player_id_column = '$second_player_id_input')
          OR
          ($first_player_id_column = '$second_player_id_input' AND $second_player_id_column = '$first_player_id_input')
      )
    ;";

    $result_pair_id = mysqli_query($conn, $sql_get_pair_id);
    while ($row_pair_id = mysqli_fetch_assoc($result_pair_id)) {
        $pair_id = $row_pair_id["$pair_id_column"];
    }

    // Score submited the second, third... time on the same day will just be updated to the score of that day
    // First submit on the next day creates a new row with the current date
    $sql_last_date = "SELECT `$date_of_game` 
        FROM `$game_results_table` 
        WHERE `$pair_id_column`= $pair_id 
        AND `$game_id`=(SELECT max(`$game_id`) FROM `$game_results_table`);";
        $result_last_date = mysqli_query($conn, $sql_last_date);
        $last_date_played_on = null;
        while ($row_last_date = mysqli_fetch_assoc($result_last_date)) {
            $last_date_played_on = $row_last_date["$date_of_game"];
        }
        
        // if the players have never played with each other (inserting their first row in table game_results)
        if ($last_date_played_on == NULL) { 
            if ($first_player_id_input < $second_player_id_input) {
                $sql_Insert = "INSERT INTO `$game_results_table` (`$pair_id_column`, `$date_of_game`, `$first_player_score`, `$second_player_score`) VALUES ($pair_id, '$current_date', '$first_player_score_input', '$second_player_score_input')";
                mysqli_query($conn, $sql_Insert);
            } elseif ($first_player_id_input > $second_player_id_input) {
                $sql_Insert = "INSERT INTO `$game_results_table` (`$pair_id_column`, `$date_of_game`, `$first_player_score`, `$second_player_score`) VALUES ($pair_id, '$current_date', '$second_player_score_input', '$first_player_score_input')";
                mysqli_query($conn, $sql_Insert);
            }
            echo "Score has been updated!";
        } else {
            // if they already played on todays date (updating the scores on existing row)
            if ($last_date_played_on == $current_date) {
                if ($first_player_id_input < $second_player_id_input) {
                    $sql_Update = "UPDATE `$game_results_table` 
                    SET $first_player_score = $first_player_score + $first_player_score_input, $second_player_score = $second_player_score + $second_player_score_input 
                    WHERE $pair_id_column = $pair_id 
                    AND $date_of_game = '$last_date_played_on'";
                    mysqli_query($conn, $sql_Update);
                } elseif ($first_player_id_input > $second_player_id_input) {
                    $sql_Update = "UPDATE `$game_results_table` 
                    SET $first_player_score = $first_player_score + $second_player_score_input, $second_player_score = $second_player_score + $first_player_score_input 
                    WHERE $pair_id_column = $pair_id 
                    AND $date_of_game = '$last_date_played_on'";
                    mysqli_query($conn, $sql_Update);
                  }
            // if they didn't play on todays date (inserting a new row for the current date)
            } else {
                if ($first_player_id_input < $second_player_id_input) {
                    $sql_Insert = "INSERT INTO `$game_results_table` (`$pair_id_column`, `$date_of_game`, `$first_player_score`, `$second_player_score`) VALUES ($pair_id, '$current_date', '$first_player_score_input', '$second_player_score_input')";
                    mysqli_query($conn, $sql_Insert);
                } elseif ($first_player_id_input > $second_player_id_input) {
                    $sql_Insert = "INSERT INTO `$game_results_table` (`$pair_id_column`, `$date_of_game`, `$first_player_score`, `$second_player_score`) VALUES ($pair_id, '$current_date', '$second_player_score_input', '$first_player_score_input')";
                    mysqli_query($conn, $sql_Insert);
                }
            }   
            echo "Score has been updated!";
        }

} else {
    echo "Update your score!<br><br>";
}
