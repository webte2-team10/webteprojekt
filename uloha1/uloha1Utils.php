<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 01.05.2019
 * Time: 11:20
 */


$db = $databse;


//funkcia dopytuje riadky s danym predmetom a vysledky zapise do tabulky
function printSubjectAll($connect,$name,$database,$ids,$year,$studentId) {

    $print = true;

    if($studentId == 0) {
        if ($year == "all") {
            $query = "SELECT body.id_student, body.zapocet, body.skuska_rt, body.skuska_ot, body.spolu, body.znamka, body.rok, studenti.meno FROM body JOIN studenti ON body.id_student  = studenti.id WHERE body.id_predmet = $ids";
        } else {
            $query = "SELECT body.id_student, body.zapocet, body.skuska_rt, body.skuska_ot, body.spolu, body.znamka, body.rok, studenti.meno FROM body JOIN studenti ON body.id_student  = studenti.id WHERE body.id_predmet = $ids AND body.rok = '$year'";
        }
    } else {
        $query = "SELECT body.zapocet, body.skuska_rt, body.skuska_ot, body.spolu, body.znamka FROM body WHERE body.id_student = $studentId AND body.id_predmet = $ids";
    }
    $result = mysqli_query($connect, $query);


    if(mysqli_num_rows($result) == 0) {
        $print = false;
        return $print;
        exit();
    }

    echo ' 
           <h3>'.$name.'</h3>
           <hr>
            <div class="table-responsive">
            <div id="'."$name".'">
            <table class="table table-bordered table-striped">
         <tr>';

    //vypisanie table header pre admina
    if($studentId == 0) {
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'id študenta' : 'student id';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'meno študenta' : 'student name';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'zápočet' : 'student credit';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'skúška - riadny termín' : 'Exam - first term';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'skúška - opravný termín' : 'Exam - second term';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'spolu' : 'sum';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'známka' : 'grade';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'akademický rok ' : 'academic year';
        echo('</th>');
    }
    //vypisanie table header pre studenta
    else {
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'zápočet' : 'student credit';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'skúška - riadny termín' : 'Exam - first term';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'skúška - opravný termín' : 'Exam - second term';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'spolu' : 'sum';
        echo('</th>');
        echo('<th>');
        echo($_SESSION["lang"] == "sk") ? 'známka' : 'grade';
        echo('</th>');

    }
    //table data
    while($row = mysqli_fetch_array($result))
    {

        echo ' <tr>';
        if($studentId == 0) {
            echo('<td>' . $row[0] . '</td><td>' . $row[7] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[3] . '</td><td>' . $row[4] . '</td><td>' . $row[5] . '</td><td>' . $row[6] . '</td>');
        } else {
            echo('</td><td>' . $row[0] .'</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td>' . $row[3] . '</td><td>' . $row[4] . '</td>');
        }
        echo ' </tr>';
    }

    //button na vytlacenie pdf pre danu tabulku
    if($studentId == 0) {
        echo '</table>   </div>   </div>   <button onclick="javascript:demoFromHTML(\'' . WEBTE1 . '\')">'; echo($_SESSION["lang"] == "sk") ? 'stiahnuť PDF' : 'download PDF'; echo'</button> ';
    } else {
        echo '</table>   </div>   </div> ';
    }
    return $print;
}

//vymaze dany predmet
function deleteSub($name,$connect)
{
    //dopyt ci existuje dany predmet
    $findSub = "SELECT * FROM Predmety WHERE nazov = '$name'";
    $delResult = mysqli_query($connect, $findSub);



    if(mysqli_num_rows($delResult) != 0) {
        $row = mysqli_fetch_array($delResult);
        $pid = $row['id'];
        $delQuery = "DELETE FROM body WHERE id_predmet = $pid";
        mysqli_query($connect,$delQuery);
        $delQuery2 = "DELETE FROM Predmety WHERE id = $pid";
        mysqli_query($connect,$delQuery2);

            $studentQuery = "SELECT * FROM studenti";
            $studRes = mysqli_query($connect,$studentQuery);

            //Ak bol vymazany posledny predmet studenta, vymaze sa aj student samotny

            while($row = mysqli_fetch_array($studRes)) {
                $studId = $row['id'];
                $sqlq = "SELECT * FROM studenti JOIN body ON studenti.id = body.id_student";
                $res  = mysqli_query($connect,$sqlq);

                if(mysqli_num_rows($res) == 0) {
                   $deleteStud =  "DELETE FROM studenti WHERE id = '$studId'";
                   mysqli_query($connect,$deleteStud);
                }

            }
    }

}

//kontroluje ci existuje predmet, ak nie vlozi ho
//vracia id predmetu
function checkSubject($connect,$subjName)
{
    $findSub = "SELECT * FROM Predmety WHERE nazov = $subjName";
    $subResult = mysqli_query($connect, $findSub);

    if(mysqli_num_rows($subResult) == 0) {
        $newSub  = "INSERT INTO Predmety(nazov) VALUES ($subjName)";
        mysqli_query($connect,$newSub);
    }

    $sqlSub = "SELECT * FROM Predmety WHERE nazov = $subjName";
    $subRes = mysqli_query($connect,$sqlSub);
    $subId = mysqli_fetch_array($subRes)['id'];
    return $subId;
}

//kontroluje podla ID ci existuje student, ak nie vlozi ho
//id studenta sa pouzije rovno ako primarny kluc
function checkStudent($connect,$studentId,$meno)
{
    $findStudent = "SELECT * FROM studenti WHERE id = $studentId";
    $StudentResult = mysqli_query($connect, $findStudent);

    if(mysqli_num_rows($StudentResult) == 0) {
        $newSub  = "INSERT INTO studenti(id,meno) VALUES ($studentId,$meno)";
        mysqli_query($connect,$newSub);
    }

}
//vlozi obsah csv do tabulky
function addTableEntries($fileHandler,$connect,$year,$subId,$delimiter) {
    $theader = true;
    while($result = fgetcsv($fileHandler,1000,"$delimiter")) {

        if ($theader) {
            $theader = false; //prvy riadok csv sa preskoci
        } else {
            $idStudent = "'" . $result[0] . "'";
            $nameStudent = "'" . $result[1] . "'";
            $zapocet = $result[2];
            $skuska_rt = $result[3];
            $skuska_ot = $result[4];
            $spolu = $result[5];
            $znamka = "'" . $result[6] . "'";


            checkStudent($connect, $idStudent, $nameStudent);

            //kontrola ci uz student ma zaznam pre dany predmet
            $sqlCheck = "SELECT * FROM body WHERE id_student = $idStudent AND id_predmet = $subId";
            $checkRes = mysqli_query($connect, $sqlCheck);
            if (mysqli_num_rows($checkRes) == 0) {
                //ak nie vlozi sa do tabulky
                $sql = "INSERT INTO body (id_student, zapocet,skuska_rt,skuska_ot,spolu,znamka,rok,id_predmet)
                        VALUES ($idStudent, $zapocet, $skuska_rt, $skuska_ot, $spolu, $znamka ,$year,$subId)";


                mysqli_query($connect, $sql);
            } else {
                //ak ano iba sa aktualizuju body
                $sqlUpdate = "UPDATE body SET zapocet=$result[2], skuska_rt=$result[3] ,skuska_ot=$result[4],spolu=$result[5],znamka='$result[6]' WHERE id_student =  $idStudent AND id_predmet = $subId";
                mysqli_query($connect, $sqlUpdate);
            }

        }
    }

}


?>