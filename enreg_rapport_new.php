<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Province = htmlentities($_POST['Province']);
$Site = htmlentities($_POST['Site']);
$Noc_ticket = Securite::bdd($_POST['Noc_ticket']);
$Daterap = date('Y-m-d', strtotime($_POST['Daterap']));
$PM_type = Securite::bdd($_POST['PM_type']);
$Run_hour = Securite::bdd($_POST['Run_hour']);
$DC_load = Securite::bdd($_POST['DC_load']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("INSERT INTO table_rapport_journalier_new (ID_Site, DC_Load, Noc_Ticket, Date_Rapport, PM_Type, Run_Hour, ID_Utilisateur) VALUES (?,?,?,?,?,?,?)");
    $params = array($Site, $DC_load, $Noc_ticket, $Daterap, $PM_type, $Run_hour, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
    $rs->execute($params);
    $select = $pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_journalier_new");
    $selects = $select->fetch();
    echo $selects['ID_Rapport'];
}
?>