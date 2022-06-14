<?php

if ($_POST && $_POST['action'] == 'showScore') {
    $input_player_nick_or_id_1 = $_POST['player_nick_or_id_1'];
    $input_player_nick_or_id_2 = $_POST['player_nick_or_id_2'];
    $inputDate1 = date($_POST['date1']);
    $inputDate2 = date($_POST['date2']);
    $inputRadio = $_POST['score'];

    if ($input_player_nick_or_id_1 == 'brzi' && $input_player_nick_or_id_2 == 'gorance' ||
    $input_player_nick_or_id_2 == 'brzi' && $input_player_nick_or_id_1 == 'gorance') {
            $table_name = 'brzi_vs_gorance';
            // sum of scores for all matches, displayed all the time
            $sql_Sum = "SELECT SUM(brzi), SUM(gorance) FROM `$table_name`";
            $sum_Result = mysqli_query($conn, $sql_Sum);
            $sum_ResultCheck = mysqli_num_rows($sum_Result);
            while ($row_Sum = mysqli_fetch_assoc($sum_Result)) {
                echo "THE ETERNAL DERBY <br> 
                ALL MATCHES SINCE BIG BANG <br><br> 
                Brzi VS. Gorance <br>" . 
                $row_Sum['SUM(brzi)'] . ' : ' . $row_Sum['SUM(gorance)'] . '<br><br><br><br>';
            }

            $dateRange = "between $inputDate1 and $inputDate2 <br><br> brzi VS. gorance <br><br>";
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
                $resultCheck = mysqli_num_rows($result);
                while ($row = mysqli_fetch_assoc($result)) {
                echo    '<tr>';
                echo        "<td>" . $row['game-id'] . "</td>";
                echo        "<td>" . $row['playedOn'] . "</td>";
                echo        "<td>" . $row['brzi'] . "</td>";
                echo        "<td>" . $row['gorance'] . "</td>";
                echo    "</tr>";
                }
                echo "</table>";
            } else {
                $sql = "SELECT SUM(brzi), SUM(gorance) FROM `$table_name` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
                $result = mysqli_query($conn, $sql);
                echo $dateRange;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<table class="border"> 
                    <tr>
                        <th> brzi </th>
                        <th> gorance </th>
                    </tr>';
            
                    echo '<tr>';
                    echo    '<td>' . $row['SUM(brzi)'] . '</td>';
                    echo    '<td>' . $row['SUM(gorance)'] . '</td>';
                    echo '</tr>';
                    echo '</table>';
                }
            }
    }
} else {
    echo "<br><br><br>
    Enter date to see their score!";
    }


       /* 
    $input1 = $inputDate1 === '' ? $inputDate2 : $inputDate1;
    $input2 = $inputDate2 === '' ? $inputDate1 : $inputDate2; */
?>
