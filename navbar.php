

<header>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <?php if (!isAdmin()) : ?>
                    <a class="navbar-brand" href="https://147.175.121.210:4472/cvicenia/projekt/student_home.php"><?= _WebPortalStudent ?></a>
                <?php else  : ?>
                    <a class="navbar-brand" href="https://147.175.121.210:4472/cvicenia/projekt/admin_home.php"><?= _WebPortalAdmin ?></a>
                <?php endif ?>
            </div>
            <ul class="nav navbar-nav">
                <?php if (!isAdmin()) : ?>
                    <li <?php if ($currentPage === 'Task1') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha1/uloha1.php"><?= _Task1Student ?></a></li>
                    <li <?php if ($currentPage === 'Task2') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha2/student_task2.php"><?= _Task2Student ?></a></li>
                <?php else  : ?>
                    <li <?php if ($currentPage === 'Task1') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha1/uloha1.php"><?=  _Task1Admin ?></a></li>
                    <li <?php if ($currentPage === 'Task2') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha2/admin_task2.php"><?= _Task2Admin ?></a></li>
                    <li <?php if ($currentPage === 'Task3') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/uloha3/admin_task3.php"><?= _Task3Admin ?></a></li>
                <?php endif ?>
                <li <?php if ($currentPage === 'Misc') {echo 'class="active"';} ?>><a href="https://147.175.121.210:4472/cvicenia/projekt/misc.php"><?= _DalsieInfo ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--<li><img id = "skFlag" src="https://147.175.121.210:4472/cvicenia/projekt/images/sk.png" alt="Slovenska vlajka"></li>
                <li><img id = "ukFlag" src="https://147.175.121.210:4472/cvicenia/projekt/images/uk.png" alt="Britska vlajka"></li>-->
<!--                <li><a id = "skFlag" href="#">SK</a></li>-->
<!--                <li><a id = "ukFlag" href="#">EN</a></li>-->
                <li style="margin-top: 7px;"><form method='get' action='' id='form_lang' >
                    <select class="form-control" name='lang' onchange='changeLang();' >
                        <option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >EN</option>
                        <option value='sk' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'sk'){ echo "selected"; } ?> >SK</option>
                    </select>
                </form></li>
                <?php if ($currentPage === 'Login') : ?>
                    <li><a href="https://147.175.121.210:4472/cvicenia/projekt/index.php"><span class="glyphicon glyphicon-log-in"></span> <?= _TlacidloPrihlasit ?></a></li>
                <?php elseif(!isAdmin()) : ?>
                    <li><a href="https://147.175.121.210:4472/cvicenia/projekt/student_home.php?logout='1'"><span class="glyphicon glyphicon-log-out"></span> <?= _Odhlasit ?></a></li>
                <?php else  : ?>
                    <li><a href="https://147.175.121.210:4472/cvicenia/projekt/admin_home.php?logout='1'"><span class="glyphicon glyphicon-log-out"></span> <?= _Odhlasit ?></a></li>
                <?php endif ?>
            </ul>
        </div>
    </nav>





</header>

