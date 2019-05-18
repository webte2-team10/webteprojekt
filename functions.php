<?php
//ktora stranka bude index?
//nemoze sa stat ze studenti budu mat rovnaky login?
//admin1, admin2, student1, student2 -> heslo

/* //vkladanie udajov do databazy
$pass = "heslo";
$hash = password_hash($pass,PASSWORD_DEFAULT);
$query = "INSERT INTO logs (name, email, password, type_of_user) VALUES ('student2', 'student2@stuba.sk', '$hash', 'student')";
//$query = "INSERT INTO logs (name, email, password, type_of_user, team) VALUES ('student2', 'student2@stuba.sk', '$hash', 'lord of darkness', 666)";
$results = mysqli_query($db, $query);
*/


include_once("config.php");

session_start();

//davat pozor, $username a $password sa pouziva v 2 roznych pripadoch -> zmenit to v configu
$db = mysqli_connect($servername, $username, $password, $dbname);   //pripojenie do DB
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

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
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {                  //ak nie su ziadne chyby tak prihlas
        $query = "SELECT * FROM logs WHERE SUBSTRING_INDEX(email, '@', 1) = '$username'";    //najdeme uzivatela, ktory ma dane meno v db
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {                                               //pouzivatel existuje v db
            $user = mysqli_fetch_assoc($results);
            $hash = $user['password'];                                                      //prebereme zahashovane heslo z db
            if ($hash == null) {        //LDAP
                $dn = 'ou=People, DC=stuba, DC=sk';
                $ldaprdn = "uid=$username, $dn";
                $ldapconn = ldap_connect("ldap.stuba.sk")                           //pripoji sa na ldap server, vrati id for a directory server
                or die("Could not connect to LDAP server.");

                if ($ldapconn) {      //ak sme sa pripojili
                    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);   //pre dane spojenie nastavi danu moznost na 3
                    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $password);                  //binding to ldap server, napoji sa k ldap direktive s danym RDN a heslom, vracia true/false

                    if ($ldapbind) {                                                        //prihlasenie bolo uspesne
                        if ($user['type_of_user'] == 'admin') {
                            $_SESSION['user'] = $user;
                            $_SESSION['success']  = "You are now logged in via ldap admin";
                            header('location: admin_home.php');
                        }else{
                            $_SESSION['user'] = $user;
                            $_SESSION['success']  = "You are now logged in via ldap student";
                            header('location: student_home.php');
                        }
                    } else {                                                                //zle heslo, meno, neprihlasili sme sa
                        array_push($errors, "LDAP bind failed, invalid login/password...");
                    }
                }
            }
            else{       //DATABAZA
                if(password_verify($password,$hash)) {                                      //ak je zadane heslo rovnake ako heslo v db
                    if ($user['type_of_user'] == 'admin') {
                        $_SESSION['user'] = $user;
                        $_SESSION['success']  = "You are now logged in via db admin";
                        header('location: admin_home.php');
                    }else{
                        $_SESSION['user'] = $user;
                        $_SESSION['success']  = "You are now logged in via db student";
                        header('location: student_home.php');
                    }
                }
                else{
                    array_push($errors, "Wrong DB username/password combination");
                }
            }
        }else {                                                                             //dany uzivatel s danym menom nie je zapisany v DB
            array_push($errors, "Wrong username/password combination");           //username neexistuje
        }
    }
}


function display_error() {      //zobrazi error, ktory sa vznikol prihlasovanim sa
    global $errors;

    if (count($errors) > 0){
        echo '<div class="error">';
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
    header("location: login.php");
}





