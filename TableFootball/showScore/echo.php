<?php

if ($_POST && $_POST['action'] == 'showScore') {
    $id = $_POST['id'];
   // $sql = "SELECT brzi_gorance.id, user_first FROM brzi_gorance JOIN players ON brzi_gorance.id = players.id WHERE players.id = 1";
    $sql = "SELECT * FROM brzi_gorance JOIN players ON brzi_gorance.id = players.id WHERE players.id = $id";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID $id - " . $row['user_first'] . " : wins(" . $row['win'] . ") losses(" . $row['loss'] . ")" . '<br>';
    }
} else {
    echo "Enter player ID to see its score!";
    }
?>
