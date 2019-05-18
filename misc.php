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
    <title>Task 2</title>
</head>
<body>
<header>
    <nav>
        <?php if (!isAdmin()) : ?>  <!--ak je len student, tak mu zobrazi toto menu-->
            <a href="student_home.php">Home</a>
            <ul>
                <li><a href="student_task1.php">Task 1</a></li>
            </ul>
            <ul>
                <li><a href="student_task2.php">Task 2</a></li>
            </ul>
            <ul>
                <li><a href="misc.php">Choose a title</a></li>
            </ul>
            <ul>
                <li><a href="student_home.php?logout='1'">Log out</a></li>
            </ul>
        <?php else  : ?>
            <a href="admin_home.php">Home</a>
            <ul>
                <li><a href="admin_task1.php">Task 1</a></li>
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
        <?php endif ?>



    </nav>
</header>

<main>
    <h2>Choose a title</h2>



    <?php
    echo "kto co urobil a technicka dokumentacia";

    ?>





</main>
</body>
</html>