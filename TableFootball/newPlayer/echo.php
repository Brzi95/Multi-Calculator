<?php

if ($_POST && $_POST['action'] == 'addPlayer') {
    $firstName = $_POST['first'];
    $lastName = $_POST['last'];
    $nickName = strtolower($_POST['nick']);
    $dateJoined = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `Players` (`first_name`, `last_name`, `nick_name`, `date_joined`) VALUES ('$firstName', '$lastName', '$nickName', '$dateJoined')";
    mysqli_query($conn, $sql);
    echo "Player has been added! <br>";

    // Players table - visible before submiting the form
} else {
    $sql_column_names = "SELECT COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_NAME='game_results'";
    $result_column_names = mysqli_query($conn, $sql_column_names);
        echo '<table class="border">';
        echo    '<tr>';
        while ($row_column_names = mysqli_fetch_assoc($result_column_names)) {
            echo    "<th>" . $row_column_names['COLUMN_NAME'] . "</th>";
        }
        echo    "</tr>";

    $sql_game_results_table = "SELECT * FROM `game_results`
    WHERE `game_id`= 1;"; // between dates, chage it
    $game_results_table_result = mysqli_query($conn, $sql_game_results_table);
    while ($row_game_results_table = mysqli_fetch_assoc($game_results_table_result)) {
        echo    "<tr>";
        echo        "<td>" . $row_game_results_table['pair_id'] . "</td>";
        echo        "<td>" . $row_game_results_table['date_of_game'] . "</td>";
        echo        "<td>" . $row_game_results_table['first_player_score'] . "</td>";
        echo        "<td>" . $row_game_results_table['second_player_score'] . "</td>";
        echo        "<td>" . $row_game_results_table['game_id'] . "</td>";
        echo    "</tr>";
    }
        echo "</table>";

    echo "<br><br><br>
          Want to join the Table Football club?";
}

