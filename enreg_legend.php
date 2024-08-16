<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Legend = Securite::bdd($_POST['Legend']);
$ID_Rapport = htmlentities($_POST['ID_Rapport']);
$Indice = htmlentities($_POST['Indice']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $update = $pdo->query("UPDATE table_photo_quality SET Legend_Photo='" . $Legend . "' WHERE ID_Rapport=" . $ID_Rapport ." AND Indice=" . $Indice);
    echo "1";
}
?>