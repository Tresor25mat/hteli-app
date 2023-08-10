<?php
    session_start();
    require_once ("connexion.php");
    $Login=Securite::bdd($_POST['Login']);
    $rech=$pdo->query("SELECT * FROM utilisateur WHERE UPPER(Login)='".strtoupper($Login)."'");
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        echo "1";
    }
?>