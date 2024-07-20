<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Titre=htmlentities($_POST['ID_Titre']);
    $Client=htmlentities($_POST['Client']);
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_titre SET ID_Cient=?, Design_Titre=? WHERE ID_Titre=?");
        $params=array($Client, $Design, $ID_Titre);
        $rs->execute($params);
        echo "1";
    }
?>