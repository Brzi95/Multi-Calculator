<?php
// header('Content-Type: application/json; charset=utf-8');
include '../../databases/mali_Fudbal_DB.php';

// INSERTING PLAYER INTO LIVE GAME TABLE
$player_id = $_GET['player_id'] ?? null;
$team_id = $_GET['team_id'] ?? null;
$current_date = date_timestamp_get(date_create(date('Y-m-d')));

$sql_insert_player = 
"INSERT INTO `futsal_live_game`(`team_id`, `player_id`, `first_name`, `last_name`, `nick_name`, `goals`, `assists`, `date_of_game`, `game_id`) 
VALUES (
    $team_id, 
    $player_id, 
    (SELECT `first_name` FROM `futsal_players` WHERE `player_id` = $player_id),
    (SELECT `last_name` FROM `futsal_players` WHERE `player_id` = $player_id),
    (SELECT `nick_name` FROM `futsal_players` WHERE `player_id` = $player_id),
    '0',
    '0',
    $current_date,
    (SELECT MAX(game_id) FROM `futsal_games`)+1)"
;
mysqli_query($conn2, $sql_insert_player);



?>
