<?php

$th = "<table class='border'".
    "<tr>".
    "<th> IME </th>".
    "<th> PREZIME </th>".
    "<th> GOLOVI </th>".
    "<th> ASISTENCIJE </th>".
    "</tr>";

if ($_POST && $_POST['action'] == 'match_result') {
    $game_id_input = $_POST['game_id_input'];

    echo "<b>". $game_id_input . ". KOLO</b>
    <br><br><br>";

    echo "TIM 1
    <br><br>
    $th";
    $sql_submited_match = 
    "SELECT first_name, last_name, goals, assists 
    FROM matches m
    LEFT JOIN players p
    ON m.player_id = p.player_id
    WHERE game_id = $game_id_input AND team_id = 1
    ORDER BY goals DESC";
        if ($result = mysqli_query($conn2, $sql_submited_match)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>". 
                    "<td>" . $row['first_name'] . "</td>" . 
                    "<td>" . $row['last_name'] . "</td>" . 
                    "<td>" . $row['goals'] . "</td>" .
                    "<td>" . $row['assists'] . "</td>" .
                    "</tr>";
                }
                echo "</table>";
            }
        }

    echo "<br><br>";

    echo "TIM 2
    <br><br>
    $th";
    $sql_submited_match = 
    "SELECT first_name, last_name, goals, assists 
    FROM matches m
    LEFT JOIN players p
    ON m.player_id = p.player_id
    WHERE game_id = $game_id_input AND team_id = 2
    ORDER BY goals DESC";
        if ($result = mysqli_query($conn2, $sql_submited_match)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>". 
                    "<td>" . $row['first_name'] . "</td>" . 
                    "<td>" . $row['last_name'] . "</td>" . 
                    "<td>" . $row['goals'] . "</td>" .
                    "<td>" . $row['assists'] . "</td>" .
                    "</tr>";
                }
                echo "</table>";
            }
        }

} elseif ($_POST && $_POST['action'] == 'top_scorers_or_assists') {
    $list_input = $_POST['list_input'];
    if ($list_input == 'goals') {
        $first_sum_th = 'GOLOVI';
        $second_sum_th = 'ASISTENCIJE';
        $first_sum_td = 'goals';
        $second_sum_td = 'assists';
    } else {
        $first_sum_th = 'ASISTENCIJE';
        $second_sum_th = 'GOLOVI';
        $first_sum_td = 'assists';
        $second_sum_td = 'goals';
    }
    $th = 
    "<table class='border'>
    <tr>
    <th>PLAYER ID</th>
    <th>IME</th>
    <th>PREZIME</th>
    <th>$first_sum_th</th>
    <th>$second_sum_th</th>
    </tr>";

    // select last/max player ID
    $sql_select_last_player_id = "SELECT MAX(player_id) AS max_id FROM players;";
    if ($result = mysqli_query($conn2, $sql_select_last_player_id)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $row['max_id'] . '.';
                $last_player_id = $row['max_id'];
            }
        }
    }

    // store goals/assists in array
    $goals_or_assists = array();
    for ($i = 1; $i <= $last_player_id; $i++) {
        $sql_select_goals_or_assists = 
        "SELECT SUM($list_input) AS $list_input, player_id 
        FROM matches
        WHERE player_id = $i";
        if ($result = mysqli_query($conn2, $sql_select_goals_or_assists)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $row["$list_input"] . 'player_id ' . $row['player_id'];
                    array_push($goals_or_assists, $row["$list_input"]);
                }
            }
        }
    }

    rsort($goals_or_assists);
    foreach ($goals_or_assists as $goal_or_assist) {
        echo $goal_or_assist . "<br>";
    }
    echo "<br><br><br><br><br><br>";
    
    echo $th;
    rsort($goals_or_assists);
    // foreach ($goals_or_assists as $goal_or_assist) { 
        for ($i = 1; $i <= $last_player_id; $i++) {
        $sql_select_match = "SELECT p.player_id, p.first_name, p.last_name, SUM(goals) as goals, SUM(assists) as assists
        FROM players p
        LEFT JOIN matches m ON p.player_id = m.player_id
        WHERE p.player_id = $i
        ";
        if ($result = mysqli_query($conn2, $sql_select_match)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>". $row['player_id']. "</td>";
                    echo "<td>". $row['first_name']. "</td>";
                    echo "<td>". $row['last_name'] . "</td>";
                    echo "<td>". $row["$first_sum_td"] . "</td>";
                    echo "<td>". $row["$second_sum_td"] . "</td>";
                    echo "</tr>";
                }
            }
        }
    }
    
    echo "</table>";



} elseif ($_POST && $_POST['action'] == 'show_player') {
    $th = 
    "<table class='border'>
    <tr>
    <th>IME</th>
    <th>PREZIME</th>
    <th>GOLOVI</th>
    </tr>";

    $player_id_input = $_POST['player_id_input'];
    $sql_select_match = "SELECT p.player_id, p.first_name, p.last_name, SUM(goals) as sum_goals
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
                echo "</tr>";
            }
            echo "</table>";
        }
    }

} else {
    echo "Select match!";
}
