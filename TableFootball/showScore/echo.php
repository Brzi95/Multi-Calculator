<?php

if ($_POST && $_POST['action'] == 'showScore') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM brzi_gorance WHERE brzi_gorance.id='$id'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Player $id : wins(" . $row['win'] . ") losses(" . $row['loss'] . ")" . '<br>';
        }
           // echo '<br>'. $resultCheck;  row numbers
    }  
} else {
    echo "Enter player ID to see its score!";
    }

?>
