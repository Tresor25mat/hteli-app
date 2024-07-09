<?php
session_start();
require_once ("connexion.php");
$token = $_POST['token'];
$Rapport = $_POST['Rapport'];
if ($token == $_SESSION['user_eteelo_app']['token']) {
    $selection = $pdo->query("SELECT * FROM table_titre_rapport_new WHERE ID_Rapport=" . $Rapport);
    while ($selections = $selection->fetch()) {
        $photo = $pdo->query("SELECT * FROM table_photo_rapport_new WHERE ID_Titre_Rapport=" . $selections['ID_Titre_Rapport']);
        while ($photos = $photo->fetch()) {
            $IMG = 'images/rapports/' . $photos['Photo'];
            @unlink($IMG);
            $delete_photo = $pdo->query("DELETE FROM table_photo_rapport_new WHERE ID_Photo=" . $photos['ID_Photo']);
        }
    }
    $rs = $pdo->prepare("DELETE FROM table_rapport_journalier_new WHERE `ID_Rapport`=?");
    $params = array($Rapport);
    $rs->execute($params);
    $delete = $pdo->query("DELETE FROM table_titre_rapport_new WHERE `ID_Rapport`=" . $Rapport);
}
?>