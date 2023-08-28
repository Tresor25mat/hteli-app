<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $Categorie=$_GET['Categorie'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM compte WHERE `ID_Compte`=?");
        $params=array($ID);
        $rs->execute($params);
        $delete=$pdo->query("DELETE FROM type_frais WHERE ID_Compte=".$ID);
        header("location:table_compte.php?Ecole=".$Ecole."&Categorie=".$Categorie); 
    }
?>