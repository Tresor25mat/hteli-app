<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Annee=$_POST['ID'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE annee SET Libelle_Annee=? WHERE ID_Annee=?");
        $params=array($Design, $ID_Annee);
        $rs->execute($params);
        echo "1";
    }
?>