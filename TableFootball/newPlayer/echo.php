<?php

if ($_POST && $_POST['action'] == 'addPlayer') {
    $firstName = $_POST['first'];
    $lastName = $_POST['last'];
    $nickName = strtolower($_POST['nick']);
    $dateJoined = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `Players` (`first_name`, `last_name`, `nick_name`, `dateJoined`) VALUES ('$firstName', '$lastName', '$nickName', '$dateJoined')";
    mysqli_query($conn, $sql);
    echo "Player has been added! <br>";

    // Players table - visible before submiting the form
} else {
    $sql_column_names = "SELECT COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_NAME='Players'";
    $result_column_names = mysqli_query($conn, $sql_column_names);
        echo '<table class="border">';
        echo    '<tr>';
        while ($row_column_names = mysqli_fetch_assoc($result_column_names)) {
            echo    "<th>" . $row_column_names['COLUMN_NAME'] . "</th>";
        }
        echo    "</tr>";

    $sql_Players_Table = "SELECT * FROM `Players`";
    $players_Table_Result = mysqli_query($conn, $sql_Players_Table);
    while ($row_Players_Table = mysqli_fetch_assoc($players_Table_Result)) {
        echo    "<tr>";
        echo        "<td>" . $row_Players_Table['player_id'] . "</td>";
        echo        "<td>" . $row_Players_Table['first_name'] . "</td>";
        echo        "<td>" . $row_Players_Table['last_name'] . "</td>";
        echo        "<td>" . $row_Players_Table['dateJoined'] . "</td>";
        echo        "<td>" . $row_Players_Table['nick_name'] . "</td>";
        echo    "</tr>";
    }
        echo "</table>";

    echo "<br><br><br>
          Want to join the Table Football club?";
}

