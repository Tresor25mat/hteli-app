<?php
session_start();
require_once ("connexion.php");
$token = $_GET['token'];
$Photo = $_GET['Photo'];
$IMG = $_GET['IMG'];
$ID = $_GET['ID'];
$Titre = $_GET['Titre'];
if ($token == $_SESSION['user_eteelo_app']['token']) {
    @unlink($IMG);
    $delete_photo = $pdo->query("DELETE FROM table_photo_rapport_new WHERE ID_Photo=" . $Photo);
    header("location:afficher_image_new.php?ID=" . $ID . "&Titre=" . $Titre);
}
?>