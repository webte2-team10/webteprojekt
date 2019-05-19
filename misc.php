<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include('functions.php');
include('lang.php');    //treba includnut aj script.js

if (!isLoggedIn() && !isAdmin()) {
    $_SESSION['msg'] = "You must log in first ಠ_ಠ";
    header('location: login.php');
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
</head>
<body>

<?php
$currentPage = "Misc";
include('navbar.php');
?>

<main>
    <div class="container">
        <h2><?= _DalsieInfo ?></h2>
        <a href="https://147.175.121.210:4472/cvicenia/projekt/technicka_dokumentacia"><?= _TechDok?></a>
        <h3><?= _RozdelenieUloh ?></h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?= _Meno ?></th>
                <th><?= _Uloha?></th>
            </tr>
            </thead>
            <tbody>
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
