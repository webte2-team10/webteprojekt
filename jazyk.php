<?php

///SETUP SLOV
function setupWebLanguage(){

    //words
    $wPhase = array("Generovanie a odosielanie prístupových údajov","Generate and send access data");
    $wFirstPhase = array("Generovanie hesiel","Password generator");
    $wFile1 = array("CSV súbor","CSV file");
    $wSeparator = array("Oddelovač","Separator");
    $wGenerate = array("Generovať","Generate");

    if($_SESSION["language"] != "en"){
        $pli = 0;   //na 0. indexe je sj
    } else {
        $pli = 1;   //na 1. indexe je aj
    }
    //key => value
    //asociativne pole
    $PL = array("wPhase" => $wPhase[$pli],
        "wFirstPhase" => $wFirstPhase[$pli],
        "wFile1" => $wFile1[$pli],
        "wSeparator" => $wSeparator[$pli],
        "wGenerate" => $wGenerate[$pli]);

    return $PL;
}

?>

<?php

session_start();

$logIn = true;

if($_SESSION["language"] != "en"){
    $language = "sk";
} else {
    $language = "en";
}

//if admin is not logIn
if($logIn != true){
    header("location:login.php");
    die();
}

//nacitam si
$PL = setupWebLanguage();
?>


<a><?php echo $PL["wFirstPhase"];?></a>




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
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>
<main>

    <div id = "flags">
        <img id = "skFlag" src="sk.png" alt="Slovenska vlajka" height="23" width="23">
        <img id = "ukFlag" src="uk.png" alt="Britska vlajka" height="23" width="23">
    </div>


    <script>


    </script>



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