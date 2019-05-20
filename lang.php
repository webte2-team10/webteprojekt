<?php

// Set Language variable
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];

    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}

// Include Language file
if(isset($_SESSION['lang'])){
    include "lang_".$_SESSION['lang'].".php";
    //header('location: https://147.175.121.210:4472/cvicenia/projekt/lang_'.$_SESSION['lang'].'.php');

}else{
    include "lang_en.php";
    //header('location: https://147.175.121.210:4472/cvicenia/projekt/lang_en.php');
}