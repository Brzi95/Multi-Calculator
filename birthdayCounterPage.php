<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="website.css">
    <title>Birthday Counter</title>
</head>
<body>
<?php
include 'header, footer, sidebar/header.php';
include 'header, footer, sidebar/sidebar.php';
?>

<div class="content-container">
    <div class="form-container">
                <div class="form-input">
                    <?php include 'BirthdayCounter/form.phtml'; ?>
                </div>
                <div class="echo-result">
                    <?php include 'BirthdayCounter/echo.php'; ?>
                </div>            
    </div>
</div>

<?php
include 'header, footer, sidebar/footer.php';
?>
</body>
</html>