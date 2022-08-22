<?php

if ($_POST && $_POST['action'] == 'showScore') {
    $first_player_id = $_POST['first_player_id'];
    $second_player_id = $_POST['second_player_id'];
    $inputDate1 = date($_POST['date1']);
    $inputDate2 = date($_POST['date2']);
    $inputRadio = $_POST['score'];
    $dateGame = "date_of_game";

    $sql_get_nick1 = "SELECT nick_name
    FROM players
    WHERE player_id = '$first_player_id'
    ;";
    $result_get_nick1 = mysqli_query($conn, $sql_get_nick1);
    while ($row_get_nick1 = mysqli_fetch_assoc($result_get_nick1)) {
        $nick1 = $row_get_nick1['nick_name'];
    }

    $sql_get_nick2 = "SELECT nick_name
    FROM players
    WHERE player_id = '$second_player_id'
    ;";
    $result_get_nick2 = mysqli_query($conn, $sql_get_nick2);
    while ($row_get_nick2 = mysqli_fetch_assoc($result_get_nick2)) {
        $nick2 = $row_get_nick2['nick_name'];
    }

    if ($inputRadio == 'separate') {
            echo "<table class='border'>
                <tr>
                    <th> Pair ID </th>
                    <th> $nick1 </th>
                    <th> $nick2 </th>
                    <th> Date </th>
                    <th> Game ID </th>
                </tr>";
                    
        $sql_show_score = "SELECT pairs.pair_id, pairs.first_player_id, pairs.second_player_id, results.first_player_score, results.second_player_score, results.date_of_game, results.game_id
        FROM game_results results
        LEFT JOIN player_pairs pairs ON results.pair_id = pairs.pair_id
        WHERE results.date_of_game BETWEEN '$inputDate1' AND '$inputDate2'
          AND (
              (pairs.first_player_id = '$first_player_id' AND pairs.second_player_id = '$second_player_id')
              OR
              (pairs.first_player_id = '$second_player_id' AND pairs.second_player_id = '$first_player_id')
          )
        ;";
        $result = mysqli_query($conn, $sql_show_score);
        while ($row = mysqli_fetch_assoc($result)) {
        echo    "<tr>
                <td> $row[pair_id] </td>
                <td> $row[first_player_score] </td>
                <td> $row[second_player_score] </td>
                <td> $row[date_of_game] </td>
                <td> $row[game_id] </td>
            </tr>";
        }
        echo "</table>";
    }
}
?>
