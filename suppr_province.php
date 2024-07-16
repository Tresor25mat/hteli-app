<?php
session_start();
require_once ("connexion.php");
$token = $_GET['token'];
$Pays = $_GET['Pays'];
$ID = Securite::bdd($_GET['ID']);
if ($token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("DELETE FROM province WHERE `ID_Prov`=?");
    $params = array($ID);
    $rs->execute($params);
    header("location:table_province.php?Pays=" . $Pays);
}
?>