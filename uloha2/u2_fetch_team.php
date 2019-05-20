<?php
require_once("config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $databaza);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!empty($_POST['pole'])) {

    /*najdem id timu*/

    $sql = "SELECT id FROM team WHERE id_predmet = '" . $_POST["pole"][0] . "' AND id = '" . $_POST["pole"][1] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $id = $result->fetch_assoc();
    }

    /*najdem id studentov*/

    $sql = "SELECT * FROM zaznam WHERE id_predmet = '" . $_POST["pole"][0] . "' AND id_team = '" . $id["id"] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            /*ziskam info o studentovi*/

            $sql = "SELECT * FROM student WHERE id = '" . $row["id_student"] . "'";
            $result2 = $conn->query($sql);

            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    if ($row["suhlas_stud"] == 1){
                        if ($row["body_stud"] != null){
                            if ($row["suhlas_kap"] == 1){
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100" value="' . $row["body_stud"] . '" disabled=""></td><td><i class="fa fa-check kapitan suhlas" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen suhlas" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                            else{
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100" value="' . $row["body_stud"] . '" disabled=""></td><td><i class="fa fa-check kapitan" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen suhlas" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                        }
                        else{
                            if ($row["suhlas_kap"] == 1){
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100"  disabled=""></td><td><i class="fa fa-check kapitan suhlas" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen suhlas" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                            else{
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100"  disabled=""></td><td><i class="fa fa-check kapitan" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen suhlas" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                        }
                    }
                    else{
                        if ($row["body_stud"] != null){
                            if ($row["suhlas_kap"] == 1){
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100" value="' . $row["body_stud"] . '" disabled=""></td><td><i class="fa fa-check kapitan suhlas" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                            else{
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100" value="' . $row["body_stud"] . '" disabled=""></td><td><i class="fa fa-check kapitan" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                        }
                        else{
                            if ($row["suhlas_kap"] == 1){
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100"  disabled=""></td><td><i class="fa fa-check kapitan suhlas" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                            else{
                                echo '<tr><td>' . $row2["email"] . '</td><td>' . $row2["meno"] . '</td><td><input pattern="^\d+$" class="input_dis" id="' . $row2["id"] . 'i" type="number"  min="0" max="100"  disabled=""></td><td><i class="fa fa-check kapitan" id="' . $row2["id"] . 'k"></i></td><td><i class="fa fa-check clen" id="' . $row2["id"] . 'c"></i></td></tr>';
                            }
                        }
                    }
                }
            }
            else{
                echo '<tr><td colspan="5">Nenašli sa dáta</td></tr>';
            }
        }
    }
}