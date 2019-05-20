<?php
//dat na zaciatok stranok, ktore maju byt pristupne len pre admina
include "../functions.php";
include('../lang.php');
include "config.php";

if (!isAdmin()) {
    if(isLoggedIn()){          //ak sa snazi stranku admina spristupnit student, tak ho pred
        session_destroy();      //pressmerovanim odhlasi
        unset($_SESSION['user']);
    }
    $_SESSION['msg'] = "You must log in first ಠ_ಠ";
    header('location: https://147.175.121.210:4472/cvicenia/projekt/login.php');
}
include('../lang.php');

?>



<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title> <?php echo($_SESSION["lang"] == "sk") ? 'Úloha 2' : 'Task 2' ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../scripts/js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

</head>
<body>

<?php
$currentPage = "Task2";
include('../navbar.php');
?>

<main>

    <h2><title> <?php echo($_SESSION["lang"] == "sk") ? 'Úloha 2' : 'Task 2' ?></title></h2>

</main>

<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <label for="sel1"><?php echo($_SESSION["lang"] == "sk") ? 'Školský rok :' : 'Academic year :' ?></label>
                <select class="form-control" name="skolsky_rok">
                    <option>2018/2019</option>
                    <option>2017/2018</option>
                    <option>2016/2017</option>
                    <option>2015/2016</option>
                </select>

            </div>
            <div class="col-sm-4">
                <label for="usre"><?php echo($_SESSION["lang"] == "sk") ? 'Názov predmetu' : 'Course name' ?></label>
                <input type="text" class="form-control" name="predmet">
            </div>
            <div class="col-sm-4">
                <label for="usr"><?php echo($_SESSION["lang"] == "sk") ? 'Oddelovač v CSV subore' : 'CSV file delimiter' ?></label>
                <input type="text" class="form-control" name="oddelovac" id="oddelovac">
            </div>
        </div>
        <br>
        <div class="row">
            <div align="center">
                <div class="file-field">
                    <div class="btn btn-primary btn-sm float-left">
                        <span>Choose file</span>
                        <input type="file" name="file" />
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div align="center">
                <button type="submit" name="submit" value="Import" class="btn-primary" ><?php echo($_SESSION["lang"] == "sk") ? 'Nahrat' : 'Upload' ?> </button>
            </div>
        </div>
    </form>
