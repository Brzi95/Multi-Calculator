<?php
// header('Content-Type: application/json; charset=utf-8');
include '../../databases/mali_Fudbal_DB.php';

// INSERTING PLAYER INTO LIVE GAME TABLE
$player_id_key = $_GET['player_id'] ?? null;
$team_id_key = $_GET['team_id'] ?? null;
$current_date = date_timestamp_get(date_create(date('Y-m-d')));

$sql_insert_player = 
"INSERT INTO `futsal_live_game` (`team_id`, `player_id`, `first_name`, `last_name`, `nick_name`, `goals`, `assists`, `date_of_game`, `game_id`) 
VALUES (
    $team_id_key, 
    $player_id_key, 
    (SELECT `first_name` FROM `futsal_players` WHERE `player_id` = $player_id_key),
    (SELECT `last_name` FROM `futsal_players` WHERE `player_id` = $player_id_key),
    (SELECT `nick_name` FROM `futsal_players` WHERE `player_id` = $player_id_key),
    '0',
    '0',
    $current_date,
    (SELECT MAX(game_id) FROM `futsal_games`)+1)"
;

if ($player_id_key && $team_id_key) {
    mysqli_query($conn2, $sql_insert_player);
}


?>
