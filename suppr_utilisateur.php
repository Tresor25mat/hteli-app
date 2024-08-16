<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $ID = Securite::bdd($_GET['ID']);
    $IMG= Securite::bdd($_GET['IMG']);
    $Pays=htmlentities($_GET['Pays']);
    $UserName=htmlentities($_GET['UserName']);
    $IMG='images/Profil/'.$IMG;
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM utilisateur WHERE `ID_Utilisateur`=?");
        $params=array($ID);
        $rs->execute($params);
        $delete=$pdo->query("DELETE FROM utilisateur_site WHERE `ID_Utilisateur`=".$ID);
        @unlink($IMG);
        header("location:table_utilisateur.php?Pays=".$Pays."&UserName=".$UserName); 

    }
?>