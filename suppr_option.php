<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $Section=$_GET['Section'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_option WHERE `ID_Option`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_option.php?Ecole=".$Ecole."&Section=".$Section); 

    }
?>