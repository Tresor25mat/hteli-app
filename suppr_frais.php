<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $Option=$_GET['Option'];
    $Niveau=$_GET['Niveau'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM classe_frais WHERE `ID_Classe_Frais`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_frais.php?Ecole=".$Ecole."&Option=".$Option."&Niveau".$Niveau); 
    }
?>