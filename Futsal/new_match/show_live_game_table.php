<?php
include '../../databases/mali_Fudbal_DB.php';

$sql_live_game_rows = "SELECT COUNT(player_id) AS num_of_rows FROM live_game";
if ($result = mysqli_query($conn2, $sql_live_game_rows)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $live_game_rows = $row['num_of_rows'];
        }
    }
}

if ($live_game_rows > 0) {
    $sql_set_game_id = "UPDATE `live_game` 
    SET `game_id`= (SELECT MAX(game_id) FROM games)+1"
    ;
    mysqli_query($conn2, $sql_set_game_id);

    $insert_player = $_GET['insert_player'] ?? null;
        $sql_select_live_game = "SELECT `team_id`, `first_name`, `last_name`, `goals`, `assists`, `date_of_game`, g.player_id AS player_id, game_id
        FROM futsal_live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE team_id = 1
        ORDER BY goals DESC, assists DESC, first_name, last_name"
        ;
        if ($result = mysqli_query($conn2, $sql_select_live_game)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $team_id = $row['team_id'];
                    $player_id = $row['player_id'];
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $goals = $row['goals'];
                    $assists = $row['assists'];
                    $live_game_date = $row['date_of_game'];
                    $game_id = $row['game_id'];

                    $return_arr[] = array(
                        "team_id" => $team_id,
                        "player_id" => $player_id,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "goals" => $goals,
                        "assists" => $assists,
                        "live_game_date" => $live_game_date,
                        "game_id" => $game_id
                    );
                }
                echo json_encode($return_arr);
            } 
        }
} else {
    echo "<p>napravi timove</p>";
}

?>
