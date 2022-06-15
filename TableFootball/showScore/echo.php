<?php

    // Show the Scores - code starts after the form is submited
if ($_POST && $_POST['action'] == 'showScore') {
    $input_player_nick1 = strtolower($_POST['player_nick1']);
    $input_player_nick2 = strtolower($_POST['player_nick2']);
    $inputDate1 = date($_POST['date1']);
    $inputDate2 = date($_POST['date2']);
    $inputRadio = $_POST['score'];
    $check_table_name1 = $input_player_nick1 . "_vs_" . $input_player_nick2;
    $check_table_name2 = $input_player_nick2 . "_vs_" . $input_player_nick1;
    $game_id = "game-id";
    $playedOn = "playedOn";

    // checking if the inputs/nicknames exist in the players table
    $sql_Nicknames = "SELECT NICK_NAME FROM Players";
    $nicknames_Result = mysqli_query($conn, $sql_Nicknames);
    while ($row_Nicknames = mysqli_fetch_assoc($nicknames_Result)) {
        if ($row_Nicknames['NICK_NAME'] == $input_player_nick1) {
            $check_nick1 = $input_player_nick1;
        }
        if ($row_Nicknames['NICK_NAME'] == $input_player_nick2) {
            $check_nick2 = $input_player_nick2;
        }
    }
    if (!isset($check_nick1)) {
        echo "$input_player_nick1 isn't in the Players list or you made a typing mistake! <br>
        Please add $input_player_nick1 or type it again!";
        return false;
    } elseif (!isset($check_nick2)) {
        echo "$input_player_nick2 isn't in the Players list or you made a typing mistake! <br>
        Please add $input_player_nick2 or type it again!";
        return false;
    }

    // checking if the two players played with each other (if a table with their score exists)
    $sql_Table_Names = "SELECT TABLE_NAME 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_SCHEMA = 'table football';";
    $table_names_Result = mysqli_query($conn, $sql_Table_Names);
    while ($row_Table_Names = mysqli_fetch_assoc($table_names_Result)) {
        if ($row_Table_Names['TABLE_NAME'] == $check_table_name1) {
            $table_name = $check_table_name1;
        }
        if ($row_Table_Names['TABLE_NAME'] == $check_table_name2) {
            $table_name = $check_table_name2;
        }
    }
    if (!isset($table_name)) {
        echo "$input_player_nick1 and $input_player_nick2 didn't play with each other!";
        return false;
    }

    // sum of scores all matches
    $sql_Sum = "SELECT SUM($input_player_nick1), SUM($input_player_nick2) FROM `$table_name`";
    $sum_Result = mysqli_query($conn, $sql_Sum);
    while ($row_Sum = mysqli_fetch_assoc($sum_Result)) {
        echo "THE ETERNAL DERBY <br> 
        ALL MATCHES SINCE BIG BANG <br><br> 
        $input_player_nick1 VS. $input_player_nick2 <br>" . 
        $row_Sum["SUM($input_player_nick1)"] . ' : ' . $row_Sum["SUM($input_player_nick2)"] . '<br><br><br><br>';
    }
    $dateRange = "between $inputDate1 and $inputDate2 <br><br>";
    echo $dateRange;

    // seperated scores from date1 to date2
    if ($inputRadio == 'separate') {
            echo "<table class='border'>
                <tr>
                    <th> $game_id </th>
                    <th> $playedOn </th>
                    <th> $input_player_nick1 </th>
                    <th> $input_player_nick2 </th>
                </tr>";
                    
        $sql = "SELECT * FROM `$table_name` WHERE `$playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        echo    "<tr>
                <td> $row[$game_id] </td>
                <td> $row[$playedOn] </td>
                <td> $row[$input_player_nick1] </td>
                <td> $row[$input_player_nick2] </td>
            </tr>";
        }
        echo "</table>";

        // summarized score from date1 to date2
    } else {
        $sql = "SELECT SUM($input_player_nick1), SUM($input_player_nick2) FROM `$table_name` WHERE `$playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<table class='border'> 
            <tr>
                <th> $input_player_nick1 </th>
                <th> $input_player_nick2 </th>
            </tr>";
            
            echo '<tr>';
            echo    '<td>' . $row["SUM($input_player_nick1)"] . '</td>';
            echo    '<td>' . $row["SUM($input_player_nick2)"] . '</td>';
            echo '</tr>';
            echo '</table>';
        }
    }

    // table names of all player pairs - visible before submiting the form
} else {
    $sql_Table_Names = "SELECT TABLE_NAME 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_SCHEMA = 'table football';";
    $table_names_Result = mysqli_query($conn, $sql_Table_Names);
        echo "<table class='border'>";
    while ($row_Table_Names = mysqli_fetch_assoc($table_names_Result)) {
        echo '<tr>';
        echo '<td>' . $row_Table_Names['TABLE_NAME'] . '<td>';
        echo '</tr>';
    }
        echo '</table>';

    echo "<br><br><br>
    Enter nicknames and dates to see their score!";
    }


       /* 
    $input1 = $inputDate1 === '' ? $inputDate2 : $inputDate1;
    $input2 = $inputDate2 === '' ? $inputDate1 : $inputDate2; */
?>
