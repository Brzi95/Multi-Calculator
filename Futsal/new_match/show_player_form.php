<?php
// header('Content-Type: application/json; charset=utf-8');
include '../../databases/mali_Fudbal_DB.php';


$sql_select_match = "SELECT p.first_name, p.last_name, p.nick_name, p.player_id AS pp_id 
FROM futsal_players p
LEFT JOIN futsal_live_game l
ON p.player_id = l.player_id
WHERE team_id IS NULL
ORDER BY p.nick_name"
;
if ($result = mysqli_query($conn2, $sql_select_match)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['pp_id'];
            $nick_name = $row['nick_name'];

            $return_arr[] = array(
                "id" => $id,
                "nick_name" => $nick_name
            );
        }
        echo json_encode($return_arr);
    }
}

?>
