<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$ID_Rapport = htmlentities($_POST['ID_Rapport']);
$Province = htmlentities($_POST['Province']);
$Site = htmlentities($_POST['Site']);
$Noc_ticket = Securite::bdd($_POST['Noc_ticket']);
$Daterap = date('Y-m-d', strtotime($_POST['Daterap']));
$PM_type = Securite::bdd($_POST['PM_type']);
$Run_hour = Securite::bdd($_POST['Run_hour']);
$DC_load = Securite::bdd($_POST['DC_load']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("UPDATE table_rapport_journalier_new SET ID_Site=?, DC_Load=?, Noc_Ticket=?, Date_Rapport=?, PM_Type=?, Run_Hour=?, Updated_By=? WHERE ID_Rapport=?");
    $params = array($Site, $DC_load, $Noc_ticket, $Daterap, $PM_type, $Run_hour, $_SESSION['user_eteelo_app']['ID_Utilisateur'], $ID_Rapport);
    $rs->execute($params);
}
?>