<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
?>
<!DOCTYPE html>
<html lang="fr-FR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <title>SB Admin 2 - Bootstrap Admin Theme</title> -->

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .gonow:hover{
            font-weight: bold;
        }
    </style>

</head>

<body style="background: #FFFFFF;overflow: hidden;">

    <div id="wrapper" style="">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background: white">

            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown" style="border-right: 1px solid #E6E7E9">
                    <a class="gonow" data-toggle="dropdown" href="#" ver="situation_journaliere.php" style="color: #1E293B">
                        <i class="fa fa-table"></i>
                        Situation journalière
                    </a>
                </li>
                <li class="dropdown" style="border-right: 1px solid #E6E7E9">
                    <a class="gonow" data-toggle="dropdown" href="" ver="situation_par_classe.php" style="color: #1E293B">
                        <i class="fa fa-pencil-square"></i>
                        Situation de paiement par classe
                    </a>
                </li>
                <li class="dropdown" style="border-right: 1px solid #E6E7E9">
                    <a class="gonow" data-toggle="dropdown" href="" ver="situation_par_eleve.php" style="color: #1E293B">
                        <i class="fa fa-male"></i>
                        Situation de paiement par élève
                    </a>
                </li>
<!--                 <li class="dropdown">
                    <a class="gonow" data-toggle="dropdown" href="" ver="accueil.php">
                        <i class="fa fa-search"></i>
                        Recherche d'un paiement
                    </a>
                </li> -->
                <li class="dropdown" style="border-right: 1px solid #E6E7E9">
                    <a href="#" id="retour" class="gonow" style="color: #1E293B">
                        <i class="fa fa-reply-all"></i>
                        Retour
                    </a>
                </li>
            </ul>
            <!-- /.navbar-top-links -->            
            <!-- /.navbar-static-side -->
        </nav>        
        <!-- /#page-wrapper -->
    </div>
    <!-- <div id="page-wrapper"> -->
        <div class="row">
            <div class="col-lg-12">
                    <iframe style="width: 100%; height: 2320px" id="iframe" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" src="situation_journaliere.php"></iframe>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- </div>  -->
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="js/jquery.slimscroll.min.js"></script> -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
    <!-- <script src="js/jquery.nicescroll.js"></script> -->
    <!--common script for all pages-->
<!--     <script src="js/scripts.js"></script> -->
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script>
        $('.gonow').click(function(e){
        e.preventDefault();
        $('#iframe').attr("src",$(this).attr("ver"));
        });
        $('#retour').click(function(){
            window.location.replace('Dashio/accueil.php');
        })
    </script>
</body>

</html>

