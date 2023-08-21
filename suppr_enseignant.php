<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Ecole=$_GET['Ecole'];
    $Enseignant=$_GET['Enseignant'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM enseignant WHERE `ID_Enseignant`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_enseignant.php?Ecole=".$Ecole."&Enseignant=".$Enseignant); 

    }
?>