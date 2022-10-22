<?php

include 'mali_Fudbal_DB.php';

$player_id_form = $_GET['player_id'];
$sql_get_player = "SELECT first_name, last_name, nick_name, date_joined, p.player_id AS player_id, goals, assists 
FROM futsal_games g
LEFT JOIN futsal_players p ON p.player_id = g.player_id
WHERE p.player_id = $player_id_form"
;
if ($result = mysqli_query($conn2, $sql_get_player)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $player_id = $row['player_id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $nick_name = $row['nick_name'];
            $goals = $row['goals'];
            $assists = $row['assists'];
            $date = date_format(date_create(), "Y-m-d");
            
            $arr_player[] = array(
                "player_id" => $player_id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "nick_name" => $nick_name,
                "goals" => $goals,
                "assists" => $assists,
                "date" => $date
            );
        }
        echo json_encode($arr_player);
    }
}
