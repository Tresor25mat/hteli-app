<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_discipline WHERE `ID_Discipline`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_discipline.php?Ecole=".$Ecole); 

    }
?>