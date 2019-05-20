<?php
//dat na zaciatok stranok, ktore maju byt pristupne len pre admina
include "../functions.php";
include('../lang.php');             //treba includnut aj script.js
include('../config.php');

if (!isAdmin()) {
    if(isLoggedIn()){           //ak sa snazi stranku admina spristupnit student, tak ho pred
        session_destroy();      //presmerovanim odhlasi
        unset($_SESSION['user']);
    }
    $_SESSION['msg'] = _ErrorLogin;
    header('location: https://147.175.121.210:4472/cvicenia/projekt/index.php');
}

// Include Language file
if(isset($_SESSION['lang'])){
    include "u3_lang_".$_SESSION['lang'].".php";
    include "../lang_".$_SESSION['lang'].".php";    //pre navbar

}else{
    include "u3_lang_en.php";
    include "../lang_en.php";   //pre navbar
}

// connect to the mysql database
$link = mysqli_connect($servername,$username,$password,$dbname);
mysqli_set_charset($link,'utf8');

if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}

?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title><?= _Task3Admin ?></title>
    <link rel="icon" type="image/png" href="../pics/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../pics/favicon-16x16.png" sizes="16x16" />
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/js/script.js"></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
    <script>tinymce.init({mode : "specific_textareas",
                        editor_selector : "mceEditor",
                        height : "400",
                        plugins: "autoresize"});</script>

    <link rel="stylesheet" type="text/css" href="mailStyle.css"/>
    <link rel="stylesheet" type="text/css" href="loading.css"/>

    <!-- MDBootstrap Datatables  -->
  <link href="datatables.min.css" rel="stylesheet">

</head>
<body>

<?php
$currentPage = "Task3";
include('../navbar.php');
?>

<h2 id='firstSubtitle'><?= _Phase ?></h2>

<div class="webBodyContent">
<p>
<a class="btn btn-primary" data-toggle="collapse" href="#dbLoginCollapse" role="button" aria-expanded="false" aria-controls="dbLoginCollapse"><?= _FirstPhase?></a>
</p>
<div class="row">
  <div class="col bunka">
    <div class="collapse multi-collapse" id="dbLoginCollapse">
      <div id = 'generateFormDiv' class="card card-body">
        
        <form id="upload1Form" action ="https://147.175.121.210:4472/cvicenia/projekt/uloha3/mailApi.php/addPasswords" method = "POST" role="form">
        <div class="form-group">
        <label for="subor1"><?= _File1?></label>
        <input type="file" class = "form-control" name="subor1" id="subor1" required>
        </div>
        <div class="form-group">
        <label for="idecko2"><?= _Separator?></label>
        <textarea name="separator1" class="form-control" id="idecko2" rows="1" required></textarea>
        </div>

        <button type="submit" class="btn btn-info"><?= _Generate?></button>
        </form>

      </div>
    </div>
  </div>
</div>

<p>
<a class="btn btn-primary" data-toggle="collapse" href="#dbLoginCollapse2" role="button" aria-expanded="false" aria-controls="dbLoginCollapse2"><?= _SecondPhase?></a>
</p>
<div class="row">
  <div class="col bunka">
    <div class="collapse multi-collapse" id="dbLoginCollapse2">
      <div id = 'generateFormDiv2' class="card card-body">
        <p class = 'hlasky'><?= _Warning1?></p>
        <form id="upload2Form" action ="https://147.175.121.210:4472/cvicenia/projekt/uloha3/mailApi.php/sendMails" method = "POST" role="form">
        <div class="form-group">
        <label for="subor2"><?= _File1?></label>
        <input type="file" class = "form-control" name="subor2" id="subor2" required>
        </div>
        <div class="form-group">
        <label for="separator2"><?= _Separator?></label>
        <textarea name="separator2" class="form-control" id="separator2" rows="1" required></textarea>
        </div>
        <div class="form-group">
        <label for="formNazov"><?= _TitleMail?></label>
        <textarea name="separator1" class="form-control" id="formNazov" rows="1" required></textarea>
        </div>
        <div class="form-group">
        <label for="formMeno"><?= _Name?></label>
        <textarea name="separator1" class="form-control" id="formMeno" rows="1" required></textarea>
        </div>
        <div class="form-group">
        <label for="formEmail"><?= _Sender?></label>
        <textarea name="separator1" class="form-control" id="formEmail" rows="1" required></textarea>
        </div>
        <div class="form-group">
        <label for="formHeslo"><?= _Password;?></label>
        <input type="password" class="form-control" name ="heslo" id="formHeslo" required>
        </div>
        <div class="form-group">
        <label for="subor3"><?= _File2;?></label>
        <input type="file" class = "form-control" name="subor3" id="subor3">
        </div>
        <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitches">
        <label class="custom-control-label" for="customSwitches"><?= _HTML?></label>
        </div>
        <div class="form-group">
        <label for="formObsah"><?= _Content?></label>
        <button type="button" class="btn btn-secondary" id = "resetPreset"><?= _Reset?></button>
        <textarea name="separator1" class="form-control mceEditor" id="formObsah" rows="1" required></textarea>
        </div>
        <button type="submit" class="btn btn-info"><?= _Send?></button>
        </form>

      </div>
    </div>
  </div>
</div>

<p>
<a class="btn btn-primary" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="dbLoginCollapse"><?= _History?></a>
</p>
<div class="row">
  <div class="col bunka">
    <div class="collapse multi-collapse" id="collapse3">
      <div id = 'generateFormDiv' class="card card-body">
        
        <div id="tableDiv">
            <table id="dtBasicExample" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                    <th class="th-sm"><?= _slovo1?>
                    </th>
                    <th class="th-sm"><?= _slovo2?>
                    </th>
                    <th class="th-sm"><?= _slovo3?>
                    </th>
                    </tr>
                </thead>
                <tbody id = 'tableBody'>

                </tbody>
            </table>
        </div>

      </div>
    </div>
  </div>
</div>

</body>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.js"></script>
<script type="text/javascript" src="datatables.min.js"></script>
<script src="mail.js"></script>
</html>