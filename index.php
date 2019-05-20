<?php
include('functions.php');
include('lang.php');    //treba includnut aj script.js


//ak je uz pouzivatel prihlaseny, tak mu nebude spristupnena stranka na prihlasenie sa
if(isLoggedIn()){
    if (isAdmin()) {
        header('location: admin_home.php');
    }
    else{
        header('location: student_home.php');
    }
}
?>

<!doctype html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title><?= _TitleLogin ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="scripts/js/script.js"></script>
    <link rel="icon" type="image/png" href="pics/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="pics/favicon-16x16.png" sizes="16x16" />
</head>
<body>
<?php
$currentPage = "Login";
include('navbar.php');
?>
<?php if (isset($_SESSION['msg'])) : ?>
    <div class="alert alert-danger">
        <?php
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        ?>
    </div>
<?php endif ?>

<?php echo display_error(); ?>


<main>
    <div class="container">
    <h2><?= _Prihlasit ?></h2>
    <form id = "form_lgn" action = "index.php" method="post">

        <div class="form-group" id = "div_usr">
            <label for="usr"><?= _Login ?></label>     <!--for = id-->
            <input type="text" class="form-control" id="usr" placeholder="<?= _LoginPlaceholder ?>" name="username">
        </div>
        <div class="form-group" id = "div_pwd">
            <label for="pwd"><?= _Password ?></label>
            <input type="password" class="form-control" id="pwd" placeholder="<?= _PwdPlaceholder ?>" name="password">
        </div>
        <input type = "submit" name ="btn_lgn" value = "<?= _TlacidloPrihlasit ?>" class="btn btn-default">
    </form>
    </div>
</main>



</body>
</html>