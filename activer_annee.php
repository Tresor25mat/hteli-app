<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $update=$pdo->query("UPDATE annee SET Encours=0");
        $rs=$pdo->prepare("UPDATE annee SET Encours=1 WHERE `ID_Annee`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_annee.php"); 

    }
?>