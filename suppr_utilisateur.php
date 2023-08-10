<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $ID = Securite::bdd($_GET['ID']);
    $IMG= Securite::bdd($_GET['IMG']);
    $IMG='images/Profil/'.$IMG;
    if($token==$_SESSION['user_slj_wings']['token']){
        $rs=$pdo->prepare("DELETE FROM utilisateur WHERE `ID_Utilisateur`=?");
        $params=array($ID);
        $rs->execute($params);
        @unlink($IMG);
        header("location:table_utilisateur.php"); 

    }
?>