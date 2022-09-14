<?php

    

$th = "<table class='border'".
    "<tr>".
    "<th> IME </th>".
    "<th> PREZIME </th>".
    "<th> GOLOVI </th>".
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

// 4. CREATE TEAMS, creating new live game table and inserting the players
} elseif ($_POST && $_POST['action'] == 'create_teams') {
    $team_1_input = $_POST['team1'];
    $team_2_input = $_POST['team2'];
    $current_date = date("Y/m/d");
    $row_count = 1;

    $th = 
    "<table class='border'>
    <tr>
    <th>ID</th>
    <th>IME</th>
    <th>PREZIME</th>
    </tr>";


    // INSERTING PLAYERS INTO live_game TABLE
    echo "TIM 1 <br><br>";
    foreach ($team_1_input as $player_id) {
        $sql_insert_input_into_live_game_table = 
        "INSERT INTO `live_game`(`team_id`, `player_id`, `date_of_game`) 
        VALUES ('1', $player_id, $current_date)"
        ;
        mysqli_query($conn2, $sql_insert_input_into_live_game_table);
    }
    echo "<br><br>";

    echo "TIM 2 <br><br>";
    foreach ($team_2_input as $player_id) {
        $sql_insert_input_into_live_game_table = 
        "INSERT INTO `live_game`(`team_id`, `player_id`, `date_of_game`) 
        VALUES ('2', $player_id, $current_date)"
        ;
        mysqli_query($conn2, $sql_insert_input_into_live_game_table);
    }
    echo "<br><br>";


            // REMOVE PLAYER FROM live_game TABLE INPUT
            echo 
            '<form action="index.php?page=futsal" method="post">
            <label>Ukloni igrača iz tima</label>
            <br>
            <select name="delete[]" multiple>
            <optgroup label="Igrači:">';
        
            $sql_get_players_live_game = 
            "SELECT first_name, last_name, g.player_id AS player_id
            FROM live_game g
            LEFT JOIN players p ON p.player_id = g.player_id"
            ;
            if ($result = mysqli_query($conn2, $sql_get_players_live_game)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<option value="' . $row['player_id'] . '">' . $row['first_name']. ' ' . $row['last_name']. '</option>';
                    }
                }
            }
           
            echo "<br><br>";
            echo '</optgroup></select>
            <br>
            <input type="hidden" name="action" value="delete_row_live_game_table">
            <input type="submit" value="submit">
            </form>';


    // printing data from live game

    $sql_get_live_game_team_1 = 
    "SELECT g.player_id AS ID, first_name AS IME, last_name AS PREZIME FROM live_game g
    LEFT JOIN players p ON g.player_id = p.player_id
    WHERE team_id = 1"
    ;
    if ($result = mysqli_query($conn2, $sql_get_live_game_team_1)) {
        if (mysqli_num_rows($result) > 0) {
            echo $th;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID']. "</td>";
                echo "<td>" . $row['IME']. "</td>";
                echo "<td>" . $row['PREZIME']. "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    echo "<br><br>";

    $sql_get_live_game_team_2 = 
    "SELECT g.player_id AS ID, first_name AS IME, last_name AS PREZIME FROM live_game g
    LEFT JOIN players p ON g.player_id = p.player_id
    WHERE team_id = 2"
    ;
    if ($result = mysqli_query($conn2, $sql_get_live_game_team_2)) {
        if (mysqli_num_rows($result) > 0) {
            echo $th;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID']. "</td>";
                echo "<td>" . $row['IME']. "</td>";
                echo "<td>" . $row['PREZIME']. "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }


    echo "<br><br><br>";

    

    // deleting from table
} elseif ($_POST && $_POST['action'] == 'delete_row_live_game_table') {
    $player_ids = $_POST['delete'];

    foreach ($player_ids as $id) {
        $sql_delete_row = 
        "DELETE FROM live_game WHERE player_id = $id"
        ;
        mysqli_query($conn2, $sql_delete_row);
    ;
    }

    $sql_get_live_game_team_1 = 
    "SELECT g.player_id AS ID, first_name AS IME, last_name AS PREZIME FROM live_game g
    LEFT JOIN players p ON g.player_id = p.player_id
    WHERE team_id = 1"
    ;
    if ($result = mysqli_query($conn2, $sql_get_live_game_team_1)) {
        if (mysqli_num_rows($result) > 0) {
            echo  
            "<table class = 'border'>
            <tr>
            <th>ID</th>
            <th>IME</th>
            <th>PREZIME</th>
            </tr>"
            ;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                    echo "<td>" . $row['ID']. "</td>";
                    echo "<td>" . $row['IME']. "</td>";
                    echo "<td>" . $row['PREZIME']. "</td>";
                    echo "</tr>";
            }
            echo "</table>";
        }
    }

    echo "<br><br>";

    $sql_get_live_game_team_2 = 
    "SELECT g.player_id AS ID, first_name AS IME, last_name AS PREZIME FROM live_game g
    LEFT JOIN players p ON g.player_id = p.player_id
    WHERE team_id = 2"
    ;
    if ($result = mysqli_query($conn2, $sql_get_live_game_team_2)) {
        if (mysqli_num_rows($result) > 0) {
            echo  
            "<table class = 'border'>
            <tr>
            <th>ID</th>
            <th>IME</th>
            <th>PREZIME</th>
            </tr>"
            ;
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID']. "</td>";
                echo "<td>" . $row['IME']. "</td>";
                echo "<td>" . $row['PREZIME']. "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    // REMOVE PLAYER FROM live_game TABLE
    echo 
    '<form action="index.php?page=futsal" method="post">
    <label>Ukloni igrača iz tima</label>
    <br>
    <select name="delete[]" multiple>
    <optgroup label="Igrači:">';
    
    $sql_get_players_live_game = 
    "SELECT first_name, last_name, g.player_id AS player_id
    FROM live_game g
    LEFT JOIN players p ON p.player_id = g.player_id"
    ;
    if ($result = mysqli_query($conn2, $sql_get_players_live_game)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['player_id'] . '">' . $row['first_name']. ' ' . $row['last_name']. '</option>';
            }
        }
    }
       
    echo "<br><br>";
    echo '</optgroup></select>
    <br>
    <input type="hidden" name="action" value="delete_row_live_game_table">
    <input type="submit" value="submit">
    </form>';

    
}


else {

    $sql_check_live_game_table =
    "SELECT COUNT(player_id) AS num_of_rows
    FROM live_game;"
    ;
    if ($result = mysqli_query($conn2, $sql_check_live_game_table)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
               $num_of_rows = $row['num_of_rows'];
            }
        }
    }

    if ($num_of_rows != 0) {
        echo "LIVE GAME! <br><br><br>";

        // REMOVE PLAYER FROM live_game TABLE INPUT
        echo 
        '<form action="index.php?page=futsal" method="post">
        <label>Ukloni igrača iz tima</label>
        <br>
        <select name="delete[]" multiple>
        <optgroup label="Igrači:">';
    
        $sql_get_players_live_game = 
        "SELECT first_name, last_name, g.player_id AS player_id
        FROM live_game g
        LEFT JOIN players p ON p.player_id = g.player_id"
        ;
        if ($result = mysqli_query($conn2, $sql_get_players_live_game)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['player_id'] . '">' . $row['first_name']. ' ' . $row['last_name']. '</option>';
                }
            }
        }
       
        echo "<br><br>";
        echo '</optgroup></select>
        <br>
        <input type="hidden" name="action" value="delete_row_live_game_table">
        <input type="submit" value="submit">
        </form>';


        // GETTING PLAYERS FROM live_game
        $sql_get_live_game_team_1 = 
        "SELECT g.player_id AS ID, first_name AS IME, last_name AS PREZIME FROM live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE team_id = 1"
        ;
        if ($result = mysqli_query($conn2, $sql_get_live_game_team_1)) {
            if (mysqli_num_rows($result) > 0) {
                echo 
                "<table class ='border'>
                <tr>
                <th>ID</th>
                <th>IME</th>
                <th>PREZIME</th>
                </tr>"
                ;
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID']. "</td>";
                    echo "<td>" . $row['IME']. "</td>";
                    echo "<td>" . $row['PREZIME']. "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }

        echo "<br><br>";

        $sql_get_live_game_team_2 = 
        "SELECT g.player_id AS ID, first_name AS IME, last_name AS PREZIME FROM live_game g
        LEFT JOIN players p ON g.player_id = p.player_id
        WHERE team_id = 2"
        ;
        if ($result = mysqli_query($conn2, $sql_get_live_game_team_2)) {
            if (mysqli_num_rows($result) > 0) {
                echo $th;
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID']. "</td>";
                    echo "<td>" . $row['IME']. "</td>";
                    echo "<td>" . $row['PREZIME']. "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }

        echo "<br><br>";




    } else {
        echo "WELCOME!";
    }
}



