<?php

$th = "<table class='border'>
<tr>
<td>TIM</td>
<td>IME</td>
<td>PREZIME</td>
<td>GOLOVI</td>
<td>ASISTENCIJE</td>
<td>DATUM</td>
</tr>";

$g = $_GET['g'] ?? null;
if ($g) {
    include '../../databases/mali_Fudbal_DB.php';
    for ($team_id = 1; $team_id <= 2; $team_id++) { 
        $sql_get_game = "SELECT team_id, first_name, last_name, goals, assists, date_of_game FROM futsal_games g
        LEFT JOIN futsal_players p ON p.player_id = g.player_id
        WHERE game_id = $g AND team_id = $team_id
        ORDER BY goals DESC, assists DESC, first_name"
        ;
        if ($result = mysqli_query($conn2, $sql_get_game)) {
            if (mysqli_num_rows($result) > 0) {
                echo $th;
                while ($row = mysqli_fetch_array($result)) {
                    date_timestamp_set(date_create(), $row['date_of_game']);
                    $date = date_format(date_create(), "Y-m-d");

                    echo "<tr>";
                    echo "<td>". $row['team_id'] ."</td>";
                    echo "<td>". $row['first_name'] ."</td>";
                    echo "<td>". $row['last_name'] ."</td>";
                    echo "<td>". $row['goals'] ."</td>";
                    echo "<td>". $row['assists'] ."</td>";
                    echo "<td>". $date ."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br>";
            }
        } 
    }
}




