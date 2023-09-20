<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Paiement=$_GET['Paiement'];
    $Ecole=$_GET['Ecole'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM paiement_frais WHERE `ID_Paiement_Frais`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_paiement_frais.php?Paiement=".$Paiement."&Ecole=".$Ecole); 

    }
?>