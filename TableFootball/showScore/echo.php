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
    $inputDate1 = date($_POST['date1']);
    $inputDate2 = date($_POST['date2']);
    $inputRadio = $_POST['score'];

    if ($inputRadio == 'separate') {
        $sql = "SELECT * FROM `brzi-gorance` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

            echo "between $inputDate1 and $inputDate2 <br><br>
            BRZI VS. GORANCE <br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['brzi'] . " : " . $row['gorance'] . ' --> ' . $row['playedOn'] . "<br>";
        }
    } else {
        $sql = "SELECT SUM(brzi), SUM(gorance) FROM `brzi-gorance` WHERE `playedOn` BETWEEN '$inputDate1' AND '$inputDate2'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

            echo "between $inputDate1 and $inputDate2 <br><br>
            BRZI VS. GORANCE <br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['SUM(brzi)'] . " : " . $row['SUM(gorance)'] . "<br>";
        }
    }

} else {
    echo "<br><br><br>
    Enter date to see their score!";
    }


       /* mnogi drugi uslovi se treba srediti, ovo ispod je cisto da se isproba ideja
    $input1 = $inputDate1 === '' ? $inputDate2 : $inputDate1;
    $input2 = $inputDate2 === '' ? $inputDate1 : $inputDate2; */
?>
