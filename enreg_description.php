<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Rapport=htmlentities($_POST['ID_Rapport']);
    $Description=Securite::bdd($_POST['description']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $update=$pdo->query("UPDATE table_rapport_journalier SET Description='".$Description."' WHERE ID_Rapport=".$ID_Rapport);
        echo "1";
    }
?>