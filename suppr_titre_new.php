<?php
session_start();
require_once ("connexion.php");
$token = $_GET['token'];
$titleName = $_GET['titleName'];
$ID = Securite::bdd($_GET['ID']);
if ($token == $_SESSION['user_eteelo_app']['token']) {
    $rs = $pdo->prepare("DELETE FROM table_titre_new WHERE `ID_Titre`=?");
    $params = array($ID);
    $rs->execute($params);
    $delete = $pdo->query("DELETE FROM table_sous_titre_new WHERE `ID_Titre`=" . $ID);
    header("location:table_matiere_new.php?titleName=" . $titleName);

}
?>