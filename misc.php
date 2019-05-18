<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include('functions.php');
if (!isLoggedIn() && !isAdmin()) {
    $_SESSION['msg'] = "You must log in first ಠ_ಠ";
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title>Ďalšie info</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>

<?php
$currentPage = "Misc";
include('navbar.php');
?>

<main>
    <div class="container">
        <h2>Ďalšie info</h2>
        <a href="https://147.175.121.210:4472/cvicenia/projekt/technicka_dokumentacia">Technická dokumentácia</a>
        <h3>Rozdelenie úloh medzi študentov</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Meno</th>
                <th>Úloha</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Dávid Zakhariás</td>
                <td>úloha 1</td>
            </tr>
            <tr>
                <td>Michal Morávek</td>
                <td>úloha 2 - pohľad študenta? </td>
            </tr>
            <tr>
                <td>Tomáš Macho</td>
                <td>úloha 3</td>
            </tr>
            <tr>
                <td>Natália Klementová</td>
                <td>prihlasovanie, spájanie/navigácia?</td>
            </tr>
            <tr>
                <td>Erik Hricka</td>
                <td>úloha 2 -  pohľad administrátora? </td>
            </tr>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
