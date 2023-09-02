<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Frais=$_GET['Frais'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM tranche_frais WHERE `ID_Tranche_Frais`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_tranche_frais.php?Frais=".$Frais); 

    }
?>