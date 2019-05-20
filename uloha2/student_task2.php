<?php

//dat na zaciatok stranok, ktore maju byt pristupne len pre studentov
include "../functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = _ErrorLogin;
    header('location: https://147.175.121.210:4472/cvicenia/projekt/index.php');
}

// Set Language variable
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];

    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}

// Include Language file
if(isset($_SESSION['lang'])){
    include "u2_lang_".$_SESSION['lang'].".php";
    include "../lang_".$_SESSION['lang'].".php";    //pre navbar

}else{
    include "u2_lang_en.php";
    include "../lang_en.php";   //pre navbar

}

//novo pridane
include "../config.php";
$connect = mysqli_connect($servername, $username, $password, $dbname);


if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT * FROM predmet";
$predmety = mysqli_query($connect, $query);

?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="UTF-8">
    <title><?= _Title ?></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../styles/style.css"> <!--pre header!!-->

    <style>
        .clen, .kapitan{
            font-size: 140%;
        }
        .suhlas{
            color: lime;
        }
        .clen:hover, .kapitan:hover{
            color: palegreen;
        }
    </style>
</head>
<body>

<?php
$currentPage = "Task2";
include('../navbar.php');
?>
<main>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-1 col-md-10">
                    <h1><?= _Title ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-1 col-md-10">
                    <div class="form-group">
                        <label for="select_predmet"><?= _VybertePredmet ?></label>

                        <select class="form-control" id="select_predmet">
                            <option disabled="true" selected="true"><?= _Vyberte ?></option>
                            <?php
                            if ($predmety->num_rows > 0){
                                while($row = mysqli_fetch_assoc($predmety)) {

                                    echo "<option value = \"" . $row["id"] . "\" >" . $row["nazov"] . " " . $row["rok"] . "</option >";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-1 col-md-10 class_id_student" id="<?php echo ($_SESSION['user']['id']);?>">

                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-1 col-md-5" id="pocet_bodov">

                </div>
                <div class="col-md-5 text-right" style="margin-top: 20px;" id="pridelit_body">

                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="container">
            <div class="row">
                <div id="tabulka_pridelovania" class="col-lg-offset-1 col-md-10">

                </div>
            </div>
        </div>
    </div>

</main>
<script>
    function changeLang(){
        document.getElementById('form_lang').submit();
    }
</script>
<script>
    var body = 0;
    var tim = 0;
    var sub = 0;
    var buttonPressed = 0;
    var timer;

    $(document).ready(function(){
    $(document).on('change','#select_predmet',function(){
        $('#pocet_bodov').empty();
        $('#tabulka_pridelovania').empty();
        $('#pridelit_body').empty();
        $('.class_id_student').empty();

        var pole = [];

        var student_id = $('.class_id_student').attr('id');

        sub = $(this).val();

        pole[0] = sub;
        pole[1] = student_id;

        $.ajax({
            type:"POST",
            url:"u2_get_team.php",
            dataType: 'json',
            data:{pole:pole},
            success:function(data){
                if (data[0] == undefined){
                    $('.class_id_student').append("<h2><?= _Timnenajdeny ?></h2>");
                }
                else{
                    tim = data[0];
                    pole[0] = sub;
                    pole[1] = tim;
                    $('.class_id_student').append("<h2><?= _Tim ?> " + data[1] + "</h2>");

                    $.ajax({
                        type:"POST",
                        url:"u2_fetch_body.php",
                        data:{pole:pole},
                        success:function(data){
                            if (data == ""){
                                console.log(data);
                                $('#pocet_bodov').append("<h3><?= _Zaznamynebolinajdene ?></h3>");
                            }
                            else{
                                body = data;
                                $('#pocet_bodov').append("<h3><?= _Pocetnepridelenychbodov ?>: " + data + "</h3>");

                                $('#pridelit_body').append("<button class=\"btn btn-primary\" type=\"button\" id=\"pridelit_body_btn\"><?= _Pridelitbody ?></button>");


                                $.ajax({
                                    type:"POST",
                                    url:"u2_fetch_team.php",
                                    data:{pole:pole},
                                    success:function(data){
                                        if (data[0] == undefined){

                                        }
                                        else{
                                            var op = [];
                                            op += '<div class="table-responsive text-center"><table class="table table-striped"><thead><tr><th class="text-center">Email</th><th class="text-center"><?= _Meno ?></th><th class="text-center"><?= _Body ?></th><th class="text-center"><?= _Suhlaskapitana ?></th><th class="text-center"><?= _Suhlasclena ?></th></tr></thead><tbody>';
                                            for(var i=0;i<data.length;i++){
                                                op += data[i];
                                            }
                                            op += '</tbody></table></div><small class="form-text text-muted"><?= _fajocku ?></small>';
                                            $('#tabulka_pridelovania').append(op);

                                            clearInterval(timer);
                                            timer = setInterval(loadTable, 2000);
                                        }
                                    },
                                    error:function(){
                                        console.log("...");
                                    }
                                });
                            }
                        },
                        error:function(){
                            $('#pocet_bodov').append("<h2 style='color: red'><?= _Niekdenastalachyba ?></h2>");
                        }
                    });
                }
            },
            error:function(){
                $('#pocet_bodov').append("<h2 style='color: red'><?= _Niekdenastalachyba ?></h2>");
            }
        });

        // pole[0] = sub;
        // pole[1] = tim;
        //console.log(pole[1]);
        //$.ajax({
        //    type:"POST",
        //    url:"u2_fetch_body.php",
        //    data:{pole:pole},
        //    success:function(data){
        //        if (data == ""){
        //            console.log(data);
        //            $('#pocet_bodov').append("<h3><?//= _Zaznamynebolinajdene ?>//</h3>");
        //        }
        //        else{
        //            body = data;
        //            $('#pocet_bodov').append("<h3><?//= _Pocetnepridelenychbodov ?>//: " + data + "</h3>");
        //
        //            $('#pridelit_body').append("<button class=\"btn btn-primary\" type=\"button\" id=\"pridelit_body_btn\"><?//= _Pridelitbody ?>//</button>");
        //        }
        //    },
        //    error:function(){
        //        $('#pocet_bodov').append("<h2 style='color: red'><?//= _Niekdenastalachyba ?>//</h2>");
        //    }
        //});

        //$.ajax({
        //    type:"POST",
        //    url:"u2_fetch_team.php",
        //    data:{pole:pole},
        //    success:function(data){
        //        if (data[0] == undefined){
        //
        //        }
        //        else{
        //            var op = [];
        //            op += '<div class="table-responsive text-center"><table class="table table-striped"><thead><tr><th class="text-center">Email</th><th class="text-center"><?//= _Meno ?>//</th><th class="text-center"><?//= _Body ?>//</th><th class="text-center"><?//= _Suhlaskapitana ?>//</th><th class="text-center"><?//= _Suhlasclena ?>//</th></tr></thead><tbody>';
        //            for(var i=0;i<data.length;i++){
        //                op += data[i];
        //            }
        //            op += '</tbody></table></div><small class="form-text text-muted"><?//= _fajocku ?>//</small>';
        //            $('#tabulka_pridelovania').append(op);
        //
        //            clearInterval(timer);
        //            timer = setInterval(loadTable, 2000);
        //        }
        //    },
        //    error:function(){
        //        console.log("...");
        //    }
        //});


    });
    $(document).on('click','#pridelit_body_btn',function(){
        buttonPressed = 1;
        $('.input_dis').each(function() {
            if (!this.value){
                $(this).prop('disabled', false);
                $(this).attr('max', body);
            }
        });

    });

    $(document).on('click','.kapitan',function(){
        var id_faj = $(this).attr('id');
        var jq_id_faj = "#" + id_faj;
        var id = id_faj.slice(0, -1);
        var id_inp = "#" + id + "i";
        var val = $(id_inp).val();

        if ($(id_inp).prop('disabled') == false){
            if (!$(id_inp).val()){
                alert("<?= _Nepridelilistebody ?>");
            }
            else{
                if (parseInt(body) >= parseInt(val)){
                    body -=val;

                    var pole = [];
                    pole[0] = id;
                    pole[1] = tim;
                    pole[2] = sub;
                    pole[3] = val;
                    pole[4] = body;

                    $.ajax({
                        type:"POST",
                        url:"u2_update_kap.php",
                        data:{pole:pole},
                        success:function(data){
                            $('#pocet_bodov').empty();
                            $('#pocet_bodov').append("<h3><?= _Pocetnepridelenychbodov ?>: " + body + "</h3>");
                            $(jq_id_faj).addClass("suhlas");
                            $(id_inp).prop('disabled', 'true');
                        },
                        error:function(){
                            $('#pocet_bodov').empty();
                            $('#pocet_bodov').append("<h2 style='color: red'><?= _Niekdenastalachyba ?></h2>");
                        }
                    });
                    timer = setInterval(loadTable, 2000);
                }
                else{
                    alert("<?= _Prekrocilistepridelenypocetbodov ?>");
                    console.log(body);
                    console.log(val);
                }
            }
        }
        else{
            alert("<?= _Niestekapitantimu ?>");
        }
    });

    $(document).on('click','.clen',function(){
        var id_faj = $(this).attr('id');
        var jq_id_faj = "#" + id_faj;
        var id = id_faj.slice(0, -1);
        var id_k_faj = "#" + id + "k"
        var id_inp = "#" + id + "i";
        var val = $(id_inp).val();

        if ($(id_k_faj).hasClass("suhlas")){

            var pole = [];
            pole[0] = id;
            pole[1] = tim;
            pole[2] = sub;
            pole[3] = val;
            pole[4] = body;

            $.ajax({
                type:"POST",
                url:"u2_update_clen.php",
                data:{pole:pole},
                success:function(data){
                    $(jq_id_faj).addClass("suhlas");
                },
                error:function(){
                    $('#pocet_bodov').empty();
                    $('#pocet_bodov').append("<h2 style='color: red'><?= _Niekdenastalachyba ?></h2>");
                }
            });
        }
        else{
            alert("<?= _Kapitanestenerozhodol ?>");
        }
    });

    var loadTable = function() {
        var pole = [];
        pole[0] = sub;
        pole[1] = tim;

        $(document).on('focusin','.input_dis',function(){
            clearInterval(timer);
            //alert( "Handler" );
        });

        // $(document).on('focusout','.input_dis',function(){
        //     timer = setInterval(loadTable, 2000);
        // });

        $.ajax({
            type:"POST",
            url:"u2_fetch_body.php",
            data:{pole:pole},
            success:function(data){
                body = data;

                $('#pocet_bodov').empty();
                $('#pridelit_body').empty();

                $('#pocet_bodov').append("<h3><?= _Pocetnepridelenychbodov ?>: " + data + "</h3>");
                $('#pridelit_body').append("<button class=\"btn btn-primary\" type=\"button\" id=\"pridelit_body_btn\"><?= _Pridelitbody ?></button>");
            },
            error:function(){
                $('#pocet_bodov').append("<h2 style='color: red'><?= _Niekdenastalachyba ?></h2>");
            }
        });

        $.ajax({
            type:"POST",
            url:"u2_fetch_team.php",
            data:{pole:pole},
            success:function(data){
                $('#tabulka_pridelovania').empty();

                var op = [];
                op += '<div class="table-responsive text-center"><table class="table table-striped"><thead><tr><th class="text-center">Email</th><th class="text-center"><?= _Meno ?></th><th class="text-center"><?= _Body ?></th><th class="text-center"><?= _Suhlaskapitana ?></th><th class="text-center"><?= _Suhlasclena ?></th></tr></thead><tbody>';
                for(var i=0;i<data.length;i++){
                    op += data[i];
                }
                op += '</tbody></table></div><small class="form-text text-muted"><?= _fajocku ?></small>';
                $('#tabulka_pridelovania').append(op);

                if (buttonPressed == 1){
                    $("#pridelit_body_btn").trigger("click");
                }
            },
            error:function(){
                console.log("...");
            }
        });
    };

    });
</script>
</body>
</html>