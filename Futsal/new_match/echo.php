
<?php

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
    if ($button_value == 'g+') {
        $column_name = 'goals';
        $num = 1;
    } elseif ($button_value == 'g-') {
        $column_name = 'goals';
        $num = -1;
    } elseif ($button_value == 'as+') {
        $column_name = 'assists';
        $num = 1;
    } elseif ($button_value == 'as-') {
        $column_name = 'assists';
        $num = -1;
    }
    $player_id = $_POST['id'];
    $sql_add_or_remove_goal = "UPDATE `live_game` 
    SET `$column_name`= (SELECT $column_name FROM `live_game` WHERE player_id = $player_id)+$num 
    WHERE player_id = $player_id"
    ;
    mysqli_query($conn2, $sql_add_or_remove_goal);
} elseif ($_POST && $_POST['action'] == 'remove') {
    $button_player = $_POST['remove_player'];
    $button_team = $_POST['remove_team'];
    $button_player ? $button_value = $button_player : $button_value = $button_team;
    if ($button_value == 'remove_player') {
        $id = $_POST['id'];
        $sql_delete_player = "DELETE FROM `live_game`  
        WHERE player_id = $id"
        ;
        mysqli_query($conn2, $sql_delete_player);
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        $id = $_POST['id'];
        $sql_delete_team = "DELETE FROM `live_game`  
        WHERE team_id = $id"
        ;
        mysqli_query($conn2, $sql_delete_team);
        echo "<meta http-equiv='refresh' content='0'>";
    }
} 



$th = "<table class='border'>
<tr>
<th></th>
<th>TIM</th>
<th>IME</th>
<th>PREZIME</th>
<th>GOLOVI</th>
<th>ASISTENCIJE</th>
<th>DATUM</th>
</tr>";

$form_start = '<form action="index.php?page=futsal" method="post">
<div style="display: none">
<select name="id">
<optgroup">
<option value="';

$form_goals_end = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="add_or_remove_goal">
<button type="submit" name="goals_or_assists" value="g+">+</button>
<button type="submit" name="goals_or_assists" value="g-">-</button>
</form>';

$form_assists_end = '" selected> Dodaj gol </option>
</optgroup>
</select></div>
<input type="hidden" name="action" value="add_or_remove_goal">
<button type="submit" name="goals_or_assists" value="as+">+</button>
<button type="submit" name="goals_or_assists" value="as-">-</button>
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


// checking the number of rows after adding/deleting players or goals from table
$sql_live_game_rows = "SELECT COUNT(player_id) AS num_of_rows FROM live_game";
if ($result = mysqli_query($conn2, $sql_live_game_rows)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $live_game_rows = $row['num_of_rows'];
        }
    }
}

if ($live_game_rows != 0) {
    for ($i = 1; $i <= 2; $i++) {
        $array_with_IDs = array();
        $sql_select_live_game = "SELECT `team_id`, `first_name`, `last_name`, `goals`, `assists`, `date_of_game`, g.player_id AS player_id
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
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<br>";
                    echo $form_start . $team_id . $form_remove_whole_team_end . " Obriši ceo tim";
                    echo "<br><br>";
                } 
            }
        }
} else {
    echo 'Napravi nove timove!';
}
