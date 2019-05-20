<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

include('../config.php');

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];

session_start();

$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);   // php://input - read raw data from the request body

if( $method == "GET"){


    if($request[0] == "getEmailPreset"){


        $content = "Dobrý deň,<br/>
        na predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru su uvedené nižšie.<br/><br/>
        ip adresa: {{verejnaIP}}<br/> prihlasovacie meno: {{login}}<br/>heslo: {{heslo}}<br/>
        Vaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}<br/><br/>S pozdravom,<br/>
        --------";
        echo $content;

    } else if ($request[0] == "getHistory"){
     
        // connect to the mysql database
        $link = mysqli_connect($servername,$username,$password,$dbname);
        mysqli_set_charset($link,'utf8');
        $sql = "SELECT datumOdoslania, menoStudenta, nazovSpravy FROM mails";
        $result = mysqli_query($link,$sql);

        $table = array();
        while($row = $result->fetch_assoc()){
        array_push($table,array('datum' => $row['datumOdoslania'],
            'meno' => $row['menoStudenta'],
            'nazov' => $row['nazovSpravy']));
        }
        
        $echoArray = array(
            'table' => $table
        );
        echo json_encode($echoArray,JSON_UNESCAPED_UNICODE);  
    }

}

if( $method == "POST"){

    if($request[0] == "changeLanguage"){
        parse_str(file_get_contents("php://input"),$post_vars);
        $_SESSION['language'] = $post_vars['language'];
    

    } else if ($request[0] == "addPasswords"){

    // READ FILE CONTENTS
    $data = file_get_contents($_FILES['file']['tmp_name']);
    $data = str_getcsv($data, "\n"); 

    $list = array();
    for($i = 0 ; $i < sizeof($data); $i++){


        if($i == 0){
            array_push($list,$data[$i] . ";heslo\n");
        } else {
            $password = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,15))),1,15);

            array_push($list,$data[$i] . ";" . $password . "\n");
        }

    }

    $string = "";
    for($i = 0; $i < sizeof($list);$i++){
        $string .= $list[$i];
    }

    $fileToUpload = "file.csv";
    file_put_contents($fileToUpload,"");
    $content = file_get_contents($fileToUpload);
    $content .= $string;
    file_put_contents($fileToUpload, $content);
    fclose($fileToUpload);

    echo "SUCCESS";

    } else if ($request[0] == "sendMails"){

        $csv = file_get_contents($_FILES['file']['tmp_name']);
        $csv = str_getcsv($csv, "\n"); 

        $data = array();
        for($i = 0; $i < sizeof($csv); $i++){
            array_push($data,explode($_POST['separator'],$csv[$i]));
        }

        $keysIndexes = array();

        for($i = 0; $i < sizeof($data[0]);$i++){

            $keysIndexes[trim($data[0][$i])] = $i;

        }

        for($i = 1; $i < sizeof($csv);$i++){

            $sablona = $_POST["content"];

            while(strpos($sablona, "{{") != false){

                $length = strlen($sablona);
                $start = strpos($sablona, "{{");
                $end = strpos($sablona,"}}");

                $key = substr($sablona, -$length + $start + 2, $end-$start-2);
                $untrimmedKey = $key;
                $key = trim($key);
                $index = $keysIndexes[$key];
                $value = $data[$i][$index];

                //echo $value;

                $sablona = str_replace("{{" . $untrimmedKey . "}}", $value, $sablona);

            
            }

           $mail = new PHPMailer(true);

            try {

                //server settings
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'mail.stuba.sk';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $_POST['email'];                     // SMTP username
            $mail->Password   = $_POST['password'];                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;    
            
                //Recipients
            $mail->setFrom($_POST['email'], $_POST['name']);
            $index = $keysIndexes['email'];
            $mail->addAddress($data[$i][$index]);// Add a recipient

                //Attachments
            if(file_get_contents($_FILES['extension']['tmp_name']) != null){
                $mail->addAttachment($_FILES['extension']['tmp_name']); 
            }

            $mail->isHTML(true);
            $mail->Subject = $_POST['title'];
            $mail->Body = $sablona;
            $mail->send();

            $date = date("Y-m-d H:i:s");
            $index = $keysIndexes['meno'];
            $menoStudenta = $data[$i][$index];
            $nazovSpravy = $_POST['title'];

            // connect to the mysql database
            $link = mysqli_connect($servername,$username,$password,$dbname);
            mysqli_set_charset($link,'utf8');

            $sql = "INSERT INTO mails (datumOdoslania,menoStudenta,nazovSpravy) VALUES ('$date','$menoStudenta','$nazovSpravy')";
            echo $sql;
            $result = mysqli_query($link,$sql);

            } catch (Exception $e) {
            echo "Hups";
            }

        }



    }

}

?>