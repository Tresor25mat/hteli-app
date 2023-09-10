<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $Annee=$_GET['Annee'];
    $Classe=$_GET['Classe'];
    $Eleve=$_GET['Eleve'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM inscription WHERE `ID_Inscription`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_inscription.php?Ecole=".$Ecole."&Annee=".$Annee."&Classe".$Classe."&Eleve".$Eleve); 
    }
?>