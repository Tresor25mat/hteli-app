<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM section WHERE `ID_Section`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_section.php?Ecole=".$Ecole); 

    }
?>