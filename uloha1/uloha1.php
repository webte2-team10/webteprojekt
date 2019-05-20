<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 30.04.2019
 * Time: 20:13
 */

include "uloha1Utils.php";
include "../functions.php";
include "../config.php";
include('../lang.php');

if(isLoggedIn()) {
    if (!isAdmin()) {
        $admin = false;
    }else {
        $admin = true;
    }

} else {
    header('location: https://147.175.121.210:4472/cvicenia/projekt/index.php');

}




    $msg = '';
    $connect = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}



    if(isset($_POST["delete"])) {
        $subToDel = $_POST['subjectDelete'];
        deleteSub($subToDel,$connect);
    }

//nahratie suboru
    if(isset($_POST["uploadFile"])) {

        if($_FILES['csvInput']['name']) {

            $name = explode(".",$_FILES["csvInput"]["name"]);

            if(end($name) == "csv") {

                $subj = "'".$_POST["subject"]."'";
                $year = "'".$_POST["year"]."'";


                $delimiter = $_POST['delimiter'];

                $subId = checkSubject($connect,$subj);
                $fileHandler = fopen($_FILES["csvInput"]["tmp_name"],"r");
                addTableEntries($fileHandler,$connect,$year,$subId,$delimiter);
                fclose($fileHandler);

            } else {
              $msg = $_SESSION["lang"] == "sk" ? '<label class="text-danger"> Súbor musí mať príponu CSV! </label>' : '<label class="text-danger"> The file must have a CSV extension! </label>';
            }
        }
    }


?>



<!DOCTYPE html>
<html>
<head>


    <title> <?php echo($_SESSION["lang"] == "sk") ? 'Zobrazenie výsledkov' : 'Course results' ?></title>
    <meta charset="utf-8">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/js/script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Bungee+Inline" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <link rel="stylesheet" type="text/css" href="https://147.175.121.210:4472/cvicenia/projekt/styles/style.css">    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="tablePDF.js"></script>

</head>


<?php


$currentPage = "Task1";
include('../navbar.php');
?>


<body>

<article>
<?php


$studentId = $_SESSION['user']['id'];
//formulare chceme zobrazit len pre admina
    if($admin) {
    echo'<div class="container">

            
            <form id="uploadForm" method="post" enctype="multipart/form-data" action="uloha1.php">
                <p style="font-weight: bold; text-align: center; font-size:1.2em">';  echo($_SESSION["lang"] == "sk") ? 'Nahrať výsledky' : 'Upload course results';
        echo'</p>
            
                <div class="form-row">
                    
                    <div class="form-group col-md-4">
                    <label>'; echo($_SESSION["lang"] == "sk") ? 'školský rok' : 'academic year'; echo'</label><br>
                    <select class="form-control" name="year">
                        <option value="2018/2019" selected>2018/2019</option>
                        <option value="2017/2018">2017/2018</option>
                        <option value="2016/2017">2016/2017</option>
                        <option value="2015/2016">2015/2016</option>
                        <option value="2014/2015">2014/2015</option>
                        <option value="2013/2014">2013/2014</option>
                        <option value="2012/2013">2012/2013</option>
                        <option value="2011/2012">2011/2012</option>
                        <option value="2010/2011">2010/2011</option>

                    </select>
                    </div>


                     <div class="form-group col-md-4">
                        <label>';echo($_SESSION["lang"] == "sk") ? 'názov predmetu' : 'course name';echo'</label><br>
                        <input class="form-control" type="text" name="subject" value="" required>
                        <br>
                     </div>

                      <div class="form-group col-md-4">
                        <label>';echo($_SESSION["lang"] == "sk") ? 'Oddelovač v CSV súbore' : 'CSV file delimiter';echo'</label><br>
                        <input class="form-control" type="text" name="delimiter" value=";" required>
                        <br>
                      </div>
                </div>

                       <div align="center">
                    <div class="custom-file">
                        <label class="custom-file-label" for="inputGroupFile01">';echo($_SESSION["lang"] == "sk") ? 'vybrať súbor:' : 'choose file';echo'</label>
                        <input type="file" name="csvInput" class="custom-file-input" id="inputGroupFile01"
                               aria-describedby="inputGroupFileAddon01" required>
                    </div>';echo($msg);




        echo'<br><br>
                 
                        <input type="submit" name="uploadFile" class="btn btn-primary" value="';echo($_SESSION["lang"] == "sk") ? 'nahrať' : 'upload';echo'">
                    </div;
                 </form>

                <br>';



           echo '<form id="deleteForm"  method="post" action="uloha1.php">
                <div class="form-row">
                <div class="form-group">
                        <label>';echo($_SESSION["lang"] == "sk") ? 'vymazať predmet' : 'remove course'; echo'</label><br>
                    <select id="deleteInput" class="form-control" name="subjectDelete" >';

                        //naplnenie selectu hodnotami z databazy
                        $fillSubjects = "SELECT * FROM Predmety";
                        $fillRes = mysqli_query($connect, $fillSubjects);
                        while($row = mysqli_fetch_array($fillRes)) {
                            $subjname = $row['nazov'];
                            echo('<option value="'.$subjname.'">'.$subjname.'</option>');
                        }

                  echo '</select>
                </div>
                    <br>

                    <div class="form-group">
                        <input type="submit" name="delete" class="btn btn-primary" value="';echo($_SESSION["lang"] == "sk") ? 'vymazať' : 'remove'; echo'">
                    </div>

                </div>
            </form>
             <br>';

           echo '<form id="FilterForm"  method="post" action="uloha1.php">
                <p id="formTitle">';echo($_SESSION["lang"] == "sk") ? 'obmedziť výber' : 'course filter'; echo'<p>



                <div class="form-row">
                <div class="form-group col-md-6">
                        <label>';echo($_SESSION["lang"] == "sk") ? 'predmet' : 'course'; echo'</label><br>
                        <select class="form-control" name="subjectFilter">
                            <option value="all" selected>';echo($_SESSION["lang"] == "sk") ? 'všetky' : 'all'; echo'</option>';

                            //naplnenie selectu hodnotami z databazy
                                 $fillSubjects = "SELECT * FROM Predmety";
                                 $fillRes = mysqli_query($connect, $fillSubjects);
                                    while($row = mysqli_fetch_array($fillRes)) {
                                        $subjname = $row['nazov'];
                                        echo('<option value="'.$subjname.'">'.$subjname.'</option>');
                                    }

                       echo '</select>
                        <br>
                </div>


                <div class="form-group col-md-6">
                        <label>';echo($_SESSION["lang"] == "sk") ? 'školský rok' : 'academic year'; echo'</label><br>
                        <select class="form-control" name="filterYear">
                            <option value="all" selected>';echo($_SESSION["lang"] == "sk") ? 'všetky roky' : 'all years'; echo'</option>
                            <option value="2018/2019">2018/2019</option>
                            <option value="2017/2018">2017/2018</option>
                            <option value="2016/2017">2016/2017</option>
                            <option value="2015/2016">2015/2016</option>
                            <option value="2014/2015">2014/2015</option>
                            <option value="2013/2014">2013/2014</option>
                            <option value="2012/2013">2012/2013</option>
                            <option value="2011/2012">2011/2012</option>
                            <option value="2010/2011">2010/2011</option>
                        </select>
                    </div>

                </div>
                
                <div class="custom-file">

                <input id="filterBtn" type="submit" name="filter" class="btn btn-primary" value="ok">
             </form>
             </div>

        </div>';

    }
    ?>

