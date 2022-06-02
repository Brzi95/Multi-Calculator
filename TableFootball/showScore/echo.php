<?php

// sum of scores for all matches, displayed all the time
$sql_Sum = "SELECT SUM(brzi), SUM(gorance) FROM `brzi-gorance`";
$sum_Result = mysqli_query($conn, $sql_Sum);
$sum_ResultCheck = mysqli_num_rows($sum_Result);
while ($row_Sum = mysqli_fetch_assoc($sum_Result)) {
    echo "THE ETERNAL DERBY <br> 
    ALL MATCHES SINCE BING BANG <br><br> 
    BRZI VS. GORANCE <br>" . 
    $row_Sum['SUM(brzi)'] . ' : ' . $row_Sum['SUM(gorance)'] . '<br><br><br><br>';
}

if ($_POST && $_POST['action'] == 'showScore') {
    $date = date($_POST['date1']);
    $sql = "SELECT * FROM `brzi-gorance` WHERE `playedOn` = '$date'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "BRZI VS. GORANCE <br>" . $row['brzi'] . " : " . $row['gorance'] . "<br> $date";
    }
} else {
    echo "<br><br><br>
    Enter date to see their score!";
    }
?>
