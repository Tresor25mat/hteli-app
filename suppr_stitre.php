<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $titleName=$_GET['titleName'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_sous_titre WHERE `ID_Sous_Titre`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_matiere.php?titleName=".$titleName); 
    }
?>