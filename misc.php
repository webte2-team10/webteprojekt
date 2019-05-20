<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include('functions.php');
include('lang.php');    //treba includnut aj script.js

if (!isLoggedIn() && !isAdmin()) {
    $_SESSION['msg'] = _ErrorLogin;
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title><?= _TileMisc ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="scripts/js/script.js"></script>
    <link rel="icon" type="image/png" href="pics/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="pics/favicon-16x16.png" sizes="16x16" />
</head>
<body>

<?php
$currentPage = "Misc";
include('navbar.php');
?>

<main>
    <div class="container">
        <h1><?= _DalsieInfo ?></h1>
        <a href="https://147.175.121.210:4472/cvicenia/projekt/technicka_dokumentacia.pdf"><?= _TechDok?></a>
        <h3><?= _RozdelenieUloh ?></h3>
        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th><?= _Meno ?></th>
                <th><?= _Uloha?></th>
            </tr>
            <tr>
                <td>Dávid Zakhariás</td>
                <td><?= _UlohaDavid ?></td>
            </tr>
            <tr>
                <td>Michal Morávek</td>
                <td><?= _UlohaMichal ?></td>
            </tr>
            <tr>
                <td>Tomáš Macho</td>
                <td><?= _UlohaTomas ?></td>
            </tr>
            <tr>
                <td>Natália Klementová</td>
                <td><?= _UlohaNaty ?></td>
            </tr>
            <tr>
                <td>Erik Hricka</td>
                <td><?= _UholaErik ?> </td>
            </tr>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>