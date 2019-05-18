<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first ಠ_ಠ";
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>

<?php
$currentPage = "Home";
include('navbar.php');
?>

    <main>
        <div class="container">
            <h2>Webový portál študenta</h2>
            <!-- notification message -->
            <?php if (isset($_SESSION['success'])) : ?>
                <div>
                    <h3>
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>
            <!-- logged in user information -->
            <div>
                <?php
                echo "<br>Meno prihláseného používateľa: ".$_SESSION['user']['name'];
                ?>
            </div>
        </div>
    </main>
</body>
</html>
