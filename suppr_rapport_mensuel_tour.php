<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $User=$_GET['User'];
    $siteId=$_GET['siteId'];
    $TowerType=$_GET['TowerType'];
    $dateRapport=$_GET['dateRapport'];
    $Fichier='documents/'.$_GET['Fichier'];
    $Rapport = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("DELETE FROM table_rapport_mensuel_tour WHERE `ID_Rapport`=?");
        $params=array($Rapport);
        $delete=$pdo->query("DELETE FROM questionnaire_rapport_tour WHERE `ID_Rapport`=".$Rapport);
        $rs->execute($params);
        @unlink($Fichier);
        header("location:table_rapport_mensuel_tour.php?User=".$User."&siteId=".$siteId."&TowerType=".$TowerType."&dateRapport=".$dateRapport); 
    }
?>