<?php

// add/remove players
if ($_POST && $_POST['action'] == 'add_or_remove_player') {
    $team = $_POST['team'];
    $team == 'team_1' ? $team_num = 1 : $team_num = 2;
    $IDs_from_input = $_POST["$team"];
    $input_radio = $_POST['player'];

    $IDs_from_table = '';
    $first_name = '';
    $check_team = '';
    foreach ($IDs_from_input as $player_id) {
        $sql_inserted_players = "SELECT first_name, team_id, g.player_id
        FROM live_game g
        LEFT JOIN players p ON p.player_id = g.player_id
        WHERE g.player_id = $player_id";
        if ($result = mysqli_query($conn2, $sql_inserted_players)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $IDs_from_table = $row['player_id'];
                    $first_name = $row['first_name'];
                    $check_team = $row['team_id'];
                }
            } 
        }
        if ($IDs_from_table != $player_id) {
            $current_date = date('Y-m-d');
            $insert_query = "INSERT INTO `live_game`(`team_id`, `player_id`, `goals`, `assists`, `date_of_game`) 
            VALUES ($team_num, $player_id, 0, 0, $current_date)"
            ;
            $delete_query = "DELETE FROM `live_game` WHERE player_id = $player_id"
            ;
            $input_radio == 'add_player' ? $sql_query = $insert_query : $sql_query = $delete_query;
            mysqli_query($conn2, $sql_query);
            echo "$first_name added to the team $team_num!<br>";
        } else {
            echo "$first_name is already in the team $check_team!<br><br>";
        }
        $check_team = '';
    }
// add/remove goals/assists
} elseif ($_POST && $_POST['action'] == 'add_or_remove_goal') {
    $button_name = 'goals_or_assists';
    $button_value = $_POST["$button_name"];
    if ($button_value == 'g+') {
        $button_name = 'goals';
        $num = 1;
    } elseif ($button_value == 'g-') {
        $button_name = 'goals';
        $num = -1;
    } elseif ($button_value == 'as+') {
        $button_name = 'assists';
        $num = 1;
    } elseif ($button_value == 'as-') {
        $button_name = 'assists';
        $num = -1;
    }
    $player_id = $_POST['id'];
    $sql_add_or_remove_goal = "UPDATE `live_game` 
    SET `$button_name`= (SELECT $button_name FROM `live_game` WHERE player_id = $player_id)+$num 
    WHERE player_id = $player_id;"
    ;
    mysqli_query($conn2, $sql_add_or_remove_goal);
    
} 

$th = "<table class='border'>
<tr>
<th>TIM</th>
<th>IME</th>
<th>PREZIME</th>
<th>GOLOVI</th>
<th>ASISTENCIJE</th>
<th>DATUM</th>
</tr>";

$form_start = '<form action="index.php?page=futsal" method="post">
<div style="display: none"> <select name="id">
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




// checking the number of rows after adding/deleting players from table
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
        echo $th;
        $array_with_IDs = array();
        $sql_select_live_game = "SELECT `team_id`, `first_name`, `last_name`, `goals`, `assists`, `date_of_game`, g.player_id AS player_id
        FROM live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE team_id = $i"
        ;
            if ($result = mysqli_query($conn2, $sql_select_live_game)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $id = $row['player_id'];
                        echo "<tr>";
                        echo "<td>". $row['team_id'] ."</td>";
                        echo "<td>". $row['first_name'] ."</td>";
                        echo "<td>". $row['last_name'] ."</td>";
                        echo "<td>". 

                        $row['goals']. "$form_start" . $id . "$form_goals_end"
                        ."</td>";

                        echo "<td>". 
                        $row['goals']. "$form_start" . $id . "$form_assists_end"
                        ."</td>";

                        echo "<td>". $row['date_of_game'] ."</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                } 
            }
        }
} else {
    echo 'Napravi nove timove!';
}



