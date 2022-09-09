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
        FROM matches m
        WHERE game_id = $game_id_input AND team_id = $team_id";
            if ($result = mysqli_query($conn2, $sql_sum_goals)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<b>TIM $team_id</b><br><br>";
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['team_id'] == $team_id) {
                            echo "<b>". $row['sum_goals'] ."</b>";
                        }
                    }
                    echo " <b>GOLOVA</b><br><br>";
                }
            }
    
        
        
        $sql_submited_match = 
        "SELECT first_name, last_name, goals, assists, team_id
        FROM matches m
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
    <th>PLAYER ID</th>
    <th>FIRST NAME</th>
    <th>LAST NAME</th>
    <th>". strtoupper($first_sum) ."</th>
    <th>". strtoupper($second_sum) ."</th>
    </tr>";

    // select last(max) player ID
    $sql_select_last_player_id = "SELECT MAX(player_id) AS max_id FROM players;";
    if ($result = mysqli_query($conn2, $sql_select_last_player_id)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $row['max_id'] . '.';
                $last_player_id = $row['max_id'];
            }
        }
    }

    // store player_id's and goals/assists in associative array
    $goals_or_assists = array();
    for ($i = 1; $i <= $last_player_id; $i++) {
        $sql_select_goals_or_assists = 
        "SELECT SUM($list_input) AS $list_input, player_id 
        FROM matches
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

    // Sorted the assoc array above by VALUES in DESC order -> used their KEYS in the query bellow
    echo $th;
    arsort($goals_or_assists);
    foreach ($goals_or_assists as $player_id => $goal_or_assist) {
        $sql_select_match = "SELECT p.player_id, p.first_name, p.last_name, SUM($first_sum) as $first_sum, SUM($second_sum) as $second_sum
        FROM players p
        LEFT JOIN matches m ON p.player_id = m.player_id
        WHERE p.player_id = $player_id
        ";
        if ($result = mysqli_query($conn2, $sql_select_match)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>". $row['player_id']. "</td>";
                    echo "<td>". $row['first_name']. "</td>";
                    echo "<td>". $row['last_name'] . "</td>";
                    echo "<td>". $row["$first_sum"] . "</td>";
                    echo "<td>". $row["$second_sum"] . "</td>";
                    echo "</tr>";
                }
            }
        }
    }
    
    echo "</table>";


// 3. SUMMARIZED ALL GOALS AND ASSISTS FOR EVERY PLAYER SEPARATED
} elseif ($_POST && $_POST['action'] == 'show_player') {

    $th = 
    "<table class='border'>
    <tr>
    <th>IME</th>
    <th>PREZIME</th>
    <th>GOLOVI</th>
    <th>ASISTENCIJE</th>
    </tr>";

    $player_id_input = $_POST['player_id_input'];
    $sql_select_match = "SELECT p.player_id, p.first_name, p.last_name, SUM(goals) as sum_goals, SUM(assists) as sum_assists
    FROM players p
    LEFT JOIN matches m ON p.player_id = m.player_id WHERE p.player_id = $player_id_input";
    if ($result = mysqli_query($conn2, $sql_select_match)) {
        if (mysqli_num_rows($result) > 0) {
            echo $th;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>". $row['first_name']. "</td>";
                echo "<td>". $row['last_name'] . "</td>";
                echo "<td>". $row['sum_goals'] . "</td>";
                echo "<td>". $row['sum_assists'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

} else {
    echo "Select match!";
}
