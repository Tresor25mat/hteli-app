<?php
session_start();
require_once ("connexion.php");
$token = $_POST['token'];
$Rapport = $_POST['Rapport'];
if ($token == $_SESSION['user_eteelo_app']['token']) {
    $selection = $pdo->query("SELECT * FROM table_photo_quality WHERE ID_Rapport=" . $Rapport);
    while ($selections = $selection->fetch()) {
        $IMG = 'images/rapports/' . $selections['Photo'];
        @unlink($IMG);
        $delete_photo = $pdo->query("DELETE FROM table_photo_quality WHERE ID_Photo=" . $selections['ID_Photo']);
    }
    $rs = $pdo->prepare("DELETE FROM table_rapport_quality WHERE `ID_Rapport`=?");
    $params = array($Rapport);
    $rs->execute($params);
}
?>