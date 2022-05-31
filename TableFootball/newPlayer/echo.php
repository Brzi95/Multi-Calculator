<?php

if ($_POST && $_POST['action'] == 'addPlayer') {
    $firstName = $_POST['first'];
    $lastName = $_POST['last'];
    $dateJoined = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `players` (`user_first`, `user_last`, `dateJoined`) VALUES ('$firstName', '$lastName', '$dateJoined')";
    mysqli_query($conn, $sql);
    echo "Player has been added! <br>";
} else {
    echo "Want to join the Table Football club?";
}
