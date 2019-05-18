<?php
//dat na zaciatok stranok, ktore maju byt pristupne len pre admina
include('functions.php');
if (!isAdmin()) {
    if(isLoggedIn()){           //ak sa snazi stranku admina spristupnit student, tak ho pred
        session_destroy();      //presmerovanim odhlasi
        unset($_SESSION['user']);
    }
    $_SESSION['msg'] = "You must log in first ಠ_ಠ";
    header('location: login.php');
}

?>



<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title>Task 1</title>
</head>
<body>
<header>
    <nav>
        <a href="admin_home.php">Home</a>
        <ul>
            <li><a href="uloha1/uloha1.php">Task 1</a></li>
        </ul>
        <ul>
            <li><a href="admin_task2.php">Task 2</a></li>
        </ul>
        <ul>
            <li><a href="admin_task3.php">Task 3</a></li>
        </ul>
        <ul>
            <li><a href="misc.php">Choose a title</a></li>
        </ul>
        <ul>
            <li><a href="admin_home.php?logout='1'">Log out</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Task 1</h2>





</main>
</body>
</html>