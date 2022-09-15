<?php

$th = "<table class='border'>
<tr>
<th></th>
<th>TIM</th>
<th>IME</th>
<th>PREZIME</th>
<th>GOLOVI</th>
<th>ASISTENCIJE</th>
<th>DATUM</th>
<th>KOLO</th>
</tr>";

$form_start = '<form action="index.php?page=futsal" method="post">
<div style="display: none">
<select name="id">
<optgroup">
<option value="';

$goal_plus = 'g+';
$goal_minus = 'g-';
$assist_plus = 'as+';
$assist_minus = 'as-';
$form_goals_end = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="add_or_remove_goal">
<button type="submit" name="goals_or_assists" value='.$goal_plus.'>+</button>
<button type="submit" name="goals_or_assists" value='.$goal_minus.'>-</button>
</form>';

$form_assists_end = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="add_or_remove_goal">
<button type="submit" name="goals_or_assists" value='.$assist_plus.'>+</button>
<button type="submit" name="goals_or_assists" value='.$assist_minus.'>-</button>
</form>';

$form_remove_player_end = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="remove">
<button type="submit" name="remove_player" value="remove_player">X</button>
</form>';

$form_remove_whole_team_end = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="remove">
<button type="submit" name="remove_team" value="remove_team">X</button>
</form>';

$form_end_game = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="end_game">
<button type="submit" name="remove_team" value="remove_team">X</button>
</form>';


// add players
if ($_POST && $_POST['action'] == 'add_player') {
    $team = $_POST['team'];
    $team == 'team_1' ? $team_num = 1 : $team_num = 2;
    $IDs_from_input = $_POST["$team"];
    $IDs_from_table = '';
    foreach ($IDs_from_input as $player_id) {
        $sql_inserted_players = "SELECT first_name, team_id, g.player_id
        FROM live_game g
        LEFT JOIN players p ON p.player_id = g.player_id
        WHERE g.player_id = $player_id";
        if ($result = mysqli_query($conn2, $sql_inserted_players)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $IDs_from_table = $row['player_id'];
                }
            } 
        }
        $current_date = date('Y-m-d');
        $sql_add_player = "INSERT INTO `live_game`(`team_id`, `player_id`, `goals`, `assists`, `date_of_game`) 
        VALUES ($team_num, $player_id, 0, 0, '$current_date')"
        ;
        mysqli_query($conn2, $sql_add_player);
        echo "<meta http-equiv='refresh' content='0'>";
    }

// add/remove goals/assists
} elseif ($_POST && $_POST['action'] == 'add_or_remove_goal') {
    $button_value = $_POST['goals_or_assists'];
    $substring_first_char = substr($button_value, 0, 1);
    $substring_last_char = substr($button_value, strlen($button_value) - 1);
    $substr_goal_plus_first_char = substr($goal_plus, 0, 1);
    $substr_goal_plus_last_char = substr($goal_plus, strlen($goal_plus)-1);
    $column_name = '';
    $num = '';
    $substring_first_char == $substr_goal_plus_first_char ? $column_name = 'goals' : $column_name = 'assists';
    $substring_last_char == $substr_goal_plus_last_char ? $num = 1 : $num = -1;
    $player_id = $_POST['id'];
    $sql_add_or_remove_goal = "UPDATE `live_game` 
    SET `$column_name`= (SELECT $column_name FROM `live_game` WHERE player_id = $player_id)+$num 
    WHERE player_id = $player_id"
    ;
    mysqli_query($conn2, $sql_add_or_remove_goal);

// remove player/whole team
} elseif ($_POST && $_POST['action'] == 'remove') {
    $button_player = $_POST['remove_player'];
    $button_team = $_POST['remove_team'];
    $button_player ? $button_value = $button_player : $button_value = $button_team;
    $where_column = '';
    $button_value == 'remove_player' ? $where_column = 'player_id' : $where_column = 'team_id';
    $id = $_POST['id'];
    $sql_delete = "DELETE FROM `live_game`  
    WHERE $where_column = $id"
    ;
    mysqli_query($conn2, $sql_delete);
    echo "<meta http-equiv='refresh' content='0'>";

// end game - moving data from table live_game to games and truncate live_game
} elseif ($_POST && $_POST['action'] == 'end_game') {
    $sql_push_data_to_games = "INSERT INTO games (team_id, player_id, goals, assists, date_of_game, game_id)
    SELECT team_id, player_id, goals, assists, date_of_game, game_id
    FROM live_game"
    ;
    mysqli_query($conn2, $sql_push_data_to_games);

    $sql_truncate_live_game = "TRUNCATE TABLE live_game"
    ;
    mysqli_query($conn2, $sql_truncate_live_game);
}

// checking the number of rows after refresh or after adding/deleting players or goals from table 
$sql_live_game_rows = "SELECT COUNT(player_id) AS num_of_rows FROM live_game";
if ($result = mysqli_query($conn2, $sql_live_game_rows)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $live_game_rows = $row['num_of_rows'];
        }
    }
}

if ($live_game_rows > 0) {
    // setting the game_id
    $sql_set_game_id = "UPDATE `live_game` 
    SET `game_id`= (SELECT MAX(game_id) FROM games)+1"
    ;
    mysqli_query($conn2, $sql_set_game_id);

    for ($i = 1; $i <= 2; $i++) {
        $array_with_IDs = array();
        $sql_select_live_game = "SELECT `team_id`, `first_name`, `last_name`, `goals`, `assists`, `date_of_game`, g.player_id AS player_id, game_id
        FROM live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE team_id = $i
        ORDER BY goals DESC, assists DESC"
        ;
            if ($result = mysqli_query($conn2, $sql_select_live_game)) {
                if (mysqli_num_rows($result) > 0) {
                    echo $th;
                    while ($row = mysqli_fetch_array($result)) {
                        $team_id = $row['team_id'];
                        $player_id = $row['player_id'];
                        echo "<tr>";
                        echo "<td>";
                        echo "$form_start" . $player_id . "$form_remove_player_end";
                        echo "</td>";
                        echo "<td>". $row['team_id'] ."</td>";
                        echo "<td>". $row['first_name'] ."</td>";
                        echo "<td>". $row['last_name'] ."</td>";
                        echo "<td>". 
                        $row['goals']. "$form_start" . $player_id . "$form_goals_end";
                        echo "</td>";
                        echo "<td>". 
                        $row['assists']. "$form_start" . $player_id . "$form_assists_end";
                        echo "</td>";
                        echo "<td>". $row['date_of_game'] ."</td>";
                        echo "<td>". $row['game_id'] ."</td>";
                        echo "</tr>";
                        $live_game_date = $row['date_of_game'];
                    }
                    echo "</table>";
                    echo "<br>";
                    echo $form_start . $team_id . $form_remove_whole_team_end . " Obriši ceo tim";
                    echo "<br><br><br>";
                } 
            }
        }
        // form for ending the game - move all data to the games table and truncate live_game table
        echo "Završi utakmicu! <br>" . $form_start . $form_end_game;

        // data transfers to other collumn automatically the next day
        if ($live_game_date != date("Y-m-d")) {
            $sql_push_data_to_games = "INSERT INTO games (team_id, player_id, goals, assists, date_of_game, game_id)
            SELECT team_id, player_id, goals, assists, date_of_game, game_id
            FROM live_game"
            ;
            mysqli_query($conn2, $sql_push_data_to_games);
        
            $sql_truncate_live_game = "TRUNCATE TABLE live_game"
            ;
            mysqli_query($conn2, $sql_truncate_live_game);
        }

} else {
    echo 'Napravi nove timove!';
}
