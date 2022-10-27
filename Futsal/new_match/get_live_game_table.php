<?php
// header('Content-Type: application/json; charset=utf-8');
include '../../databases/mali_Fudbal_DB.php';



// GETTING WHOLE LIVE GAME TABLE
$team_id_key = $_GET['team_id'] ?? null;
// var_dump($team_id_key);
$sql_select_everything_from_live_game_table = 
"SELECT `team_id`, `player_id`, `first_name`, `last_name`, `nick_name`, `goals`, `assists`, `date_of_game`, `game_id` 
FROM `futsal_live_game`
WHERE `team_id` = $team_id_key"
;
if ($team_id_key) {
    if ($result = mysqli_query($conn2, $sql_select_everything_from_live_game_table)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $date_create = date_create();
                date_timestamp_set($date_create, $row['date_of_game']);
                $game_date_formated = date_format($date_create, 'Y-m-d');

                $team_id = $row['team_id'];
                $player_id = $row['player_id'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $nick_name = $row['nick_name'];
                $goals = $row['goals'];
                $assists = $row['assists'];
                $date_of_game = $game_date_formated;
                $game_id = $row['game_id'];

                $return_arr[] = array(
                    "team_id" => $team_id,
                    "player_id" => $player_id,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "nick_name" => $nick_name,
                    "goals" => $goals,
                    "assists" => $assists,
                    "date_of_game" => $date_of_game,
                    "game_id" => $game_id,
                    "check_if_rows_exist" => 1
                );
            }
            echo json_encode($return_arr);
        }
    }
}

?>
