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

    $sql = "SELECT body FROM team WHERE id_predmet = '" . $_POST["pole"][0] . "' AND id = '" . $_POST["pole"][1] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row["body"];
    }
}