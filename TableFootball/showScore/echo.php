<?php

if ($_POST && $_POST['action'] == 'showScore') {
    $date = date($_POST['date']);
    $sql = "SELECT * FROM `brzi-gorance` WHERE `playedOn` = '$date'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "BRZI VS. GORANCE <br>" . $row['brzi'] . " : " . $row['gorance'] . "<br> $date";
    }
} else {
    echo "Enter player ID to see its score!";
    }
?>
