<?php

if ($_POST && $_POST['action'] == 'showScore') {
    $input_player_nick1 = $_POST['player_nick1'];
    $input_player_nick2 = $_POST['player_nick2'];
    $inputDate1 = date($_POST['date1']);
    $inputDate2 = date($_POST['date2']);
    $inputRadio = $_POST['score'];
    $check_table_name1 = $input_player_nick1 . "_vs_" . $input_player_nick2;
    $check_table_name2 = $input_player_nick2 . "_vs_" . $input_player_nick1;

    $sql_Table_Names = "SELECT TABLE_NAME 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_SCHEMA = 'table football';";
    $table_names_Result = mysqli_query($conn, $sql_Table_Names);
    while ($row_Table_Names = mysqli_fetch_assoc($table_names_Result)) {
        if (str_contains($row_Table_Names['TABLE_NAME'], $check_table_name1)) {
            $table_name = $check_table_name1;
        }
        if (str_contains($row_Table_Names['TABLE_NAME'], $check_table_name2)) {
            $table_name = $check_table_name2;
        }
    }
    if (!isset($table_name)) {
        echo "It seems like the players '$input_player_nick1' and '$input_player_nick2' didn't play with each other or the nicknames aren't correct <br>
        Please try again!";
        return false;
    }

    // sum of scores for all matches, displayed all the time
    $sql_Sum = "SELECT SUM($input_player_nick1), SUM($input_player_nick2) FROM `$table_name`";
    $sum_Result = mysqli_query($conn, $sql_Sum);
    while ($row_Sum = mysqli_fetch_assoc($sum_Result)) {
        echo "THE ETERNAL DERBY <br> 
        ALL MATCHES SINCE BIG BANG <br><br> 
        $input_player_nick1 VS. $input_player_nick2 <br>" . 
        $row_Sum["SUM($input_player_nick1)"] . ' : ' . $row_Sum["SUM($input_player_nick2)"] . '<br><br><br><br>';
    }
    $dateRange = "between $inputDate1 and $inputDate2 <br><br> $input_player_nick1 VS. $input_player_nick2 <br><br>";
    echo $dateRange;

    if ($inputRadio == 'separate') {
        $sql_column_names = "SELECT COLUMN_NAME 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME='$table_name'";
        $result_column_names = mysqli_query($conn, $sql_column_names);
            echo '<table class="border">';
            echo    '<tr>';
            while ($row_column_names = mysqli_fetch_assoc($result_column_names)) {
                echo    "<th>" . $row_column_names['COLUMN_NAME'] . "</th>";
            }
            echo    "</tr>";
                    
        $sql = "SELECT * FROM `$table_name` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        echo    '<tr>';
        echo        "<td>" . $row['game-id'] . "</td>";
        echo        "<td>" . $row['playedOn'] . "</td>";
        echo        "<td>" . $row[$input_player_nick1] . "</td>";
        echo        "<td>" . $row[$input_player_nick2] . "</td>";
        echo    "</tr>";
        }
        echo "</table>";
    } else {
        $sql = "SELECT SUM($input_player_nick1), SUM($input_player_nick2) FROM `$table_name` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
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
} else {
    $sql_Table_Names = "SELECT TABLE_NAME 
    FROM INFORMATION_SCHEMA.TABLES 
    WHERE TABLE_SCHEMA = 'table football';";
    $table_names_Result = mysqli_query($conn, $sql_Table_Names);
    while ($row_Table_Names = mysqli_fetch_assoc($table_names_Result)) {
        echo $row_Table_Names['TABLE_NAME'] . "<br>";
    }

    echo "<br><br><br>
    Enter nicknames and dates to see their score!";
    }


       /* 
    $input1 = $inputDate1 === '' ? $inputDate2 : $inputDate1;
    $input2 = $inputDate2 === '' ? $inputDate1 : $inputDate2; */
?>
