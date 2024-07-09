<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Province=$_GET['Province'];
    $siteName=$_GET['siteName'];
    $siteId=$_GET['siteId'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM site WHERE `ID_Site`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_site.php?Province=".$Province."&siteName=".$siteName."&siteId=".$siteId); 

    }
?>