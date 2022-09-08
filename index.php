<?php
$page = isset($_GET['page']) ? $_GET['page'] : null;

include 'components/head.phtml';
include 'components/header.phtml';
include 'components/sidebar.phtml';

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

    case 'tablefootball':
        $form = "TableFootball/form.phtml";
        $echo = "TableFootball/echo.php";
        include "components/index_table_football.phtml";
        break;

    case 'futsal':
        $form = "Futsal/form.phtml";
        $echo = "Futsal/echo.php";
        include "components/content_div.phtml";
        break;

    case 'searchtool':
        $form = "SearchTool/form.phtml";
        $echo = "SearchTool/echo.php";
        include "components/content_div.phtml";
        break;
    
    default:
        echo "WELCOME TO THE MULTICALCULATOR!";
        break;
}

echo "<br>";



include 'components/footer.phtml';
