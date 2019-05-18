<!--anglicka verzia, nezabudnut pri dvojjazycnom zmenit-->
<!--v elementoch su boostrap triedy, mozno vymazat-->

<?php include('functions.php');

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
    <title>Log in</title>
</head>
<body>
<main>
    <?php if (isset($_SESSION['msg'])) : ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            ?>
        </div>
    <?php endif ?>

    <h2>Log in</h2>
    <form id = "form_lgn" action = "login.php" method="post">

        <?php echo display_error(); ?>

        <div class="form-group" id = "div_usr">
            <label for="usr">Login:</label>     <!--for = id-->
            <input type="text" class="form-control" id="usr" placeholder="Enter user name" name="username">
        </div>
        <div class="form-group" id = "div_pwd">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
        </div>
        <input type = "submit" name ="btn_lgn" value = "Log in" class="btn btn-default">
    </form>
</main>



</body>
</html>