<?php

// sum of scores for all matches, displayed all the time
$sql_Sum = "SELECT SUM(brzi), SUM(gorance) FROM `brzi_vs_gorance`";
$sum_Result = mysqli_query($conn, $sql_Sum);
$sum_ResultCheck = mysqli_num_rows($sum_Result);
while ($row_Sum = mysqli_fetch_assoc($sum_Result)) {
    echo "THE ETERNAL DERBY <br> 
    ALL MATCHES SINCE BIG BANG <br><br> 
    BRZI VS. GORANCE <br>" . 
    $row_Sum['SUM(brzi)'] . ' : ' . $row_Sum['SUM(gorance)'] . '<br><br><br><br>';
}

if ($_POST && $_POST['action'] == 'showScore') {
    $inputDate1 = date($_POST['date1']);
    $inputDate2 = date($_POST['date2']);
    $inputRadio = $_POST['score'];
    $dateRange = "between $inputDate1 and $inputDate2 <br><br> BRZI VS. GORANCE <br><br>";
    echo $dateRange;


    // $sql_column_names = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='brzi_vs_gorance'";
    if ($inputRadio == 'separate') {
        $ordinal_Position = [1, 2];
        $sql_column_names = "SELECT COLUMN_NAME 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME='brzi_vs_gorance'";
        $result_column_names = mysqli_query($conn, $sql_column_names);
            echo '<table class="border">';
            echo    '<tr>';
            while ($row_column_names = mysqli_fetch_assoc($result_column_names)) {
                echo    "<th>" . $row_column_names['COLUMN_NAME'] . "</th>";
            }
            echo    "</tr>";
        
        $sql = "SELECT * FROM `brzi_vs_gorance` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
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
        $sql = "SELECT SUM(brzi), SUM(gorance) FROM `brzi_vs_gorance` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
        $result = mysqli_query($conn, $sql);
        echo $dateRange;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<table class="border"> 
            <tr>
                <th> Brzi </th>
                <th> Gorance </th>
            </tr>';

            echo '<tr>';
            echo    '<td>' . $row['SUM(brzi)'] . '</td>';
            echo    '<td>' . $row['SUM(gorance)'] . '</td>';
            echo '</tr>';
            echo '</table>';
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
