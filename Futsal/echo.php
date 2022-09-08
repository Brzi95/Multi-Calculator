<?php

include 'SearchTool.php';

if ($_POST) {
    $search_for = $_POST['word'];
    $text = $_POST['textarea'];
    
    $searchTool = new SearchTool($search_for, $text);
    echo $searchTool->calcMethod();
} else {
    echo "SEARCH SPECIFIC WORDS IN TEXT !";
}
