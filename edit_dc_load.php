<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Dc=$_POST['ID'];
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_dc_load SET Design_Dc=? WHERE ID_Dc=?");
        $params=array($Design, $ID_Dc);
        $rs->execute($params);
        echo "1";
    }
?>