</div>
<br><br>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <div class="row">
            <div class="col-sm-6">
                <label for="skolsky_rok"><?php echo($_SESSION["lang"] == "sk") ? 'Školský rok :' : 'Academic year :' ?></label>
                <select class="form-control" name="skolsky_rok" onchange="getPredmet(this.value);">
                    <option value="2018/2019">2018/2019</option>
                    <option value="2017/2018">2017/2018</option>
                    <option value="2016/2017">2016/2017</option>
                    <option value="2015/2016">2015/2016</option>
                </select>
            </div>
            <div class="col-sm-6">
                <label for="predmet"><?php echo($_SESSION["lang"] == "sk") ? 'Predmety :' : 'Subjects :' ?></label>
                <select name='predmet' id="predmet" class="form-control">
                    <option value=""><?php echo($_SESSION["lang"] == "sk") ? 'Vyber predmet :' : 'Select subject :'?></option>
                </select>
            </div>
        </div>
        <br>
        <br>

        <div class="row">
            <div align="center">
            <button type="submit" name="dalsi" value="tabulky" class="btn-primary"><?php echo($_SESSION["lang"] == "sk") ? 'Zobraz' : 'Show'?> </button>
            </div>
        </div>
    </form>
    <?php
    if(isset($_POST['export'])){
        include_once "config.php";
        $connect = new mysqli($servername, $username, $password, $databaza);
        $connect->set_charset('utf8');
        $rok=$_GET['skolsky_rok'];
        $predmet=$_GET['predmet'];
        $sql="SELECT id FROM predmet WHERE nazov='$predmet' AND rok='$rok'";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        $predmetID=$row['id'];
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=uloha2export.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('ID', 'Meno', 'Body'));
        $query = "SELECT student.id, student.meno_studenta, zaznam.body_stud from student INNER JOIN zaznam ON student.id=zaznam.id_student WHERE zaznam.id_predmet='$predmetID' ORDER BY zaznam.id ASC";
        $result = mysqli_query($connect, $query);
        while($row = mysqli_fetch_assoc($result))
        {
            fputcsv($output, $row);
        }
        fclose($output);
        ob_flush();
        exit();
    }

    if(isset($_POST['sumbit_body'])){
        include_once "config.php";
        $connect = new mysqli($servername, $username, $password, $databaza);
        $connect->set_charset('utf8');
        $cislo_tim=$_POST['tim'];
        $predmet=$_POST['predmet'];
        $rok=$_POST['rok'];
        $body=$_POST['body'];

        $sql = "UPDATE team 
 		INNER JOIN predmet ON predmet.id = team.id_predmet 
        SET team.body='$body' 
        WHERE predmet.nazov='$predmet' AND team.cislo='$cislo_tim' AND predmet.rok='$rok'";

        $result = mysqli_query($connect, $sql);
    }

    if(isset($_POST['sumbit_body_admin'])){
        include_once "config.php";
        $connect = new mysqli($servername, $username, $password, $databaza);
        $connect->set_charset('utf8');
        $tim=$_POST['tim'];
        $predmet=$_POST['predmet'];
        $rok=$_POST['rok'];

        $sql="UPDATE team 
 		INNER JOIN predmet ON predmet.id = team.id_predmet 
        SET team.suhlas=1 
        WHERE predmet.nazov='$predmet' AND team.cislo='$cislo_tim' AND predmet.rok='$rok'";

        $result = mysqli_query($connect, $sql);
    }

    if(!empty($_POST['suhlas'])) {
        include_once "config.php";
        $connect = new mysqli($servername, $username, $password, $databaza);
        $connect->set_charset('utf8');
        $idTim = $_POST['timID'];
        $suhlas = $_POST['suhlas'];
        $sql = "UPDATE team SET suhlas = '$suhlas' WHERE team.id = '$idTim'";
        $result = mysqli_query($connect, $sql);
    }


    //zobrazovani timov vybraneho roku a predmetu
    if(isset($_GET['dalsi'])) {
        include_once "config.php";
        $connect = new mysqli($servername, $username, $password, $databaza);
        $connect->set_charset('utf8');
// Check connection
        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        $rok = $_GET['skolsky_rok'];
        $predmet = $_GET['predmet'];

        echo "<h2>" . $predmet . " " . $rok . "</h2>";

        $sql = "SELECT * FROM zaznam 
            INNER JOIN predmet ON predmet.id = zaznam.id_predmet 
            INNER JOIN student ON student.id = zaznam.id_student
            INNER JOIN team ON team.id = zaznam.id_team
          WHERE predmet.nazov='$predmet' AND predmet.rok = '$rok'
          ORDER BY team.cislo ASC";


        //premenne na zistenie ci je uz iny tim
        $aktualny_team = null;
        $Predchadzajuci_team = null;

        //premenna do ktorej sa uklada vypis
        $toPrint = "";

        //vypisanie timov daneho predmetu, strasne nepekna vec, nic lepsi mna nenapadlo
        $result = $connect->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $Udelenie_bodov = "";
                $Odsuhlasenie_bodov = "";
                $aktualny_team = $row['cislo'];
                $meno_studenta = $row['meno'];
                $email = $row['email'];
                $body = $row['body_stud'];
                $suhlas = $row['suhlas_stud'];
                $teamove_body = $row['body'];
                $suhlas_admina = $row['suhlas'];
                $hidden = '';

                /*if ($teamove_body != 0 && $teamove_body != null) {
                    $Udelenie_bodov = "disabled";
                }*/

                //suhlas clenov timov --> suhlas admina povoleny
                $sql2 = "SELECT * FROM zaznam 
                            INNER JOIN predmet ON predmet.id = zaznam.id_predmet 
                            INNER JOIN student ON student.id = zaznam.id_student
                            INNER JOIN team ON team.id = zaznam.id_team
                        WHERE predmet.nazov='$predmet' AND predmet.rok = '$rok' AND team.cislo='$aktualny_team'
                        ORDER BY team.cislo ASC";

                $result2 = $connect->query($sql2);
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $suhlasyClenov = $row['suhlas_stud'];
                        $suhlasAdmina = $row['suhlas'];
                        $idTim = $row['id_team'];

                        if ($suhlasyClenov == 0 || $suhlasyClenov == 2) {
                            $hidden = 'hidden';
                        }
                        switch($suhlasAdmina){
                            case "0":
                                $toPrintBasic ="<div $hidden>
                           <button onclick='postSuhlas(1, $idTim);' style='display: inline-block' id='suhlas_btn' class='btn btn-primary'>Súhlasím s bodmi</button>
                           <button onclick='postSuhlas(2, $idTim);' style='display: inline-block' id='nesuhlas_btn' class='btn btn-primary'>Nesúhlasím s bodmi</button></div>";
                                break;
                            case "1":
                                $toPrintBasic = "
                           <i style='color: #4d8056 ;' class='fa fa-thumbs-up'></i>
                           <div style='color: #4d8056;display: inline-block'>Odsúhlasené</div>";
                                break;
                            case "2":
                                $toPrintBasic ="
                           <i style='color: #803024 ;' class='fa fa-thumbs-down'></i>
                           <div style='color: #803024;display: inline-block'>Nesúhlasím s rozdelením bodov.</div>";
                                break;
                        }

                    }
                }

                if ($Predchadzajuci_team != $aktualny_team) {

                    echo "<table class='table table-bordered' id='zotriedena'><br><br><label>Team " . $aktualny_team."<br>";
                    echo "Body tímu:".$teamove_body."</label><br>";
                    echo "<form action='" . $_SERVER['REQUEST_URI'] . "' method='post' enctype='multipart/form-data'>
               <input type='number' name='body' placeholder='Body pre team' min='0'>
               <input type='text' name='tim' value='$aktualny_team' hidden>
               <input type='text' name='rok' value='$rok' hidden>
               <input type='text' name='predmet' value='$predmet' hidden><br>
               <button type='submit' name='sumbit_body' class='btn btn-primary' $Udelenie_bodov >";echo($_SESSION["lang"] == "sk") ? 'Prideliť body teamu' : 'Allocate points for team';echo"</button>
                </form><br>".$toPrintBasic;

                    echo"<table class='table table-bordered'>
               <thead class='thead-dark'>
                   <tr>
                       <th scope='col' class=\"col-md-3\">Email</th>
                       <th scope='col' class=\"col-md-4\">";echo($_SESSION["lang"] == "sk") ? 'Meno' : 'Name';echo"</th>
                       <th scope='col' class=\"col-md-2\">";echo($_SESSION["lang"] == "sk") ? 'Body' : 'Points';echo"</th>
                       <th scope='col' class=\"col-md-2\">";echo($_SESSION["lang"] == "sk") ? 'Súhlas' : 'Approval';echo"</th>
                   </tr>
               </thead>";
                    $Predchadzajuci_team = $aktualny_team;
                }


                echo "<tr><td>" . $email . "</td><td>" . $meno_studenta . "</td><td>" . $body . "</td>";
                switch ($suhlas) {
                    case "0":
                        echo "<td><div style='color: #7b8080;'>";echo($_SESSION["lang"] == "sk") ? 'Nepotvrdil body' : 'No accept point';echo"</div></td></tr>";
                        break;
                    case "1":
                        echo "<td><i style='color: #4d8056 ;' class='fa fa-thumbs-up'></i></td></tr>";
                        break;
                    case "2":
                        echo "<td><i style='color: #803024 ;' class='fa fa-thumbs-down'></i></td></tr>";
                        break;
                };
            }

        }


        echo "<table class='table table-bordered' id='zotriedena'><thead><tr><th>";echo($_SESSION["lang"] == "sk") ? 'Počet študentov' : 'Number of students';echo"</th><th>";echo($_SESSION["lang"] == "sk") ? 'Počet odsúhlasených' : 'Number of approved';echo"</th><th>";echo($_SESSION["lang"] == "sk") ? 'Počet nesúhlasiacich' : 'Number of disagreements';echo"</th><th>";echo($_SESSION["lang"] == "sk") ? 'Počet nevyjadrených' : 'Number of unexpressed';echo"</th></tr></thead><tbody>";
        echo "<tr>";
        $sql = "SELECT id FROM predmet WHERE predmet.nazov = '$predmet' AND predmet.rok = '$rok'";
        $result2 = $connect->query($sql);
        $row = $result2->fetch_assoc();
        $vysledok_id = $row["id"];
        $sql = "SELECT id FROM zaznam WHERE zaznam.id_predmet = '$vysledok_id'";
        $result2 = $connect->query($sql);
        $kolko = $result2->num_rows;
        echo "<td>" . $kolko . "</td>";
        $sql = "SELECT id FROM zaznam WHERE zaznam.id_predmet = '$vysledok_id' AND zaznam.suhlas_stud = '1'";
        $result2 = $connect->query($sql);
        $pocet = $result2->num_rows;
        echo "<td>" . $pocet . "</td>";
        $sql = "SELECT id FROM zaznam WHERE zaznam.id_predmet = '$vysledok_id' AND zaznam.suhlas_stud = '2'";
        $result2 = $connect->query($sql);
        $pocet2 = $result2->num_rows;
        echo "<td>" . $pocet2 . "</td>";
        $sql = "SELECT id FROM zaznam WHERE zaznam.id_predmet = '$vysledok_id' AND zaznam.suhlas_stud = '0'";
        $result2 = $connect->query($sql);
        $pocet3 = $result2->num_rows;
        echo "<td>" . $pocet3 . "</td>";
        echo "</tr>";
        echo "</tbody></table>";
        echo "<br><br>";

        $dataPoints = array(
            array("label" => ($_SESSION["lang"] == "sk") ? 'Súhlasiaci' : 'Acquiescent', "y" => (($pocet / $kolko) * 100)),
            array("label" => ($_SESSION["lang"] == "sk") ? 'Nesúhlasiaci' : 'Disagreeing', "y" =>(($pocet2 / $kolko) * 100)),
            array("label" => ($_SESSION["lang"] == "sk") ? 'Nevyjadrení' : 'Unspoken', "y" => (($pocet3 / $kolko) * 100))
        );

        echo "<div id='chartContainer' style='height: 370px; width: 100%;'></div>";

        echo "<table class='table table-bordered' id='zotriedena'><thead><tr><th>";echo($_SESSION["lang"] == "sk") ? 'Počet teamov' : 'Number of teams';echo"</th><th>";echo($_SESSION["lang"] == "sk") ? 'Počet uzavretých' : 'Number of closed';echo"</th><th>";echo($_SESSION["lang"] == "sk") ? 'Tímy, ku ktorým sa vyjadriť' : 'Teams to comment on';echo"</th><th>";echo($_SESSION["lang"] == "sk") ? 'Počet nevyjadrených tímov' : 'Number of unspoken teams';echo"</th></tr></thead><tbody>";
        echo "<tr>";
        $sql = "SELECT * FROM team, predmet WHERE predmet.nazov='$predmet' AND predmet.rok = '$rok' AND predmet.id = team.id_predmet ";
        $result = $connect->query($sql);
        $kolko = $result->num_rows;
        echo "<td>" . $kolko . "</td>";
        $sql = "SELECT * FROM team, predmet WHERE predmet.nazov='$predmet' AND predmet.rok = '$rok' AND predmet.id = team.id_predmet AND team.suhlas='1' ";
        $result = $connect->query($sql);
        $nieco = $result->num_rows;
        echo "<td>" . $nieco . "</td>";
        $sql = "SELECT * FROM team, predmet WHERE predmet.nazov='$predmet' AND predmet.rok = '$rok' AND predmet.id = team.id_predmet AND team.suhlas='2' ";
        $result = $connect->query($sql);
        $nieco2 = $result->num_rows;
        echo "<td>" . $nieco2 . "</td>";
        $sql = "SELECT * FROM team, predmet WHERE predmet.nazov='$predmet' AND predmet.rok = '$rok' AND predmet.id = team.id_predmet AND team.suhlas='0' ";
        $result = $connect->query($sql);
        $nieco3 = $result->num_rows;
        echo "<td>" . $nieco3 . "</td>";
        echo "</tr>";
        echo "</tbody></table>";


        $dataPoints2 = array(
            array("label" => ($_SESSION["lang"] == "sk") ? 'Uzavreté' : 'Closed', "y" => (($nieco / $kolko) * 100)),
            array("label" => ($_SESSION["lang"] == "sk") ? 'Upraviť body' : 'Edit points', "y" => (($nieco2 / $kolko) * 100)),
            array("label" => ($_SESSION["lang"] == "sk") ? 'Nevyjadrené' : 'Unstated', "y" => (($nieco3 / $kolko) * 100))
        );

        echo "<div id='chartContainer2' style='height: 370px; width: 100%;'></div>";


        echo "<br><br><div align='center'> <form action='".$_SERVER['REQUEST_URI']."' method='post' enctype='multipart/form-data'>		
                  <button type='submit' name='export' class='btn btn-primary'>";echo ($_SESSION["lang"] == "sk") ? 'Export do CSV' : 'Export to CSV';echo"</button>		
          </form></div>";


    }
    // naplni tabulku z csv suboru do tabulky  uloha2
    if (isset($_POST["submit"])) {
        include_once "config.php";
        $connect = new mysqli($servername, $username, $password, $databaza);
        $connect->set_charset('utf8');
// Check connection
        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        $predmet = $_POST['predmet'];
        $rok = $_POST['skolsky_rok'];
        echo $predmet . " " . $rok . "<br>";
        if ($_FILES['file']['name']) {
            $filename = explode('.', $_FILES['file']['name']);
            if ($filename[1] == 'csv') {
                $handle = fopen($_FILES['file']['tmp_name'], "r");

                $sqlko = "INSERT INTO predmet (nazov,rok) values ('$predmet','$rok')";

                if (mysqli_query($connect, $sqlko) === TRUE) {
                    $id_predmetu_ins = $connect->insert_id;
                    echo $id_predmetu_ins;
                } else {
                    echo "Error: " . $sqlko . "<br>" . $connect->error;
                }


                while ($data = fgetcsv($handle, 10000, $_POST['oddelovac'])) {

                    $item1 = mysqli_real_escape_string($connect, $data[0]);
                    $item2 = mysqli_real_escape_string($connect, $data[1]);
                    $item3 = mysqli_real_escape_string($connect, $data[2]);
                    $item4 = mysqli_real_escape_string($connect, $data[4]);
                    $item5 = mysqli_real_escape_string($connect, $data[5]);
                    if(empty($item4)){
                     $heslo = NULL;
                    }else {
                        $heslo = password_hash($item4, PASSWORD_DEFAULT);
                    }
                    $sql = "INSERT into student (id,meno,email,heslo,type_of_user) values ('$item1','$item2','$item3','$heslo','$item5')";
                    if (mysqli_query($connect, $sql) === TRUE) {
                    } else {
                        echo "Error: " . $sql . "<br>" . $connect->error;
                    }

                    $sql = "SELECT * FROM team WHERE cislo= '$data[3]' AND id_predmet = '$id_predmetu_ins'";
                    $result = $connect->query($sql);

                    if ($result->num_rows == 0) {
                        $sql = "INSERT into team (cislo, id_predmet)
                       values ('" . $data[3] . "','" . $id_predmetu_ins . "')";

                        $result = mysqli_query($connect, $sql);
                        $id_timu_ins = $connect->insert_id;
                    }
                    $sql = "INSERT INTO zaznam (id_predmet,id_team,id_student)
                   values ('" . $id_predmetu_ins . "','" . $id_timu_ins . "','" . $data[0] . "')";
                    if (mysqli_query($connect, $sql) === TRUE) {
                    } else {
                        echo "Error: " . $sql . "<br>" . $connect->error;
                    }


                }
            }
        }

    }

    ?>

</div>
<script>

    function postSuhlas(suhlas, timID) {
        $.ajax({
            type: "POST",
            url: "admin_task2.php",
            data:{ suhlas: suhlas, timID:timID},
            success: function () {
                setTimeout(function(){
                    location.reload();
                }, 500);
            }
        });
    }


    function getPredmet(val) {
        $.ajax({
            type: "POST",
            url: "najdiRok.php",
            data: 'rok=' + val,
            success: function (data) {
                $("#predmet").html(data);
            }
        });
    }
</script>
<script>
    window.onload = function() {


        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: 'Graf'
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#36454F",
                indexLabelFontSize: 18,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        var chart = new CanvasJS.Chart("chartContainer2", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: 'Graf'
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#36454F",
                indexLabelFontSize: 18,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>