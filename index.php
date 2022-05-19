<?php
$page = isset($_GET['page']) ? $_GET['page'] : null;
$title = 'index';
include 'components/head.phtml';
include 'components/header.phtml';

switch ($page) {
    case 'age':
        echo 'age calculator';
        break;

    case 'friday':
        include "Friday13th/form.phtml";
        include "Friday13th/echo.php";
        break;

    case 'friday':
        echo 'friday 13th';
        break;
    
    default:
        # code...
        break;
}