
<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first ಠ_ಠ";
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <header>
        <nav>
            <a href="student_home.php">Home</a>
            <ul>
                <li><a href="uloha1/uloha1.php">Task 1</a></li>
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
        </nav>
    </header>

    <main>
        <h2>Home Page</h2>
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
            echo "<br>Your name: ".$_SESSION['user']['name'];
            echo "<br>Type of user: ".$_SESSION['user']['type_of_user'];
            ?>
        </div>
    </main>
</body>

</html>