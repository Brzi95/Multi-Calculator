<?php

$th = "<table class='border'".
    "<tr>".
    "<th> IME </th>".
    "<th> PREZIME </th>".
    "<th> GOLOVI </th>".
    "<th> ASISTENCIJE </th>".
    "</tr>";

// 1. SHOWING TABLES OF BOTH TEAMS WITH PLAYERS AND THEIR GOALS, ASSISTS
if ($_POST && $_POST['action'] == 'match_result') {

    $game_id_input = $_POST['game_id_input'];

    for ($team_id = 1; $team_id <= 2; $team_id++) {
        $sql_sum_goals = 
        "SELECT team_id, SUM(goals) AS sum_goals
        FROM games m
        WHERE game_id = $game_id_input AND team_id = $team_id";
            if ($result = mysqli_query($conn2, $sql_sum_goals)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<b>TIM $team_id</b><br><br>";
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['team_id'] == $team_id) { // ovo izmeniti kako bih mogao da pokupim oba scora i uporedim ih 
                            echo "<span>". $row['sum_goals'] ."</span>";
                        }
                    }
                    echo " <b>GOLOVA</b><br><br>";
                }
            }
        
        $sql_submited_match = 
        "SELECT first_name, last_name, goals, assists, team_id
        FROM games m
        LEFT JOIN players p
        ON m.player_id = p.player_id
        WHERE game_id = $game_id_input AND team_id = $team_id
        ORDER BY goals DESC";
            if ($result = mysqli_query($conn2, $sql_submited_match)) {
                if (mysqli_num_rows($result) > 0) {
                    echo $th;
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['team_id'] == $team_id) {
                            echo "<tr>". 
                            "<td>" . $row['first_name'] . "</td>" . 
                            "<td>" . $row['last_name'] . "</td>" . 
                            "<td>" . $row['goals'] . "</td>" .
                            "<td>" . $row['assists'] . "</td>" .
                            "</tr>";
                        }
                    }
                    echo "</table>";
                }
            }
    
        echo "<br><br>";
    }

// 2. SUMMARIZED GOALS AND ASSISTS FOR EVERY SINGLE PLAYER
} elseif ($_POST && $_POST['action'] == 'top_scorers_and_assists') {

    $list_input = $_POST['list_input'];
    if ($list_input == 'goals') {
        $first_sum = 'goals';
        $second_sum = 'assists';

    } else {
        $first_sum = 'assists';
        $second_sum = 'goals';
    }

    $th = 
    "<table class='border'>
    <tr>
    <th>NUM</th>
    <th>FIRST NAME</th>
    <th>LAST NAME</th>
    <th>". strtoupper($first_sum) ."</th>
    <th>". strtoupper($second_sum) ."</th>
    <th>GAMES</th>
    </tr>";

    // select last(max) player ID
    $sql_get_max_player_id = "SELECT MAX(player_id) AS max_player_id FROM players;";
    if ($result = mysqli_query($conn2, $sql_get_max_player_id)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $max_player_id = $row['max_player_id'];
            }
        }
    }

    $sql_get_max_game_id = "SELECT MAX(game_id) AS max_game_id FROM games";
    if ($result = mysqli_query($conn2, $sql_get_max_game_id)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $max_game_id = $row['max_game_id'];
            }
        }
    }

    // store player_id's and goals/assists in associative array
    $goals_or_assists = array();
    for ($i = 1; $i <= $max_player_id; $i++) {
        $sql_select_goals_or_assists = 
        "SELECT SUM($list_input) AS $list_input, player_id 
        FROM games
        WHERE player_id = $i";
        if ($result = mysqli_query($conn2, $sql_select_goals_or_assists)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    // inserting player_id as KEY and goal or assist as VALUE
                    $goals_or_assists[$row['player_id']] = $row["$list_input"];
                }
            }
        }
    }

    // does player ID exist where game ID is between 1 and max_game_id
    arsort($goals_or_assists);
    $games_played = 0;
    $array_with_arrays = array();
    foreach ($goals_or_assists as $player_id => $goal_or_assist) {
        for ($i = 1; $i <= $max_game_id; $i++) {
                $sql_does_id_exist = "SELECT m.player_id AS id 
                FROM games m
                LEFT JOIN players p ON p.player_id = m.player_id
                WHERE game_id = $i
                AND m.player_id = $player_id";
                if ($result = mysqli_query($conn2, $sql_does_id_exist)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['id'] != null) {
                                $games_played++;
                            }
                        }
                    }
                }
        }
        $array_with_games[$player_id] = $games_played;
        $games_played = 0;
    }

    // Sorted the assoc array above by VALUES in DESC order -> used their KEYS in the query bellow
    echo $th;
    $row_count = 1;
    foreach ($goals_or_assists as $player_id => $goal_or_assist) {
        $sql_select_match = "SELECT p.player_id, p.first_name, p.last_name, SUM($first_sum) as $first_sum, SUM($second_sum) as $second_sum
        FROM players p
        LEFT JOIN games m ON p.player_id = m.player_id
        WHERE p.player_id = $player_id
        ";
        if ($result = mysqli_query($conn2, $sql_select_match)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>". $row_count++. "</td>";
                    echo "<td>". $row['first_name']. "</td>";
                    echo "<td>". $row['last_name'] . "</td>";
                    echo "<td>". $row["$first_sum"] . "</td>";
                    echo "<td>". $row["$second_sum"] . "</td>";
                    echo "<td>". $array_with_games[$player_id] . "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    echo "</table>";


// 3. SUMMARIZED ALL GOALS AND ASSISTS FOR EVERY PLAYER SEPARATED
} elseif ($_POST && $_POST['action'] == 'show_player') {
    $player_id_input = $_POST['player_id_input'];

    $sql_get_max_id = "SELECT MAX(game_id) AS max_id FROM games";
    if ($result = mysqli_query($conn2, $sql_get_max_id)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $max_game_id = $row['max_id'];
            }
        }
    }

    $games_played = 0;
    for ($i = 1; $i <= $max_game_id; $i++) {
        $sql_does_id_exist = "SELECT m.player_id AS id 
        FROM games m
        LEFT JOIN players p ON p.player_id = m.player_id
        WHERE game_id = $i
        AND m.player_id = $player_id_input";
        if ($result = mysqli_query($conn2, $sql_does_id_exist)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['id'] != null) {
                        $games_played++;
                    }
                }
            }
        }
    }

    $th = 
    "<table class='border'>
    <tr>
    <th>IME</th>
    <th>PREZIME</th>
    <th>GOLOVI</th>
    <th>ASISTENCIJE</th>
    <th>ODIGRANIH</th>
    </tr>";

    $sql_select_match = "SELECT p.player_id, p.first_name, p.last_name, SUM(goals) as sum_goals, SUM(assists) as sum_assists
    FROM players p
    LEFT JOIN games m ON p.player_id = m.player_id WHERE p.player_id = $player_id_input";
    if ($result = mysqli_query($conn2, $sql_select_match)) {
        if (mysqli_num_rows($result) > 0) {
            echo $th;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>". $row['first_name']. "</td>";
                echo "<td>". $row['last_name'] . "</td>";
                echo "<td>". $row['sum_goals'] . "</td>";
                echo "<td>". $row['sum_assists'] . "</td>";
                echo "<td>". $games_played . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

} else {
    echo "Select match!";
}