<?php


//vypis tabuliek
if(isset($_POST['filter'])&& $_POST['subjectFilter'] != "all") {
    $subjname = $_POST['subjectFilter'];

    if($_POST['filterYear'] == "all") {
        echo('<h2>');
        echo ($_SESSION["lang"] == "sk") ? 'Prehľad výsledkov z predmetu ' . $subjname  : 'Results of course ' . $subjname ;
        echo('</h2>');
    } else {
        echo('<h2>');
        echo ($_SESSION["lang"] == "sk") ? 'Prehľad výsledkov z predmetu ' . $subjname . ' zo školského roku ' . $_POST['filterYear'] : 'Results of course ' . $subjname . ' from the academic year of ' . $_POST['filterYear'];
        echo('</h2>');
    }

    $subjects = "SELECT * FROM Predmety WHERE nazov='$subjname'";
} else {
    echo('<h2>');
    echo($_SESSION["lang"] == "sk") ? 'Prehľad výsledkov všetkých predmetov' : 'Results of all courses';
    echo('</h2>');
    $subjects = "SELECT * FROM Predmety";

}
$results = mysqli_query($connect, $subjects);
$empty = true;

if($admin) {
    $studentId = 0;
}

if($studentId != 0) {
    $queryName = "SELECT meno FROM studenti WHERE id=$studentId";
    $resultName = mysqli_query($connect, $queryName);
    $studentName = mysqli_fetch_array($resultName);

    echo('<h2>');
    echo($_SESSION["lang"] == "sk") ? 'Aktuálne prihlásený študent: '.$studentName[0] : 'Currently logged in as student: '.$studentName[0];
    echo('</h2>');
}


while($row = mysqli_fetch_array($results))
{

    $ids = $row['id'];
    $name = $row['nazov'];
    $year = "all";


    if(isset($_POST['filterYear'])) {
        $year = $_POST['filterYear'];
    }



        if (printSubjectAll($connect, $name, $database, $ids, $year, $studentId)) {

            $empty = false;
        }
}
if($empty) {
    echo'<p id="msg"> <i class="fas fa-exclamation-triangle"></i>'; echo($_SESSION["lang"] == "sk") ? 'Neboli nájdené žiadne záznamy' : 'No results have been found for given request'; echo'<p>';
}
?>
</article>

</body>
</html>
