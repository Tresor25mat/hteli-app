<?php
    session_start();
    require_once ("connexion.php");
    $token=$_POST['token'];
    $Rapport=$_POST['Rapport'];
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_rapport_mensuel_tour WHERE `ID_Rapport`=?");
        $params=array($Rapport);
        $rs->execute($params);
    }
?>