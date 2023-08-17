<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE etablissement SET Active=0 WHERE `ID_Etablissement`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_ecole.php"); 

    }
?>