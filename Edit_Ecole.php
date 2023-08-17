<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Etablissement=$_POST['ID'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE etablissement SET Design_Etablissement=? WHERE ID_Etablissement=?");
        $params=array($Design, $ID_Etablissement);
        $rs->execute($params);
        echo "1";
    }
?>