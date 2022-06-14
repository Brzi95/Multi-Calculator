<?php

if ($_POST && $_POST['action'] == 'insertScore') {
    $currentDate = date('Y-m-d');
    $nick1 = $_POST['nick1'];
    $winScore1 = $_POST['win1'];
    $nick2 = $_POST['nick2'];
    $winScore2 = $_POST['win2'];
    $sql_Select = "SELECT `playedOn` 
    FROM `brzi_vs_gorance` 
    WHERE `game-id`=(SELECT max(`game-id`) FROM `brzi_vs_gorance`);";
    $result_Select = mysqli_query($conn, $sql_Select);
    $row_Select = mysqli_fetch_assoc($result_Select);
    $lastDatePlayedOn = $row_Select['playedOn'];

    if ($lastDatePlayedOn == $currentDate) {
        $sql_Update = "UPDATE `brzi_vs_gorance` SET brzi=brzi+$win1, gorance=gorance+$win2 WHERE playedOn='$lastDatePlayedOn'";
        mysqli_query($conn, $sql_Update);
    } else {
        $sql_Insert = "INSERT INTO `brzi_vs_gorance` (`playedOn`, `brzi`, `gorance`) VALUES ('$currentDate', '$win1', '$win2')";
        mysqli_query($conn, $sql_Insert);
    }   
        echo "Score has been updated!";
} else {
    echo "Update your score!";
}
