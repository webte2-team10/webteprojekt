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
    $sql = "UPDATE zaznam SET suhlas_kap = 1, body_stud = '" . $_POST["pole"][3] . "' WHERE id_predmet = '" . $_POST["pole"][2] . "' and id_team = '" . $_POST["pole"][1] . "' and id_student = '" . $_POST["pole"][0] . "'";
    $conn->query($sql);

    $sql = "UPDATE team SET body = '" . $_POST["pole"][4] . "' WHERE id = '" . $_POST["pole"][1] . "'";
    $conn->query($sql);
}