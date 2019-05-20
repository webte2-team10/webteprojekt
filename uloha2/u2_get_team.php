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

    $sql = "SELECT id_team FROM zaznam WHERE id_predmet = '" . $_POST["pole"][0] . "' AND id_student = '" . $_POST["pole"][1] . "'";
    $id_team = $conn->query($sql);

    if ($id_team->num_rows > 0) {
        $row = $id_team->fetch_assoc();
        $response[0] = $row["id_team"];
    }

    $sql = "SELECT cislo FROM team WHERE id_predmet = '" . $_POST["pole"][0] . "' AND id = '" . $row["id_team"] . "'";
    $cislo = $conn->query($sql);

    if ($cislo->num_rows > 0) {
        $row2 = $cislo->fetch_assoc();
        $response[1] = $row2["cislo"];
        echo json_encode($response);
    }
}