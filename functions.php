<?php
//ktora stranka bude index?
//nemoze sa stat ze studenti budu mat rovnaky login?
//admin1, admin2, student1, student2 -> heslo


 /*//vkladanie udajov do databazy
$pass = "heslo";
$hash = password_hash($pass,PASSWORD_DEFAULT);
//$query = "INSERT INTO logs (name, email, password, type_of_user) VALUES ('student2', 'student2@stuba.sk', '$hash', 'student')";
$query = "INSERT into student (id, meno,email,heslo,type_of_user) values ('3', 'admin3', 'admin3@stuba.sk', '$hash', 'admin')";
//$query = "INSERT INTO logs (name, email, password, type_of_user, team) VALUES ('student2', 'student2@stuba.sk', '$hash', 'lord of darkness', 666)";
$results = mysqli_query($db, $query);
*/
/*
$item1 = mysqli_real_escape_string($db, $data[0]);
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
///////////////
*/


include_once("config.php");
session_start();
include('lang.php');    //treba includnut aj script.js


//davat pozor, $username a $password sa pouziva v 2 roznych pripadoch -> zmenit to v configu
$db = mysqli_connect($servername, $username, $password, $dbname);   //pripojenie do DB
if (mysqli_connect_errno()) {
    echo _ErrorMySql." ".mysqli_connect_error();
}


$pass = "heslo";
$hash = password_hash($pass,PASSWORD_DEFAULT);
//$query = "INSERT INTO logs (name, email, password, type_of_user) VALUES ('student2', 'student2@stuba.sk', '$hash', 'student')";
$query = "INSERT into student (id, meno,email, heslo, type_of_user) values ('2', 'admin2', 'admin2@stuba.sk', '$hash', 'admin')";
//$query = "INSERT INTO logs (name, email, password, type_of_user, team) VALUES ('student2', 'student2@stuba.sk', '$hash', 'lord of darkness', 666)";
$results = mysqli_query($db, $query);


$username = "";
$email    = "";
$errors   = array();


if (isset($_POST['btn_lgn'])) {                 //ak bolo stlacene tlacidlo prihlas
    login();
}

function login(){                               //prihlas pouzivatela
    global $db, $username, $errors;

    $username = $_POST['username'];             //udaje z formulara
    $password = $_POST['password'];

    if (empty($username)) {                     //ci su vyplnene
        array_push($errors, _ErrorLoginName);
    }
    if (empty($password)) {
        array_push($errors, _ErrorLoginPwd);
    }

    if (count($errors) == 0) {                  //ak nie su ziadne chyby tak prihlas
        $query = "SELECT * FROM student WHERE SUBSTRING_INDEX(email, '@', 1) = '".$username."'";    //najdeme uzivatela, ktory ma dane meno v db
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {                                               //pouzivatel existuje v db
            $user = mysqli_fetch_assoc($results);
            $hash = $user['heslo'];                                                      //prebereme zahashovane heslo z db
            if ($hash == null) {        //LDAP
                $dn = 'ou=People, DC=stuba, DC=sk';
                $ldaprdn = "uid=$username, $dn";
                $ldapconn = ldap_connect("ldap.stuba.sk")                           //pripoji sa na ldap server, vrati id for a directory server
                or die(_ErrorLDAP);

                if ($ldapconn) {      //ak sme sa pripojili
                    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);   //pre dane spojenie nastavi danu moznost na 3
                    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $password);                  //binding to ldap server, napoji sa k ldap direktive s danym RDN a heslom, vracia true/false

                    if ($ldapbind) {                                                        //prihlasenie bolo uspesne
                        if ($user['type_of_user'] == 'admin') {
                            $_SESSION['user'] = $user;
                            //$_SESSION['success']  = "You are now logged in via ldap admin";
                            header('location: admin_home.php');
                        }else{
                            $_SESSION['user'] = $user;
                            //$_SESSION['success']  = "You are now logged in via ldap student";
                            header('location: student_home.php');
                        }
                    } else {                                                                //zle heslo, meno, neprihlasili sme sa
                        array_push($errors, _ErrorLDAPBind);
                    }
                }
            }
            else{       //DATABAZA
                if(password_verify($password,$hash)) {                                      //ak je zadane heslo rovnake ako heslo v db
                    if ($user['type_of_user'] == 'admin') {
                        $_SESSION['user'] = $user;
                        //$_SESSION['success']  = "You are now logged in via db admin";
                        header('location: admin_home.php');
                    }else{
                        $_SESSION['user'] = $user;
                        //$_SESSION['success']  = "You are now logged in via db student";
                        header('location: student_home.php');
                    }
                }
                else{
                    array_push($errors, _ErrorDB);
                }
            }
        }else {                                                                             //dany uzivatel s danym menom nie je zapisany v DB
            array_push($errors, _ErrorComb);           //username neexistuje
        }
    }
}


function display_error() {      //zobrazi error, ktory sa vznikol prihlasovanim sa
    global $errors;

    if (count($errors) > 0){
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn(){
    if (isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

function isAdmin(){
    if (isset($_SESSION['user']) && $_SESSION['user']['type_of_user'] == 'admin' ) {
        return true;
    }else{
        return false;
    }
}

if (isset($_GET['logout'])) {   //odhlasi len studentov lebo functions su v rovnakom adresari ako podtranky studentov!
                                // admini to musia mat explicitne zapisane v kazdej podstranke
    session_destroy();
    unset($_SESSION['user']);
    header("location: index.php");
}



