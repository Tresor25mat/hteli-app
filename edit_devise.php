<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token'];
    $ID_Taux=htmlentities($_POST['ID_Taux']);
    $Montant=htmlentities($_POST['Montant']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_taux SET Montant=? WHERE ID_Taux_Change=?");
        $params=array($Montant, $ID_Taux);
        $rs->execute($params);
        echo "1";
    }
?>