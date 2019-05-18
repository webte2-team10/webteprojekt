<header>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <?php if (!isAdmin()) : ?>
                    <a class="navbar-brand" href="https://147.175.121.210:4472/cvicenia/projekt/student_home.php">Webový portál študenta</a>
                <?php else  : ?>
                    <a class="navbar-brand" href="https://147.175.121.210:4472/cvicenia/projekt/admin_home.php">Webový portál admina</a>
                <?php endif ?>
            </div>
            <ul class="nav navbar-nav">
                <?php if (!isAdmin()) : ?>
                    <li <?php if ($currentPage === 'Task1') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha1/uloha1.php">Zobrazenie výsledkov</a></li>
                    <li <?php if ($currentPage === 'Task2') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha2/student_task2.php">Task 2</a></li>
                <?php else  : ?>
                    <li <?php if ($currentPage === 'Task1') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha1/uloha1.php">Zobrazenie výsledkov</a></li>
                    <li <?php if ($currentPage === 'Task2') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha2/admin_task2.php">Task 2</a></li>
                    <li <?php if ($currentPage === 'Task3') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha3/admin_task3.php">Task 3</a></li>
                <?php endif ?>
                <li <?php if ($currentPage === 'Misc') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/misc.php">Ďalšie info</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--<li><img id = "skFlag" src="https://147.175.121.210:4472/cvicenia/projekt/images/sk.png" alt="Slovenska vlajka"></li>
                <li><img id = "ukFlag" src="https://147.175.121.210:4472/cvicenia/projekt/images/uk.png" alt="Britska vlajka"></li>-->
                <li><a href="#">SK</a></li>
                <li><a href="#">EN</a></li>
                <?php if (!isAdmin()) : ?>
                    <li><a href="https://147.175.121.210:4472/cvicenia/projekt/student_home.php?logout='1'"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                <?php else  : ?>
                    <li><a href="https://147.175.121.210:4472/cvicenia/projekt/admin_home.php?logout='1'"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
</header>

