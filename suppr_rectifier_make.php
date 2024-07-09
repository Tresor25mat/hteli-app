<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_rectifier_make WHERE `ID_Rectifier_Make`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_rectifier_make.php");
    }
?>