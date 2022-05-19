<?php
$page = isset($_GET['page']) ? $_GET['page'] : null;
$title = 'index';
include 'components/head.phtml';
include 'components/header.phtml';
include 'components/sidebar.phtml';

if (!isset($_GET['page'])) {
    echo "WELCOME TO THE MULTI CALCULATOR!";
}


switch ($page) {
    case 'age':
        $form = "AgeCalculator/form.phtml";
        $echo = "AgeCalculator/echo.php";
        include "components/content_div.phtml";
        break;

    case 'friday':
        $form = "Friday13th/form.phtml";
        $echo = "Friday13th/echo.php";
        include "components/content_div.phtml";
        break;

    case 'birthday':
        $form = "BirthdayCounter/form.phtml";
        $echo = "BirthdayCounter/echo.php";
        include "components/content_div.phtml";
        break;
    
    default:
        # code...
        break;
}

include 'components/footer.phtml';