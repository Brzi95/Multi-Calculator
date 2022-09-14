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
            echo "$first_name is already in a team $check_team!<br><br>";
        }
        $first_name = '';
        $check_team = '';
    }
// add/remove goals
} elseif ($_POST && $_POST['action'] == 'add_or_remove_goal') {
    $_POST['action_goal'] == 'add_goal' ? $num = 1 : $num = -1;
    $player_id = $_POST['id'];
    $sql_add_or_remove_goal = "UPDATE `live_game` 
    SET `goals`= (SELECT goals FROM `live_game` WHERE player_id = $player_id)+$num 
    WHERE player_id = $player_id;"
    ;
    mysqli_query($conn2, $sql_add_or_remove_goal);
    
} 

$th = "<table class='border'>
<tr>
<td>TIM</td>
<td>IME</td>
<td>PREZIME</td>
<td>GOLOVI</td>
<td>ASISTENCIJE</td>
<td>DATUM</td>
</tr>";

// checking the number of rows after adding/deleting players from table
$sql_live_game_rows = "SELECT COUNT(player_id) AS num_of_rows FROM live_game";
if ($result = mysqli_query($conn2, $sql_live_game_rows)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $live_game_rows = $row['num_of_rows'];
        }
    }
}

if ($live_game_rows == 0) {
    echo "Napravi timove!";
} else { 
    // ako je current_date == match_date, prikazujemo tabelu 
    // -- ako nije (ako je live tabela ostala za dan kasnije), podaci se prebace u games, a live ide truncate
    $array_with_IDs = array();
    for ($i = 1; $i <= 2; $i++) { 
        $sql_select_live_game = "SELECT `team_id`, `first_name`, `last_name`, `goals`, `assists`, `date_of_game`, g.player_id AS player_id
        FROM live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE team_id = $i"
        ;
        if ($result = mysqli_query($conn2, $sql_select_live_game)) {
            if (mysqli_num_rows($result) > 0) {
                echo $th;
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>". $row['team_id'] ."</td>";
                    echo "<td>". $row['first_name'] ."</td>";
                    echo "<td>". $row['last_name'] ."</td>";
                    echo "<td>". $row['goals'] ."</td>";
                    echo "<td>". $row['assists'] ."</td>";
                    echo "<td>". $row['date_of_game'] ."</td>";
                    echo "</tr>";
                    if ($row['player_id'] != null) {
                        array_push($array_with_IDs, $row['player_id']);
                    }
                }
                echo "</table><br><br>";
            } 
        }
    }
}

echo "<br><br>";

if (!empty($array_with_IDs)) {
    foreach ($array_with_IDs as $player_id) {
        $sql_get_single_player = "SELECT * FROM live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE g.player_id = $player_id"
        ;
        if ($result = mysqli_query($conn2, $sql_get_single_player)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $id = $row['player_id'];
                    $player_name = $row['first_name'];
                }
            }
        }
        // ADD GOAL BUTTON
        echo '<form action="index.php?page=futsal" method="post">
        <label>'.$player_name.'</label>
        <select name="id">
            <optgroup">
                <option value="' . $id . '" selected> Dodaj gol </option>
            </optgroup>
        </select>
        <input type="hidden" name="action" value="add_or_remove_goal">
        <input type="hidden" name="action_goal" value="add_goal">
        <input type="submit" value="+">
        </form>
        <br><br>';
        
        // REMOVE GOAL BUTTON
        echo '<form action="index.php?page=futsal" method="post">
        <label>'.$player_name.'</label>
        ><select name="id"=>
            <optgroup>
                <option value="' . $id . '"selected>Ukloni gol</option>
            </optgroup>
        </select>
        <input type="hidden" name="action" value="add_or_remove_goal">
        <input type="hidden" name="action_goal" value="remove_goal">
        <input type="submit" value="-">
        </form>
        <br><br>';
    }
}


