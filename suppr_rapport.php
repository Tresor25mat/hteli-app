<?php
    session_start();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $User=$_GET['User'];
    $siteId=$_GET['siteId'];
    $nocTicket=$_GET['nocTicket'];
    $dateRapport=$_GET['dateRapport'];
    $Fichier='documents/'.$_GET['Fichier'];
    $Rapport = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $selection=$pdo->query("SELECT * FROM table_titre_rapport WHERE ID_Rapport=".$Rapport);
        while($selections=$selection->fetch()){
            $photo=$pdo->query("SELECT * FROM table_photo_rapport WHERE ID_Titre_Rapport=".$selections['ID_Titre_Rapport']);
            while($photos=$photo->fetch()){
                $IMG='images/rapports/'.$photos['Photo'];
                @unlink($IMG);
                $delete_photo=$pdo->query("DELETE FROM table_photo_rapport WHERE ID_Photo=".$photos['ID_Photo']);
            }
        }
        $rs=$pdo->prepare("DELETE FROM table_rapport_journalier WHERE `ID_Rapport`=?");
        $params=array($Rapport);
        $rs->execute($params);
        @unlink($Fichier);
        $delete=$pdo->query("DELETE FROM table_titre_rapport WHERE `ID_Rapport`=".$Rapport);
        header("location:table_rapport.php?User=".$User."&siteId=".$siteId."&nocTicket=".$nocTicket."&dateRapport=".$dateRapport); 
    }
?>