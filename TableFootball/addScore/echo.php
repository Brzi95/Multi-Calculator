<?php

if ($_POST && $_POST['action'] == 'addScore') {
    $id = $_POST['id'];
    $win = $_POST['win'];
    $loss = $_POST['loss'];
    $sql = "UPDATE `brzi_gorance` SET win=win+$win, loss=loss+$loss WHERE brzi_gorance.id='$id'";
    mysqli_query($conn, $sql);
    echo "Score has been updated! <br>";
} else {
    echo "Update your score!";
}
