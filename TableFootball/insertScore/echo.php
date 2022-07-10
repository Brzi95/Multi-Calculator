<?php

    // Insert the Scores - code starts after the form is submited
if ($_POST && $_POST['action'] == 'insertScore') {
    $currentDate = date('Y-m-d');
    $input_player_nick1 = strtolower($_POST['player_nick1']);
    $input_player_nick2 = strtolower($_POST['player_nick2']);
    $winScore1 = $_POST['win1'];
    $winScore2 = $_POST['win2'];
    $check_table_name1 = $input_player_nick1 . "_vs_" . $input_player_nick2;
    $check_table_name2 = $input_player_nick2 . "_vs_" . $input_player_nick1;

    // checking if the inputs/nicknames exist in the players table
    $sql_Nicknames = "SELECT NICK_NAME FROM Players";
    $nicknames_Result = mysqli_query($conn, $sql_Nicknames);
    while ($row_Nicknames = mysqli_fetch_assoc($nicknames_Result)) {
        if ($row_Nicknames['NICK_NAME'] == $input_player_nick1) {
            $check_nick1 = $input_player_nick1;
        }
        if ($row_Nicknames['NICK_NAME'] == $input_player_nick2) {
            $check_nick2 = $input_player_nick2;
        }
    }
    if (!isset($check_nick1)) {
        echo "$input_player_nick1 isn't in the Players list or you made a typing mistake! <br>
        Please add $input_player_nick1 or type it again!";
        return false;
    } elseif (!isset($check_nick2)) {
        echo "$input_player_nick2 isn't in the Players list or you made a typing mistake! <br>
        Please add $input_player_nick2 or type it again!";
        return false;
    }

    // checking if the two players played with each other (if a table with their score exists)
    $sql_Table_Names = "SELECT TABLE_NAME 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_SCHEMA = 'table football';";
    $table_names_Result = mysqli_query($conn, $sql_Table_Names);
    while ($row_Table_Names = mysqli_fetch_assoc($table_names_Result)) {
        if ($row_Table_Names['TABLE_NAME'] == $check_table_name1) {
            $table_name = $check_table_name1;
        }
        if ($row_Table_Names['TABLE_NAME'] == $check_table_name2) {
            $table_name = $check_table_name2;
        }
    }

    // If players exist in Players table and they didn't play with each other (!isset($table_name)) we will automaticly create a table and insert the first row with data from inputs
    // otherwise, the code below will be skipped and score will be updated to an existing table (else)
    if (!isset($table_name)) {
        $sql_Create_Table = "CREATE TABLE `$check_table_name1` (
           `game_id` int(20) PRIMARY KEY AUTO_INCREMENT,
           `playedOn` date,
           `$input_player_nick1` int(20), 
           `$input_player_nick2` int(20));";
        mysqli_query($conn, $sql_Create_Table);
        $sql_Insert_First_Row = "INSERT INTO `$check_table_name1` (
			`playedOn`, 
    		`$input_player_nick1`, 
    		`$input_player_nick2`)
            VALUES ('$currentDate', '$winScore1', '$winScore2');";
        mysqli_query($conn, $sql_Insert_First_Row);
        echo "Score has been updated!";
    } else {
        // Score will be updated/inserted to existing table
        $sql_Select = "SELECT `playedOn` 
        FROM `$table_name` 
        WHERE `game_id`=(SELECT max(`game_id`) FROM `$table_name`);";
        $result_Select = mysqli_query($conn, $sql_Select);
        $row_Select = mysqli_fetch_assoc($result_Select);
        $lastDatePlayedOn = $row_Select['playedOn'];

        // Score submited the second, third... time on the same day will just be updated to the last row
        // First submit on the next day creates a new row with the current date
        if ($lastDatePlayedOn == $currentDate) {
            $sql_Update = "UPDATE `$table_name` SET $input_player_nick1 = $input_player_nick1 + $winScore1, $input_player_nick2 = $input_player_nick2 + $winScore2 WHERE playedOn='$lastDatePlayedOn'";
            mysqli_query($conn, $sql_Update);
        } else {
            $sql_Insert = "INSERT INTO `$table_name` (`playedOn`, `$input_player_nick1`, `$input_player_nick2`) VALUES ('$currentDate', '$winScore1', '$winScore2')";
            mysqli_query($conn, $sql_Insert);
        }   
            echo "Score has been updated!";
        }
} else {
    echo "Update your score!";
}
