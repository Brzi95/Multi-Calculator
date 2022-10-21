<?php
include '../../databases/mali_Fudbal_DB.php';

$player_id = $_GET['insert_player'] ?? null;
$team = $_GET['team_id'] ?? null;
$team_num = $team == '1' ? 1 : 2;
$current_date = date('Y-m-d');
$sql_add_player = "INSERT INTO `live_game`(`team_id`, `player_id`, `goals`, `assists`, `date_of_game`) 
VALUES ($team_num, $player_id, 0, 0, '$current_date')"
;
mysqli_query($conn2, $sql_add_player);

?>
