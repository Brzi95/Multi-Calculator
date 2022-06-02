<?php

if ($_POST && $_POST['action'] == 'insertScore') {
    $currentDate = date('Y-m-d');
    // $nick1 = $_POST['nick1'];
    $win1 = $_POST['win1'];
    // $nick1 = $_POST['nick1'];
    $win2 = $_POST['win2'];
    $sql_Select = "SELECT `playedOn` 
    FROM `brzi-gorance` 
    WHERE `game-id`=(SELECT max(`game-id`) FROM `brzi-gorance`);";
    $result_Select = mysqli_query($conn, $sql_Select);
    $resultCheck_Select = mysqli_num_rows($result_Select);
    $row_Select = mysqli_fetch_assoc($result_Select);
    $lastDatePlayedOn = $row_Select['playedOn'];

    if ($lastDatePlayedOn == $currentDate) {
        $sql_Update = "UPDATE `brzi-gorance` SET brzi=brzi+$win1, gorance=gorance+$win2 WHERE playedOn='$lastDatePlayedOn'";
        mysqli_query($conn, $sql_Update);
        echo "Score has been updated!";
    } else {
        $sql_Insert = "INSERT INTO `brzi-gorance` (`playedOn`, `brzi`, `gorance`) VALUES ('$currentDate', '$win1', '$win2')";
        mysqli_query($conn, $sql_Insert);
        echo "Score has been updated!";
    }
} else {
    echo "Update your score!";
}
