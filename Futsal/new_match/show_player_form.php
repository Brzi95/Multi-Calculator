<?php
include '../../databases/mali_Fudbal_DB.php';

$sql_select_match = "SELECT first_name, last_name, goals, g.player_id, p.player_id AS pp_id, team_id FROM players p
LEFT JOIN live_game g ON p.player_id = g.player_id
WHERE team_id IS NULL -- select players who aren't in a team
ORDER BY first_name";
if ($result = mysqli_query($conn2, $sql_select_match)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['pp_id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];

            $return_arr[] = array(
                "id" => $id,
                "first_name" => $first_name,
                "last_name" => $last_name
            );
        }
        echo json_encode($return_arr);
    }
}

?>
