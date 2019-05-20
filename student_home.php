<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include('functions.php');
include('lang.php');    //treba includnut aj script.js


if (!isLoggedIn()) {
    $_SESSION['msg'] = _ErrorLogin;
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title><?= _TitleHome ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="scripts/js/script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <link rel="stylesheet" href="assets/css/Lightbox-Gallery.css">
    <link rel="icon" type="image/png" href="pics/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="pics/favicon-16x16.png" sizes="16x16" />
</head>
<body>

<?php
$currentPage = "Home";
include('navbar.php');
?>
    <main>
        <div class="container">
            <h1><?= _WebPortalStudent ?></h1>
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
                echo "<h3>"._MenoPrihPouz." ".$_SESSION['user']['meno']."</h3>";
                ?>
            </div>
        <h3><?= _Galeria?></h3>
        <br>
        <hr style="border-top: 2px solid #000;">
        <br>
        <br>
        <div class="photo-gallery">
            <div class="container">
                <div class="row photos">
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/1.jpg"><img class="img-responsive" src="pics/1.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/5.jpg"><img class="img-responsive" src="pics/5.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/8.jpg"><img class="img-responsive" src="pics/8.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/2.jpg"><img class="img-responsive" src="pics/2.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/3.jpg"><img class="img-responsive" src="pics/3.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/6.jpg"><img class="img-responsive" src="pics/6.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/7.jpg"><img class="img-responsive" src="pics/7.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/9.jpg"><img class="img-responsive" src="pics/9.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/11.jpg"><img class="img-responsive" src="pics/11.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/12.jpg"><img class="img-responsive" src="pics/12.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/13.jpg"><img class="img-responsive" src="pics/13.jpg"></a></div>
                    <div class="col-lg-3 col-md-4 col-sm-6 item"><a data-lightbox="photos" href="pics/4.jpg"><img class="img-responsive" src="pics/4.jpg"></a></div>
                </div>
            </div>
        </div>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/bootstrap/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
        </div>
    </main>
</body>
</html>