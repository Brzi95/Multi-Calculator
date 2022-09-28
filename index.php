<?php
$page = $_GET['page'] ?? NULL;
include 'databases/mali_Fudbal_DB.php';
include 'components/head.phtml';
include 'components/header.phtml';

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
        $form_statistics = "Futsal/statistics/form.phtml";
        $echo_statistics = "Futsal/statistics/echo.php";
        $form_statistics_2 = "Futsal/statistics/form2.phtml";
        $echo_statistics_2 = "Futsal/statistics/echo2.php";
        $form_new_match = "Futsal/new_match/form.phtml";
        $echo_new_match = "Futsal/new_match/echo.php";
        include "components/index_futsal.phtml";
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
