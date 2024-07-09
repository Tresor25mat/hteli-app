<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Titre=htmlentities($_POST['ID_Titre']);
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_titre_new SET Design_Titre=? WHERE ID_Titre=?");
        $params=array($Design, $ID_Titre);
        $rs->execute($params);
        echo "1";
    }
?>