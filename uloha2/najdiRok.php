<?php
require_once("config.php");
if(!empty($_POST['rok'])) {
    $sql = "SELECT nazov FROM predmet WHERE rok = '" . $_POST["rok"] . "' GROUP BY nazov";
    $connect = new mysqli($servername, $username, $password, $databaza);
    $connect->set_charset('utf8');
    $result = $connect->query($sql);
    ?>
    <option value="">Vyber predmet</option>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results
            ?>

            <option value="<?php echo $row["nazov"]; ?>"><?php echo $row["nazov"]; ?></option>
            <?php
        }
    }
}
?>