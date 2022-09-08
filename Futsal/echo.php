<?php

if ($_POST && $_POST['action'] == 'showMatch') {
    $game_id_input = $_POST['game_id_input'];
    $th = "<table class='border'".
    "<tr>".
    "<th> IME </th>".
    "<th> PREZIME </th>".
    "<th> GOLOVI </th>".
    "<th> ASISTENCIJE </th>".
    "</tr>";

    echo "<b>". $game_id_input . ". KOLO</b>
    <br><br><br>";

    echo "TIM 1
    <br><br>";
    echo $th;
    $sql_submited_match = 
    "SELECT first_name, last_name, goals, assists 
    FROM matches m
    LEFT JOIN players p
    ON m.player_id = p.player_id
    WHERE game_id = $game_id_input AND team_id = 1";
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
    <br><br>";
    echo $th;
    $sql_submited_match = 
    "SELECT first_name, last_name, goals, assists 
    FROM matches m
    LEFT JOIN players p
    ON m.player_id = p.player_id
    WHERE game_id = $game_id_input AND team_id = 2";
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

} else {
    echo "Select match!";
}
