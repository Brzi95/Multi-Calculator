<?php
    // game results table columns
    $game_results_table = 'game_results';
    $date_of_game = 'date_of_game';
    $first_player_score = 'first_player_score';
    $second_player_score = 'second_player_score';


    // Insert the Scores - code starts after the form is submited
if ($_POST && $_POST['action'] == 'insertScore') {
    $currentDate = date('Y-m-d');
    $first_player_id = $_POST['first_player_id'];
    $second_player_id = $_POST['second_player_id'];
    $winScore1 = $_POST['win1'];
    $winScore2 = $_POST['win2'];

    // getting the pairID with the help of playerID inputs
    $sql_get_pair_id = "SELECT DISTINCT pair_id
    FROM player_pairs
    WHERE (
          (first_player_id = '$first_player_id' AND second_player_id = '$second_player_id')
          OR
          (first_player_id = '$second_player_id' AND second_player_id = '$first_player_id')
      )
    ;";

    $result_pair_id = mysqli_query($conn, $sql_get_pair_id);
    while ($row_pair_id = mysqli_fetch_assoc($result_pair_id)) {
        $pair_id = $row_pair_id['pair_id'];
    }

    // Score submited the second, third... time on the same day will just be updated to the score of that day
    // First submit on the next day creates a new row with the current date
    $sql_last_date = "SELECT `$date_of_game` 
        FROM `$game_results_table` 
        WHERE `pair_id`= $pair_id 
        AND `game_id`=(SELECT max(`game_id`) FROM `$game_results_table`);";
        $result_last_date = mysqli_query($conn, $sql_last_date);
        $row_last_date = mysqli_fetch_assoc($result_last_date);
        if ($row_last_date["$date_of_game"] = NULL) { // if the players have never played with each other
            $sql_Insert = "INSERT INTO `$game_results_table` (`pair_id`, `$date_of_game`, `$first_player_score`, `$second_player_score`) VALUES ($pair_id, '$currentDate', '$winScore1', '$winScore2')";
            mysqli_query($conn, $sql_Insert);
        } else {
        $lastDatePlayedOn = $row_last_date["$date_of_game"];
            if ($lastDatePlayedOn == $currentDate) {
                $sql_Update = "UPDATE `$game_results_table` 
                SET $first_player_score = $first_player_score + $winScore1, $second_player_score = $second_player_score + $winScore2 
                WHERE pair_id=$pair_id 
                AND date_of_game='$lastDatePlayedOn'";
                mysqli_query($conn, $sql_Update);
            } else {
                $sql_Insert = "INSERT INTO `$game_results_table` (`pair_id`, `$date_of_game`, `$first_player_score`, `$second_player_score`) VALUES ($pair_id, '$currentDate', '$winScore1', '$winScore2')";
                mysqli_query($conn, $sql_Insert);
            }   
                echo "Score has been updated!";
        }
    }
else {
    echo "Update your score!";
}
