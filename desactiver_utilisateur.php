<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Pays=htmlentities($_GET['Pays']);
    $ID = Securite::bdd($_GET['ID']);
    $UserName=htmlentities($_GET['UserName']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE utilisateur SET Active=0 WHERE `ID_Utilisateur`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_utilisateur.php?Pays=".$Pays."&UserName=".$UserName); 

    }
?>