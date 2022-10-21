<?php

$th = "<table class='border'>
<tr>
<td>IME</td>
<td>PREZIME</td>
<td>GOLOVI</td>
<td>ASISTENCIJE</td>
<td>PRISTUPIO</td>
</tr>";

$q = $_GET['q'] ?? null;
if ($q) {
    include '../../databases/mali_Fudbal_DB.php';
    $sql_get_player = "SELECT first_name, last_name, date_joined, SUM(goals) AS sum_goals, SUM(assists) AS sum_assists 
    FROM futsal_games g
    LEFT JOIN futsal_players p ON p.player_id = g.player_id
    WHERE p.player_id = $q"
    ;
    if ($result = mysqli_query($conn2, $sql_get_player)) {
        if (mysqli_num_rows($result) > 0) {
            echo $th;
            while ($row = mysqli_fetch_array($result)) {
                date_timestamp_set(date_create(), $row['date_joined']);
                $date = date_format(date_create(), "Y-m-d");

                echo "<tr>";
                echo "<td>". $row['first_name'] ."</td>";
                echo "<td>". $row['last_name'] ."</td>";
                echo "<td>". $row['sum_goals'] ."</td>";
                echo "<td>". $row['sum_assists'] ."</td>";
                echo "<td>". $date ."</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
        }
    } 
}


