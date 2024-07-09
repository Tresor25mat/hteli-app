<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $User=$_GET['User'];
    $siteId=$_GET['siteId'];
    $SiteType=$_GET['SiteType'];
    $dateRapport=$_GET['dateRapport'];
    $Rapport = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_rapport_janitorial WHERE `ID_Rapport`=?");
        $params=array($Rapport);
        $delete=$pdo->query("DELETE FROM questionnaire_janitorial WHERE `ID_Rapport`=".$Rapport);
        $rs->execute($params);
        header("location:table_janitorial.php?User=".$User."&siteId=".$siteId."&SiteType=".$SiteType."&dateRapport=".$dateRapport); 
    }
?>